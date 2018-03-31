<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Recomend as Rec;

class RecomendController extends Controller
{
    
    public function index(Request $request)
    {
        $user = \Auth::user();
               
        if ($user->isSuperAdmin()) 
        {
            $recomends = Rec::All();
        }
        else 
        {
            $recomends = Rec::where('user_id', $user()->id)
                    ->orderBy('created_at', 'asc')
                    ->get();
        }  
        
        return view('recomends.index', 
            [
                'recomends' => $recomends
            ]
        );
    }
    
    public function form(Rec $rec)
    {
        //$this->authorize('update', $rec);

        $this->authorize('mylist', $rec);
        
    	return view('recomends.form',['rec'=>$rec]);
    }
    
    public function store(Request $request)
    {

        $rec = Rec::find($request->id);
        
        if ($rec) $this->authorize('mylist', $rec);

    	$this->validate($request, [
    		'last_name' => 'required',
    		'first_name' => 'required',
    		'email' => 'email',
    		'phone' => 'required',
    	]);

        $user = \Auth::user();
        
        $data = $request->all();
        $data['user_id'] = $user->id;
        
    	Rec::updateOrCreate([
    	        'id'=>$request->id
    	    ], $data);

    	return redirect('/recomends');
    }

    public function delete(Rec $rec)
    {
        $this->authorize('mylist', $rec);
        
        $rec->delete();

        return redirect('/recomends');
    }

}
