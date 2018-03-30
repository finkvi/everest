<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCompetenceLevel extends Model
{
    protected $fillable = ['subcompetence_id','level','description'];
    protected $table = 'subcompetence_levels';

    public function subcompetence()
	{
    	return $this->belongsTo('App\SubCompetence','subcompetence_id');
	}

}
