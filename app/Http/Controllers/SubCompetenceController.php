<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Competence, SubCompetence, SubCompetenceLevel};

class SubCompetenceController extends Controller
{

    public function list()
    {
        $competences = SubCompetence::with(['levels'=> function($q){
        		$q->orderBy('level','asc');
        	}])->orderBy('name','asc')->get();
        
        return view('competence.list',['competences'=>$competences]);
    }

    public function form(Competence $competence, SubCompetence $subcompetence)
    {
        $this->authorize('update', $subcompetence);

        return view('subcompetence.form',[
        	'competence'=>$competence,
        	'subcompetence'=>$subcompetence
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('update', SubCompetence::class);

        $this->validate($request, [
            'name' => 'required',
        ]);

        $c = SubCompetence::updateOrCreate(['id'=>$request->id],$request->all());

        return redirect('/admin/competences#block'.$c->competence_id);
    }

    public function delete(SubCompetence $subcompetence)
    {
        $this->authorize('delete', $subcompetence);

        $block_id = $subcompetence->competence_id;
        $subcompetence->delete();

        return redirect('/admin/competences#block'.$block_id);
    }

    public function formLevel(SubCompetence $subcompetence, SubCompetenceLevel $subclevel)
    {
        $this->authorize('update', SubCompetence::class);

        return view('subcompetence.level-form',['subclevel'=>$subclevel, 'subcompetence'=>$subcompetence]);
    }

    public function storeLevel(Request $request)
    {
        $this->authorize('update', SubCompetence::class);

        $this->validate($request, [
            'level' => 'required',
        ]);

        $subcompetencelevel = SubCompetenceLevel::updateOrCreate(['id'=>$request->id],$request->all());

        return redirect('/admin/competences#block'.$subcompetencelevel->subcompetence->competence_id);
    }

    public function deleteLevel(SubCompetenceLevel $subclevel)
    {
        $this->authorize('delete', SubCompetence::class);

        $block_id = $subclevel->subcompetence->competence_id;
        $subclevel->delete();

        return redirect('/admin/competences#block'.$block_id);
    }

    public function getLevelInfo(SubCompetence $subcompetence, $subclevel)
    {
        $c = $subcompetence->levels()->where('level',$clevel)->first();

        if (isset($c->description))
            die($c->description);
        else
            die('-');
    }

}
