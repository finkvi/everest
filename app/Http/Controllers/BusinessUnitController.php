<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BusinessUnit as BU;
use App\User;

class BusinessUnitController extends Controller
{
    public function list()
    {
    	$BUs = BU::all();
    	
    	return view('businesunit.list',['BUs'=>$BUs]);
    }

    public function form(BU $bu)
    {
        $this->authorize('update', $bu);

    	$users = User::orderBy('name')->get()->pluck('name','id');

		$users = ['0'=>'Укажите руководителя']+$users->toArray();
    	//dd($users);

    	return view('businesunit.form',['bu'=>$bu,'users'=>$users]);
    }

    public function store(Request $request)
    {
        $this->authorize('update', BU::class);

    	$this->validate($request, [
    		'name' => 'required',
    		'head_user_id' => 'required'
    	]);

    	BU::updateOrCreate(['id'=>$request->id],$request->all());

    	return redirect('/admin/bu');
    }

    public function delete(BU $bu)
    {
        $this->authorize('delete', $bu);

        $bu->delete();

        return redirect('/admin/bu');
    }

}
