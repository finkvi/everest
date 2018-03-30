<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Evaluation;

class EvaluationController extends Controller
{
    public function form(User $user, Evaluation $evaluation)
    {

        if (!$user->id)
            $user = \Auth::user();

        $evaluations = [];
        $last_evaluation = [];
        $i=0;
        foreach($user->evaluations()->orderBy('updated_at','asc')->get() as $e)
        {
            $evaluations[$i]['values'] = [];
            
            foreach ($e->competences as $c)
            {
                $evaluations[$i]['values'][$c->id] = $c->pivot->value;
                $evaluations[$i]['description'][$c->id] = isset($c->levels()->where('level',$c->pivot->value)->first()->description) ? $c->levels()->where('level',$c->pivot->value)->first()->description : '-';
            }

            if ($user->id != $e->evaluator_user_id)
            {
                $last_evaluation = $evaluations[$i];

                if (count($e->subcompetences)>0)
                {
                    foreach($e->subcompetences as $sc)
                    {
                        $last_evaluation['subvalues'][$sc->id] = $sc->pivot->value;
                    }
                }
            }

            $i++;
        }

        if (!$last_evaluation)
        {

            foreach ($user->currentProfile->competences as $c)
            {
                //$currentProfileNames[$c->pivot->competence_id] = $c->name;
                //$currentProfileLevels[$c->pivot->competence_id] = $c->pivot->level;

                $last_evaluation['values'][$c->pivot->competence_id] = $c->pivot->level;
                $last_evaluation['description'][$c->pivot->competence_id] = $c->description;

            }

        }

        //dd($last_evaluation);

    	if (!isset($user->id))
    	{
    		$H1 = 'Самооценка';
    		$user = \Auth::user();
    	}
    	else
    		$H1 = 'Оценка сотрудника '.$user->name;
    	

    	return view('evaluation.form',[
    		'H1' => $H1,
    		'evaluation' => $evaluation,
    		'user' => $user,
    		'competences' => $user->targetProfile->competences,
            'last_evaluation' => $last_evaluation,
    	]);
    }

    public function store(Request $request)
    {
    	$data = $request->all();
    	$data['evaluator_user_id'] = \Auth::user()->id;
    	$evaluation = Evaluation::updateOrCreate(['id'=>$request->id],$data);

    	$data2 = [];
		if ($request->levels)
        {
	        foreach ($request->levels as $id => $value) 
	        {
				$el = ['value'=>$value];
				$data2[$id] = $el;
	        }
	    }

    	$evaluation->competences()->sync($data2);

        $data3 = [];
        if ($request->sublevels)
        {
            foreach ($request->sublevels as $id => $value) 
            {
                $el = ['value'=>$value];
                $data3[$id] = $el;
            }
        }

        $evaluation->subcompetences()->sync($data3);
        

        if ($request->user_id != \Auth::user()->id)
            User::find($request->user_id)->notify(new \App\Notifications\EvaluationMade($request->user()));

    	if ($data['evaluator_user_id'] == $data['user_id'])
    		return redirect('/profile');
    	else
    		return redirect('/myemployees/'.$data['user_id']);
    	
    }
}
