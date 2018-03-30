<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetenceLevel extends Model
{
	protected $fillable = ['competence_id','level','description'];
	
	public function competence()
	{
    	return $this->belongsTo('App\Competence');
	}
}
