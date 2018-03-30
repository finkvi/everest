<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'rusname', 'title', 'department', 'employeenumber', 'login', 'avatar',
        'flow_id', 'current_profile_id', 'target_profile_id', 'mentor_user_id', 'admin', 'phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function flow()
    {
        return $this->belongsTo('App\Flow','flow_id');
    }

    public function flpOfFlows()
    {
        return $this->hasMany('App\Flow','flp_user_id');
    }

    public function programs()
    {
        return $this->belongsToMany('App\Program');
    }

    public function dpOfPrograms()
    {
        return $this->hasMany('App\Program','dp_user_id');
    }

    public function currentProfile()
    {
        return $this->belongsTo('App\Profile','current_profile_id');
    }

    public function targetProfile()
    {
        return $this->belongsTo('App\Profile','target_profile_id');
    }

    public function mentor()
    {
        return $this->belongsTo('App\User','mentor_user_id');
    }

    public function apprantices()
    {
        return $this->hasMany('App\User','mentor_user_id');
    }

    public function flow_program()
    {
        return $this->hasMany('App\FlowProgram','pl_user_id');
    }

    public function flow_project()
    {
        return $this->hasMany('App\FlowProject','tl_user_id');
    }

    public function rpOfProjects()
    {
        return $this->hasMany('App\Project','rp_user_id');
    }

    public function projects()
    {
        return $this->belongsToMany('App\Project')->withPivot('profile_id');
    }

    public function evaluations()
    {
        return $this->hasMany('App\Evaluation');
    }

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    public function salary()
    {
        return $this->hasMany('App\Salary');
    }
}
