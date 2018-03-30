<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Flow, User, Competence};
use App\BusinessUnit as BU;

class FlowController extends Controller
{

    public function list()
    {
    	$flows = Flow::all();

    	return view('flow.list',['flows'=>$flows]);
    }

    public function form(Flow $flow)
    {
    	$this->authorize('update', $flow);

    	$users = User::orderBy('name')->get()->pluck('name','id');
		$users = ['0'=>'Укажите руководителя (FLP)']+$users->toArray();

		$BUs = BU::orderBy('name')->get()->pluck('name','id');
		$BUs = ['0'=>'Укажите БЮ']+$BUs->toArray();


    	return view('flow.form',['flow'=>$flow,'users'=>$users,'BUs'=>$BUs]);
    }

    public function store(Request $request)
    {
    	$this->authorize('update', Flow::class);

    	$this->validate($request, [
    		'business_unit_id' => 'required|numeric|min:1',
    		'name' => 'required',
    		'flp_user_id' => 'required|numeric|min:1'
    	],[
    		'business_unit_id.min' => 'Укажите BU',
    		'flp_user_id.min' => 'Укажите FLP'
    	]);

    	Flow::updateOrCreate(['id'=>$request->id],$request->all());

    	return redirect('/admin/flows');
    }

    public function delete(Flow $flow)
    {
    	$this->authorize('delete', $flow);

    	$flow->delete();

    	return redirect('/admin/flows');
    }

    public function usersList(Flow $flow)
    {
        $this->authorize('update', $flow);

        $users = User::where('flow_id',0)->orWhere('flow_id',$flow->id)->orderBy('name')->get();

        return view('flow.users',['flow'=>$flow, 'users'=>$users]);
    }

    public function usersStore(Request $request)
    {
        User::where('flow_id',$request->flow_id)->update(['flow_id'=>0]);

        foreach ($request->users as $user_id)
        {
            $user = User::find($user_id);
            $user->flow_id = $request->flow_id;
            $user->save();
        }

        return redirect('/admin/flows');
    }

    public function listCompetences(Flow $flow)
    {
        $this->authorize('update', $flow);

        $competences = Competence::orderBy('name')->get();
        $flowCompetences = $flow->competences->pluck('id')->toArray();

        return view('flow.competences',['flow'=>$flow, 'competences'=>$competences, 'flowCompetences'=>$flowCompetences]);
    }

    public function storeCompetences(Request $request)
    {
        $flow = Flow::find($request->flow_id);
        $flow->competences()->sync($request->competences);

        return redirect('/admin/flows');
    }

}
