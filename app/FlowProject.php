<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlowProject extends Model
{
    protected $table="flow_project";

    public function flow()
    {
    	return $this->belongsTo('App\Flow');
    }

	public function project()
    {
    	return $this->belongsTo('App\Project');
    }
}
