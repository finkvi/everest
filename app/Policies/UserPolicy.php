<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function view(User $user, User $targetUser)
    {
    	return ($user->admin || $user->id == $targetUser->id || $user->id == $targetUser->mentor_user_id);
    }

    public function update(User $user, User $targetUser)
    {
        return ($user->admin || $user->id == $targetUser->mentor_user_id);
    }

    public function delete(User $user)
    {
        return $user->admin;
    }

}
