<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Team $team)
    {
        return $user->teams->contains($team);
    }

    public function delete(User $user, Team $team)
    {
        return $user->id === $team->owner_id;
    }

    public function addMembers(User $user, Team $team)
    {
        return $user->id === $team->owner_id || $user->teamRole($team) === 'admin';
    }

    public function manageMemberRoles(User $user, Team $team)
    {
        return $user->id === $team->owner_id;
    }

    public function removeMember(User $user, Team $team, User $memberToRemove)
    {
        // Allow if the user is the owner
        if ($user->id === $team->owner_id) {
            return true;
        }
        
        // Allow if the user is an admin and not trying to remove the owner or another admin
        if ($user->teamRole($team) === 'admin' && 
            $memberToRemove->id !== $team->owner_id &&
            $memberToRemove->teamRole($team) !== 'admin') {
            return true;
        }
        
        return false;
    }

    public function createProject(User $user, Team $team)
    {
        return $user->id === $team->owner_id || $user->teamRole($team) === 'admin';
    }

    public function update(User $user, Team $team)
    {
        return $user->id === $team->owner_id || $user->teamRole($team) === 'admin';
    }
}