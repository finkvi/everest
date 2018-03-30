<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $table = 'salary';
    protected $fillable = ['user_id','money','date','grade'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
