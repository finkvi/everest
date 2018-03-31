<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recomend extends Model
{
    //
    protected $fillable = [
        'user_id', 'last_name', 'first_name', 
        'phone', 'email', 
        'account', 'notes', 'comments'
    ];
    
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
