<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['competence_id','creator_user_id','title','task','completed','confirmed'];

    public function user()
    {
    	return $this->belongsTo('App\User','user_id');
    }

    public function creator()
    {
    	return $this->belongsTo('App\User','creator_user_id');
    }

    public function competence()
    {
    	return $this->belongsTo('App\Competence','competence_id');
    }

}
