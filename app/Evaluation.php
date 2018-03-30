<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = ['user_id','evaluator_user_id','comment'];

    public function user()
    {
    	return $this->belongsTo('App\User','user_id');
    }

    public function evaluator()
    {
    	return $this->belongsTo('App\User','evaluator_user_id');
    }

    public function competences()
    {
    	return $this->belongsToMany('App\Competence')->withPivot('value');
    }

    public function subcompetences()
    {
        return $this->belongsToMany('App\SubCompetence','subcompetence_evaluation','subcompetence_id','evaluation_id')->withPivot('value');
    }

}
