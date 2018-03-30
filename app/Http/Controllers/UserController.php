<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{User, Flow, Profile, Salary};
use Adldap;
use Image;

class UserController extends Controller
{

   	public function list(Request $request)
    {
        $sort = $_GET['sort'] ?? 'name';
        $order = $_GET['order'] ?? 'asc';

        //$request->keyword
        $whereClause = [
            ['rusname','like','%'.$request->keyword.'%'],
        ];

        $users = User::with('flow','currentProfile','mentor')->where(function($q) use ($request) {

            if ($request->keyword)
            {
                $q  -> where('rusname','like','%'.$request->keyword.'%')
                    -> orWhere('name','like','%'.$request->keyword.'%')
                    -> orWhere('title','like','%'.$request->keyword.'%')
                    -> orWhere('login','like','%'.$request->keyword.'%');
            }

        })->orderBy($sort,$order)->paginate(100);

        $users->appends(request()->input());

		$order = $order=='asc' ? 'desc' : 'asc';

        return view('user.list',[
        	'users'=>$users,
        	'sort'=>$sort,
        	'order'=>$order
        ]);
    }

    public function form(User $user, Request $request)
    {
        $this->authorize('update', $user);

        $flows = Flow::orderBy('name','asc')->get()->pluck('name','id');
        $flows = [0=>'Укажите поток']+$flows->toArray();

        $users = User::orderBy('name','asc')->get()->pluck('name','id');
        $users = [0=>'Укажите ответственного']+$users->toArray();

        // $profiles = Profile::orderBy('name','asc')->pluck('name','id');
        // $profiles = [0=>'Укажите профиль']+$profiles->toArray();

        $profiles = [0=>'Укажите профиль'];
        foreach(Flow::orderBy('name','asc')->get() as $f)
        {
            $profiles[$f->name] = $f->profiles()->orderBy('grade','asc')->orderBy('order','asc')->pluck('name','id')->toArray();
        }

        return view('user.form',[
            'user'=>$user,
            'flows'=>$flows,
            'users'=>$users,
            'profiles'=>$profiles
        ]);
    }

    public function store(Request $request)
    {
        if ($request->id)
            $this->authorize('update', User::find($request->id));
        else
            $this->authorize('update', new User);

        $this->validate($request, [
            'login' => 'required|unique:users,login,'.$request->id.',id',
            'name' => 'required'
        ]);

        $data = $request->all();
        $data['email'] = $data['login'].config('app.domain');

        $Mentor = User::where('name',$request->mentor)->first();

        $data['mentor_user_id'] = $Mentor->id ?? 0;
        unset($data['mentor']);

        if (!isset($data['admin']))
            $data['admin'] = 0;

        //dd($data);

        $user = User::updateOrCreate(['id'=>$request->id],$data);

        if (!$request->id)
            $user->notify(new \App\Notifications\UserAdded($user));

        if ($request->backTo)
            return redirect($request->backTo);
        else
        {
            if ($request->user()->admin)
                return redirect('/admin/users');
            else
                return redirect('/myemployees');
        }
    }

    public function delete(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect('/admin/users');
    }

    public function getFromLDAP($login)
    {
    	$aduser = Adldap::search()->where('mail',$login.config('app.domain'))->first();

    	if (!$aduser)
    		return json_encode(['found'=>0]);

		$data['found'] = 1;
		$data['name'] = $aduser->cn[0];
        $data['rusname'] = $aduser->st[0];
        $data['employeenumber'] = $aduser->employeenumber[0] ?? '0';
        $data['email'] = $aduser->mail[0];
        $data['phone'] = $aduser->facsimiletelephonenumber[0];
        $data['title'] = $aduser->title[0];
        $data['department'] = $aduser->department[0];
        $data['login'] = $login;
        $data['password'] = '';

        $avatar = '';
        if ($aduser->thumbnailphoto[0])
        {
            $img = Image::make($aduser->thumbnailphoto[0]);
            $avatar = (string)$img->encode('jpg', 85)->encode('data-url');
        }

        $data['avatar'] = $avatar;

    	return json_encode($data);
    }

    public function syncUserWithAD(User $user, Request $request)
    {
        if (!$user->id)
            return false;

        $aduser = json_decode($this->getFromLDAP($user->login));

        $user->title = $aduser->title;
        $user->department = $aduser->department;
        $user->phone = $aduser->phone;

        if (!$user->avatar && $aduser->avatar)
            $user->avatar = $aduser->avatar;

        $user->save();

        if ($request->backTo)
            return redirect($request->backTo);
        else
        {
            if ($request->user()->id == $user->id)
                return redirect('/profile');
            else
                return redirect('/myemployees/'.$user->id);
        }

    }

