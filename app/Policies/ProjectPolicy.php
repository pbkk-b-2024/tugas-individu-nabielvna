<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Project $project)
    {
        return $user->teams->contains($project->team);
    }

    public function manageProjectMembers(User $user, Project $project)
    {
        $teamRole = $user->teamRole($project->team);
        return $user->id === $project->team->owner_id || $teamRole === 'admin' || $user->projectRole($project) === 'pic';
    }
}