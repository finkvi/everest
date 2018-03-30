<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Competence;
use App\User;

class TaskController extends Controller
{
    public function form(User $user, Competence $competence, Task $task)
    {
    	return view('task.form',[
    		'task' => $task,
    		'competence' => $competence,
    		'user' => $user,
    	]);
    }

    public function store(Request $request)
    {
    	$this->validate($request,[
    		'title' => 'required',
    		'task' => 'required'
    	]);

    	$data = $request->all();
    	$data['creator_user_id'] = $request->user()->id;

        $user = User::find($request->user_id);
    	$task = $user->tasks()->updateOrCreate(['id'=>$request->id],$data);
    	//dd($task);

        $user->notify(new \App\Notifications\TaskAdded($task,$request->user()));
    	
    	return redirect('/myemployees/'.$task->user_id.'#tasks');
    }

    public function complete(Task $task)
    {
    	$task->completed = 1;
    	$task->save();

        $task->creator->notify(new \App\Notifications\TaskCompleted($task,\Auth::user()));

    	die;
    }

    public function confirm(Task $task)
    {
    	$task->confirmed = 1;
    	$task->save();

        $task->user->notify(new \App\Notifications\TaskConfirmed($task,\Auth::user()));

    	die;
    }

}
