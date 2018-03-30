<?php

namespace App\Http\Controllers;

use App\{Program, User, Flow, BusinessUnit as BU};
use Illuminate\Http\Request;

class ProgramController extends Controller
{

    public function list()
    {
        $programs = Program::with('flows','users')->get();
        
        return view('program.list',['programs'=>$programs]);
    }

    public function form(Program $program)
    {
        $this->authorize('update', $program);

        $users = User::orderBy('name')->get()->pluck('name','id');
        $users = ['0'=>'Укажите руководителя (PL)']+$users->toArray();

        $BUs = BU::orderBy('name')->get()->pluck('name','id');
        $BUs = ['0'=>'Укажите БЮ']+$BUs->toArray();

        return view('program.form',['program'=>$program,'users'=>$users,'BUs'=>$BUs]);
    }

    public function store(Request $request)
    {
        $this->authorize('update', Program::class);

        $this->validate($request, [
            'business_unit_id' => 'required|numeric|min:1',
            'name' => 'required',
            'dp_user_id' => 'required'
        ]);

        Program::updateOrCreate(['id'=>$request->id],$request->all());

        return redirect('/admin/programs');
    }

    public function delete(Program $program)
    {
        $this->authorize('delete', $program);

        $program->delete();

        return redirect('/admin/programs');
    }

    public function flowsList(Program $program)
    {
        $this->authorize('update', $program);

        $users = User::orderBy('name')->get()->pluck('name','id');
        $users = ['0'=>'Укажите Программного Лидера (PL)']+$users->toArray();

        $allflows = Flow::orderBy('name','asc')->get();
        $pflows = $program->flows;
        $pflowsIDs = $pflows->pluck('id')->toArray();
        //dd($pflows);

        $pfPL = [];
        foreach ($pflows as $pf)
        {
            $pfPL[$pf->id] = $pf->pivot->pl_user_id;
        }
        //dd ($pfPL);
        
        return view('program.flows',['allflows'=>$allflows,'pflows'=>$pflows,'pflowsIDs'=>$pflowsIDs,'program'=>$program,'users'=>$users,'pfPL'=>$pfPL]);
    }

    public function flowStore(Request $request)
    {
        $this->authorize('update', Program::class);

        $program = Program::find($request->program_id);
        foreach ($request->flow as $_key=>$flow_id)
        {
            $el = ['pl_user_id'=>$request->pl[$flow_id]];
            $data[$flow_id] = $el;
        }
        //dd($data);

        $program->flows()->sync($data);

        return redirect('/admin/programs');
    }

    public function usersList(Program $program)
    {
        $this->authorize('update', $program);

        $programUsers = $program->users->pluck('id')->toArray();

        $flows = $program->flows()->with('users')->get();        
        
        return view('program.users',['program'=>$program, 'flows'=>$flows, 'programUsers'=>$programUsers]);
    }

    public function usersStore(Request $request)
    {
        //dump($request->program_id);
        //dd($request->users);

        $program = Program::find($request->program_id);
        $program->users()->sync($request->users);

        return redirect('/admin/programs');
    }

}
