<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCompetence extends Model
{
    protected $fillable = ['name','competence_id'];
    protected $table = 'subcompetences';

    public function competence()
    {
    	return $this->belongsTo('App\Competence');
    }

	public function levels()
    {
    	return $this->hasMany('App\SubCompetenceLevel','subcompetence_id');
    }

}
