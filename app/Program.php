<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = ['dp_user_id','business_unit_id','name'];

    public function bu()
    {
    	return $this->belongsTo('App\BusinessUnit','business_unit_id');
    }

    public function projects()
    {
    	return $this->hasMany('App\Project');
    }

	public function dp()
    {
    	return $this->belongsTo('App\User','dp_user_id');
    }

	public function flows()
    {
    	return $this->belongsToMany('App\Flow')->withPivot('pl_user_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }


}
