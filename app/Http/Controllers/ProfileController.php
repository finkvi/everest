<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Profile, Flow};

class ProfileController extends Controller
{

    public function list()
    {
    	$flows = Flow::orderBy('name','asc')->with(['profiles'=>function($q){
    		$q->orderBy('grade','asc');
    	}])->get();
        //$profiles = Profile::with('competences')->get();
        
        //$flows = Flow::with('profiles')->find(1);

    	foreach ($flows as $f)
    	{
    		$ctbl = [];
    		$tbl[$f->id]['id'] = $f->id;
    		$tbl[$f->id]['name'] = $f->name;

            $profiles = $f->profiles()->orderBy('grade','asc')->orderBy('order','asc')->get();
            //$profiles = $f->profiles;
    		foreach ($profiles as $p)
    		{	
    			//echo $p->name.'<br>';
				$a = [];
				$a['id'] = $p->id;
				$a['name'] = $p->name;
				$a['grade'] = $p->grade;
				$tbl[$f->id]['profiles'][] = $a;

				$pc = $p->competences->pluck('pivot.level','id')->toArray();
				$pcd = $p->competences->pluck('description','id')->toArray();
				//dd($pcd);
    			foreach ($f->competences()->orderBy('name','asc')->get() as $c)
    			{
    				//echo ' * '.$c->name.' : '.$c->pivot->level.' ('.$c->description.')<br>';

					$ctbl[$p->id][$c->id]['profile'] = $p->name;
					$ctbl[$p->id][$c->id]['competence'] = $c->name;
    				$ctbl[$p->id][$c->id]['level'] = isset($pc[$c->id]) ? $pc[$c->id] : 0;
    				$ctbl[$p->id][$c->id]['description'] = isset($pcd[$c->id]) ? $pcd[$c->id] : 0;
    			}

    		}

    		$b = []; $cc = [];
    		foreach($ctbl as $a)
    		{
    			foreach ($a as $id=>$arr)
    			{
    				$b['competence'] = $arr['competence'];
    				$b['profile'] = $arr['profile'];
    				$b['level'] = $arr['level'];
    				$b['description'] = $arr['description'];
    				$cc[$id][] = $b;
    			}
    		}

			$tbl[$f->id]['competences'] = $cc;
    		//dump($cc);
			//dd($ctbl);
    		//break;
    	}

		//dd($ctbl);
    	//dd($tbl);
        return view('profile.list',['tbl'=>$tbl]);
    }

    public function form(Flow $flow, Profile $profile)
    {
        $this->authorize('update', $profile);

        $flows = Flow::orderBy('name')->get()->pluck('name','id');
        $flows = ['0'=>'Укажите поток']+$flows->toArray();

		$competencesProfile = $profile->competences->pluck('pivot.level','id')->toArray();

        return view('profile.form',['profile'=>$profile,'flows'=>$flows,'flow'=>$flow,'competencesProfile'=>$competencesProfile]);
    }

    public function store(Request $request)
    {
        $this->authorize('update', Profile::class);

        $this->validate($request, [
            'flow_id' => 'required|numeric|min:1',
            'name' => 'required',
            'grade' => 'required',
            'order' => 'numeric'
        ]);

        $input_data = $request->all();

        if (!$input_data['order'] || $input_data['order']<0)
            $input_data['order'] = 0;

        $profile = Profile::updateOrCreate(['id'=>$request->id],$input_data);

        if ($request->levels)
        {
	        foreach ($request->levels as $id => $value) 
	        {
				$el = ['level'=>$value];
				$data[$id] = $el;
	        }
	    }
        //dd($data);

	    if (isset($data))
        	$profile->competences()->sync($data);

        return redirect('/admin/profiles#flow'.$request->flow_id);
    }

    public function delete(Profile $profile)
    {
        $this->authorize('delete', $profile);

        $id = $profile->flow->id;

		$profile->competences()->detach();
        $profile->delete();

        return redirect('/admin/profiles#flow'.$id);
    }

}
