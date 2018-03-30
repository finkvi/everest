<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
	protected $fillable = ['name','sublevels'];

    public function profiles()
    {
    	return $this->belongsToMany('App\Profile','profile_competence_level','competence_id','profile_id');
    }

    public function levels()
    {
    	return $this->hasMany('App\CompetenceLevel');
    }

    public function flows()
    {
    	return $this->belongsToMany('App\Flow');
    }

    public function subcompetences()
    {
        return $this->hasMany('App\SubCompetence');
    }
}
