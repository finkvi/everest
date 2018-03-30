<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flow extends Model
{
    protected $fillable = ['flp_user_id','business_unit_id','name'];

    public function bu()
    {
    	return $this->belongsTo('App\BusinessUnit','business_unit_id')->withDefault([
    		'name' => 'не задан'
    	]);
    }

    public function profiles()
    {
    	return $this->hasMany('App\Profile');
    }

    public function competences()
    {
        return $this->belongsToMany('App\Competence');
    }

	public function flp()
    {
    	return $this->belongsTo('App\User','flp_user_id')->withDefault([
    		'name' => 'не задан',
    		'avatar' => ''
    	]);
    }

    public function programs()
    {
    	return $this->belongsToMany('App\Program');
    }

    public function users()
    {
        return $this->hasMany('App\User','flow_id');
    }

    public function flow_program()
    {
        return $this->hasMany('App\FlowProgram','flow_id');
    }
}