    public function profile(User $user)
    {
        $myProfile = false;
        $H1 = "Профиль сотрудника";
        if (!isset($user->id))
        {
            $H1 = trans('messages.MyProfile');
            $user = \Auth::user();
            $myProfile = true;
        }

        $this->authorize('view',$user);


        $evaluations = [];
        $last_evaluation = null;
        $i=0;
        foreach($user->evaluations()->orderBy('updated_at','asc')->get() as $e)
        {
            $evaluations[$i]['evaluator'] = $e->evaluator->name;
            $evaluations[$i]['date'] = date('d.m.y',strtotime($e->updated_at));
            $evaluations[$i]['comment'] = $e->comment;
            $evaluations[$i]['values'] = [];

            foreach ($e->competences as $c)
            {
                $evaluations[$i]['values'][$c->id] = $c->pivot->value;
                if ($c->sublevels)
                {
                    foreach ($e->subcompetences()->where('competence_id',$c->id)->orderBy('name','asc')->get() as $sc)
                    {
                        //dd($sc);
                        $evaluations[$i]['subvalues'][$c->id][$sc->id]['name'] = $sc->name;
                        $evaluations[$i]['subvalues'][$c->id][$sc->id]['value'] = $sc->pivot->value;
                    }
                }
            }

            if ($user->id != $e->evaluator_user_id)
                $last_evaluation = $evaluations[$i];

            $i++;
        }

        //dd($evaluations);

        $gaps = [];
        $currentProfileLevels = [];
        $currentProfileNames = [];

        if ($user->currentProfile)
        {
            foreach ($user->currentProfile->competences as $c)
            {
                $currentProfileNames[$c->pivot->competence_id] = $c->name;
                $currentProfileLevels[$c->pivot->competence_id] = $c->pivot->level;
            }
        }

        if (isset($user->targetProfile) && count($user->targetProfile->competences)>0)
        {
            foreach ($user->targetProfile->competences as $c)
            {
                $targetProfileNames[$c->pivot->competence_id] = $c->name;
                $targetProfileLevels[$c->pivot->competence_id] = $c->pivot->level;
            }

            foreach ($targetProfileLevels as $c=>$l)
            {
                if (!array_key_exists($c, $currentProfileLevels))
                {
                    $currentProfileNames[$c] = $targetProfileNames[$c];
                    $currentProfileLevels[$c] = 0;
                }
            }

            foreach($currentProfileLevels as $c=>$l)
            {
                //$targetProfileLevels2[$c] = isset($targetProfileLevels[$c]) ? $targetProfileLevels[$c] : 0;
                $targetProfileLevels2[$c] = $targetProfileLevels[$c] ?? 0;
                $targetProfileNames2[$c] = $currentProfileNames[$c];

                if ($last_evaluation)
                {
                    $last_evaluation['values'][$c] = $last_evaluation['values'][$c] ?? 0;

                    if ($targetProfileLevels2[$c] > $last_evaluation['values'][$c])
                    {
                        $gaps[$c]['competence'] = $currentProfileNames[$c];
                        $gaps[$c]['from'] = $currentProfileLevels[$c];
                        $gaps[$c]['to'] = $targetProfileLevels2[$c];
                    }
                }
                else
                {
                    if ($targetProfileLevels2[$c] > $currentProfileLevels[$c])
                    {
                        $gaps[$c]['competence'] = $currentProfileNames[$c];
                        $gaps[$c]['from'] = $currentProfileLevels[$c];
                        $gaps[$c]['to'] = $targetProfileLevels2[$c];
                    }
                }
            }

            $targetProfileLevels = $targetProfileLevels2;
            $targetProfileNames = $targetProfileNames2;

        }

        //dd($gaps);

        if (count($user->salary) > 0)
        {
            foreach ($user->salary()->orderBy('date','asc')->get() as $s)
            {
                //echo $s->date.':'.$s->money."<br>";
                $date_points[date('Y-m',strtotime($s->date))] = $s->money;
            }

            $first_date = $user->salary()->orderBy('date','asc')->first();
            $last_date = $user->salary()->orderBy('date','desc')->first();

            $cur_date = date('Y-m');
            $_date = date('Y-m',strtotime($first_date->date));
            $_money = $first_date->money;
            while($_date<=$cur_date)
            {
                $arr[] = $_date;
                $_label = '';
                if (array_key_exists($_date, $date_points))
                {
                    $_money = $date_points[$_date];
                    $_label = date('F Y',strtotime($_date.'-01'));
                }
                elseif (substr($_date,-2) == '01')
                    $_label = date('Y',strtotime($_date.'-01'));

                $salary_chart['labels'][] = $_label;
                $salary_chart['values'][] = $_money;

                $_date = date('Y-m',strtotime("+1 month",strtotime("$_date-01")));
            }
        }

        return view('user.profile',[
            'H1' => $H1,
            'myProfile' => $myProfile,
            'user'=>$user,
            'currentProfileNames'=>$currentProfileNames ?? null,
            'currentProfileLevels'=>$currentProfileLevels ?? null,
            'targetProfileNames'=>$targetProfileNames ?? null,
            'targetProfileLevels'=>$targetProfileLevels ?? null,
            'evaluations' => $evaluations,
            'last_evaluation' => $last_evaluation,
            'gaps' => $gaps,
            'salary_chart' => $salary_chart ?? []
        ]);
    }

    public function uploadAvatar(Request $request)
    {
        $user = \Auth::user();

        $img = Image::make($request->avatar->path());
        $avatar = (string)$img->fit(300, 300, function ($constraint) {
            $constraint->upsize();
        })->encode('jpg', 85)->encode('data-url');

        $user->avatar = $avatar;
        $user->save();

        return redirect('/');
    }

    public function myemployees(Request $request)
    {
        return view('user.employees',[
            'apprantices' => $request->user()->apprantices
        ]);
    }

    public function formSalary(User $user, Salary $salary)
    {
        $this->authorize('update', $user);

        if (isset($salary->id))
            $salary->date = implode('.',array_reverse(explode('-',$salary->date)));

        //dd($salary);

        return view('user.form-salary',[
            'user' => $user,
            'salary' => $salary,
        ]);
    }

    public function storeSalary(Request $request)
    {
        $this->validate($request,[
            'date' => 'required',
            'grade' => 'required|numeric',
            'money' => 'required|numeric'
        ]);

        $data = $request->all();
        $data['date'] = implode('-',array_reverse(explode('.',$data['date'])));

        Salary::updateOrCreate(['id'=>$request->id],$data);

        return redirect('/myemployees/'.$request->user_id.'#salary');
    }

}
