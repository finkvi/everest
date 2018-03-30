<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Program, Project, User, Flow};

class ProjectController extends Controller
{

	public function list()
    {
        $projects = Project::with('program','flows')->get();
        
        return view('project.list',['projects'=>$projects]);
    }

    public function form(Project $project)
    {
        $this->authorize('update', $project);

        $users = User::orderBy('name')->get()->pluck('name','id');
        $users = ['0'=>'Укажите руководителя проекта (РП)']+$users->toArray();

        $programs = Program::orderBy('name')->get()->pluck('name','id');
        $programs = ['0'=>'Укажите программу']+$programs->toArray();

        return view('project.form',['project'=>$project,'users'=>$users,'programs'=>$programs]);
    }

    public function store(Request $request)
    {
        $this->authorize('update', Project::class);

        $this->validate($request, [
            'program_id' => 'required|numeric|min:1',
            'name' => 'required',
            'rp_user_id' => 'required'
        ]);

        Project::updateOrCreate(['id'=>$request->id],$request->all());

        return redirect('/admin/projects');
    }

    public function delete(Project $project)
    {
        $this->authorize('delete', $project);

        $project->delete();

        return redirect('/admin/projects');
    }

    public function flowsList(Project $project)
    {
        $this->authorize('update', $project);

        $users = User::orderBy('name')->get()->pluck('name','id');
        $users = ['0'=>'Укажите Тим Лида (TL)']+$users->toArray();

        //$allflows = Flow::orderBy('name','asc')->get();
        $project->program->load('flows');
        $allflows = $project->program->flows()->orderBy('name','asc')->get();
        $pflows = $project->flows;
        $pflowsIDs = $pflows->pluck('id')->toArray();
        //dd($pflows);
        //dd($allflows);

        $TL = [];
        foreach ($pflows as $pf)
        {
            $TL[$pf->id] = $pf->pivot->tl_user_id;
        }
        //dd ($TL);
        
        return view('project.flows',['allflows'=>$allflows,'pflows'=>$pflows,'pflowsIDs'=>$pflowsIDs,'project'=>$project,'users'=>$users,'TL'=>$TL]);
    }

    public function flowStore(Request $request)
    {
        $this->authorize('update', Project::class);

        $project = Project::find($request->project_id);

        if ($request->flow)
        {
            foreach ($request->flow as $_key=>$flow_id)
            {
                $el = ['tl_user_id'=>$request->tl[$flow_id]];
                $data[$flow_id] = $el;
            }
            //dd($data);

        }
        else
            $data = [];

        $project->flows()->sync($data);

        return redirect('/admin/projects');
    }

    public function usersList(Project $project)
    {
        $this->authorize('update', $project);

        $projectFlows = $project->flows()->orderBy('name','asc')->get();
        $projectUsersIDs = $project->users()->pluck('users.id')->toArray();
        $projectUsers = $project->users()->pluck('profile_id','users.id')->toArray();

        //dd($projectUsers);

        return view('project.users',[
            'project' => $project,
            'projectFlows' => $projectFlows,
            'projectUsersIDs' => $projectUsersIDs,
            'projectUsers' => $projectUsers,
        ]);
    }

    public function usersStore(Request $request)
    {
        $this->authorize('update', Project::class);

        $project = Project::find($request->project_id);

        if ($request->users)
        {
            foreach ($request->users as $_key=>$user_id)
            {
                $el = ['profile_id'=>$request->profiles[$user_id]];
                $data[$user_id] = $el;
            }
            //dd($data);
        }
        else
            $data = [];

        $project->users()->sync($data);

        return redirect('/admin/projects');
    }

}
