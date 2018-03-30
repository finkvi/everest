<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Competence, CompetenceLevel};

class CompetenceController extends Controller
{

    public function list()
    {
        $competences = Competence::with(['levels'=> function($q){
        		$q->orderBy('level','asc');
        	}])->orderBy('name','asc')->get();
        
        return view('competence.list',['competences'=>$competences]);
    }

    public function form(Competence $competence)
    {
        $this->authorize('update', $competence);

        return view('competence.form',['competence'=>$competence]);
    }

    public function store(Request $request)
    {
        $this->authorize('update', Competence::class);

        $this->validate($request, [
            'name' => 'required',
        ]);

        $data = $request->all();
        if (!isset($data['sublevels']))
            $data['sublevels'] = 0;

        $c = Competence::updateOrCreate(['id'=>$request->id],$data);

        return redirect('/admin/competences#block'.$c->id);
    }

    public function delete(Competence $competence)
    {
        $this->authorize('delete', $competence);

        $competence->delete();

        return redirect('/admin/competences');
    }

    public function formLevel(Competence $competence, CompetenceLevel $clevel)
    {
        $this->authorize('update', Competence::class);

        return view('competence.level-form',['clevel'=>$clevel, 'competence'=>$competence]);
    }

    public function storeLevel(Request $request)
    {
        $this->authorize('update', Competence::class);

        $this->validate($request, [
            'level' => 'required',
        ]);

        $competence = CompetenceLevel::updateOrCreate(['id'=>$request->id],$request->all());

        return redirect('/admin/competences#block'.$competence->competence_id);
    }

    public function deleteLevel(CompetenceLevel $clevel)
    {
        $this->authorize('delete', Competence::class);

        $clevel->delete();

        return redirect('/admin/competences#block'.$clevel->competence_id);
    }

    public function getLevelInfo(Competence $competence, $clevel)
    {
        $c = $competence->levels()->where('level',$clevel)->first();

        if (isset($c->description))
            die($c->description);
        else
            die('-');
    }
}
