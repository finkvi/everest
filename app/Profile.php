<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
	protected $fillable = ['flow_id','grade','name','order','salary'];

	public function flow()
	{
		return $this->belongsTo('App\Flow');
	}

	public function competences()
    {
    	return $this->belongsToMany('App\Competence','profile_competence_level','profile_id','competence_id')
    				->withPivot('level')
    				->leftJoin('competence_levels', function($join){
    					$join->on('competence_levels.level', '=', 'profile_competence_level.level')
    						 ->on('competences.id', '=', 'competence_levels.competence_id');
    				})
    				->select('competence_levels.description','competences.*')->orderBy('competences.name','asc');
    }

    public function users_current()
    {
    	return $this->hasMany('App\User','current_profile_id');
    }

	public function users_target()
    {
    	return $this->hasMany('App\User','target_profile_id');
    }

}
