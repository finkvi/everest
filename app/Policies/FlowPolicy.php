<?php

namespace App\Policies;

use App\User;
use App\Flow;
use Illuminate\Auth\Access\HandlesAuthorization;

class FlowPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the flow.
     *
     * @param  \App\User  $user
     * @param  \App\Flow  $flow
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can delete the flow.
     *
     * @param  \App\User  $user
     * @param  \App\Flow  $flow
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->admin;
    }
}
