<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubCompetencePolicy
{
    use HandlesAuthorization;

    public function update(User $user)
    {
        return $user->admin;
    }

    public function delete(User $user)
    {
        return $user->admin;
    }

}
