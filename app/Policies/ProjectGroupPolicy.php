<?php

namespace App\Policies;

use App\Laravue\Models\User;
use App\Models\ProjectGroup;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProjectGroupPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {

    }
    public function show(User $user, ProjectGroup $projectGroup)
    {
        return $user->id === $projectGroup->user_id
            ? Response::allow()
            : Response::deny('Now Access');
    }

    public function update(User $user, ProjectGroup $projectGroup)
    {
        return $user->id === $projectGroup->user_id
            ? Response::allow()
            : Response::deny('Now Access');
    }

    public function destroy(User $user, ProjectGroup $projectGroup)
    {
        return $user->id === $projectGroup->user_id
            ? Response::allow()
            : Response::deny('Now Access');
    }
}
