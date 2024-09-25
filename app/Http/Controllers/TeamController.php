<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    public function create()
    {
        return view('teams.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('team_covers', 'public');
            $validated['cover_image'] = $path;
        }

        $team = Team::create([
            'name' => $validated['name'],
            'owner_id' => Auth::id(),
            'cover_image' => $validated['cover_image'] ?? null,
        ]);

        $team->members()->attach(Auth::id(), ['role' => 'owner']);

        return redirect()->route('teams.show', $team)->with('success', 'Team created successfully.');
    }

    public function show(Request $request, Team $team)
    {
        if (Gate::denies('view', $team)) {
            abort(403);
        }

        $search = $request->input('search');
        $projectSearch = $request->input('project_search');

        $members = $team->members()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->paginate(10)
            ->appends(['search' => $search, 'project_search' => $projectSearch]);

        $projects = $team->projects()
            ->when($projectSearch, function ($query) use ($projectSearch) {
                $query->where(function ($q) use ($projectSearch) {
                    $q->where('name', 'like', "%{$projectSearch}%")
                      ->orWhere('description', 'like', "%{$projectSearch}%");
                });
            })
            ->paginate(6)
            ->appends(['search' => $search, 'project_search' => $projectSearch]);

        $availableUsers = User::whereNotIn('id', $team->members->pluck('id'))
            ->get(['id', 'name', 'email']);

        return view('teams.show', compact('team', 'members', 'projects', 'availableUsers', 'search', 'projectSearch'));
    }

    public function update(Request $request, Team $team)
    {
        if (Gate::denies('update', $team)) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $team->update($validated);

        return response()->json(['success' => true, 'message' => 'Team name updated successfully']);
    }

    public function updateCoverImage(Request $request, Team $team)
    {
        if (Gate::denies('update', $team)) {
            return back()->with('error', 'You do not have permission to update the team cover image.');
        }

        $request->validate([
            'cover_image' => 'required|image|max:2048',
        ]);

        if ($team->cover_image) {
            Storage::disk('public')->delete($team->cover_image);
        }

        $path = $request->file('cover_image')->store('team_covers', 'public');
        $team->update(['cover_image' => $path]);

        return back()->with('success', 'Team cover image updated successfully.');
    }

    public function deleteCoverImage(Team $team)
    {
        if (Gate::denies('update', $team)) {
            return back()->with('error', 'You do not have permission to delete the team cover image.');
        }

        if ($team->cover_image) {
            Storage::disk('public')->delete($team->cover_image);
            $team->update(['cover_image' => null]);
        }

        return back()->with('success', 'Team cover image deleted successfully.');
    }

    public function destroy(Team $team)
    {
        if (Gate::denies('delete', $team)) {
            abort(403);
        }

        $team->delete();
        return redirect()->route('teams.my-teams')->with('success', 'Team deleted successfully.');
    }

    public function addMembers(Request $request, Team $team)
    {
        if (Gate::denies('addMembers', $team)) {
            abort(403);
        }
        
        $validated = $request->validate([
            'members' => 'required|array',
            'members.*.user_id' => 'required|exists:users,id',
            'members.*.role' => 'required|in:member,admin',
        ]);

        $addedCount = 0;
        $alreadyInTeamCount = 0;

        foreach ($validated['members'] as $member) {
            try {
                $team->members()->attach($member['user_id'], ['role' => $member['role']]);
                $addedCount++;
            } catch (QueryException $e) {
                // Check if the exception is due to a duplicate entry
                if ($e->errorInfo[1] == 1062) {
                    $alreadyInTeamCount++;
                    // Optionally, update the role if the user is already in the team
                    $team->members()->updateExistingPivot($member['user_id'], ['role' => $member['role']]);
                } else {
                    // If it's a different error, rethrow it
                    throw $e;
                }
            }
        }

        $message = "{$addedCount} member(s) added successfully.";
        if ($alreadyInTeamCount > 0) {
            $message .= " {$alreadyInTeamCount} member(s) were already in the team and had their roles updated.";
        }
        
        return back()->with('success', $message);
    }

    public function promoteMember(Team $team, User $user)
    {
        if (Gate::denies('manageMemberRoles', $team)) {
            return back()->with('error', 'You do not have permission to promote members.');
        }

        if ($user->teamRole($team) === 'member') {
            $team->members()->updateExistingPivot($user->id, ['role' => 'admin']);
            return back()->with('success', 'Member promoted to admin successfully.');
        }

        return back()->with('error', 'Member is already an admin.');
    }

    public function demoteMember(Team $team, User $user)
    {
        if (Gate::denies('manageMemberRoles', $team)) {
            return back()->with('error', 'You do not have permission to demote members.');
        }

        if ($user->id === $team->owner_id) {
            return back()->with('error', 'Cannot demote the team owner.');
        }

        if ($user->teamRole($team) === 'admin') {
            $team->members()->updateExistingPivot($user->id, ['role' => 'member']);
            return back()->with('success', 'Admin demoted to member successfully.');
        }

        return back()->with('error', 'Member is already a regular member.');
    }

    public function leaveTeam(Team $team)
    {
        $user = Auth::user();

        if ($user->id === $team->owner_id) {
            return back()->with('error', 'The team owner cannot leave the team. Transfer ownership first.');
        }

        $team->members()->detach($user->id);

        return redirect()->route('teams.my-teams')->with('success', 'You have left the team successfully.');
    }

    public function removeMember(Team $team, User $user)
    {
        if (Gate::denies('removeMember', [$team, $user])) {
            return back()->with('error', 'You do not have permission to remove this member.');
        }

        $authUser = Auth::user();

        // Prevent removal of the team owner
        if ($user->id === $team->owner_id) {
            return back()->with('error', 'Cannot remove the team owner.');
        }

        // Prevent admins from removing other admins
        if ($authUser->teamRole($team) === 'admin' && $user->teamRole($team) === 'admin') {
            return back()->with('error', 'Admins cannot remove other admins.');
        }

        $team->members()->detach($user);

        return back()->with('success', 'Member removed successfully.');
    }

    public function myTeams()
    {
        $teams = Auth::user()->teams;
        return view('teams.my-teams', compact('teams'));
    }
}