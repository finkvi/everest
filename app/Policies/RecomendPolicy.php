<?php

namespace App\Policies;

use App\User;
use App\Recomend;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecomendPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function mylist(User $user, Recomend $rec)
    {
        //$user->admin || 
    	return ($user->isSuperAdmin() || $user->id == $rec->user_id);
    }

}
