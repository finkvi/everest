<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlowProgram extends Model
{
    protected $table="flow_program";

    public function flow()
    {
    	return $this->belongsTo('App\Flow');
    }

	public function program()
    {
    	return $this->belongsTo('App\Program');
    }

}
