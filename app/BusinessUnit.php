<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessUnit extends Model
{
    protected $fillable = ['name','head_user_id'];

    public function flows()
    {
    	return $this->hasMany('App\Flow','business_unit_id');
    }

    public function head()
    {
    	return $this->belongsTo('App\User','head_user_id');
    }
}
