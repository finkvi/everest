<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['rp_user_id','program_id','name'];

    public function program()
    {
    	return $this->belongsTo('App\Program');
    }

    public function rp()
    {
    	return $this->belongsTo('App\User','rp_user_id');
    }

	public function flows()
    {
    	return $this->belongsToMany('App\Flow')->withPivot('tl_user_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User')->withPivot('profile_id');
    }
}
