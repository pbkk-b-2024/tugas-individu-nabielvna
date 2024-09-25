<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{
    public function create(Team $team)
    {
        if (Gate::denies('create-project', $team)) {
            abort(403);
        }

        return view('projects.create', compact('team'));
    }

    public function store(Request $request, Team $team)
    {
        if (Gate::denies('create-project', $team)) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('project_covers', 'public');
            $validated['cover_image'] = $path;
        }

        $project = $team->projects()->create($validated);
        
        return redirect()->route('projects.show', $project)->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        if (Gate::denies('view', $project)) {
            abort(403);
        }

        $members = $project->members()->paginate(10);
        $availableMembers = $project->team->members()->whereDoesntHave('projects', function ($query) use ($project) {
            $query->where('project_id', $project->id);
        })->get();

        return view('projects.show', compact('project', 'members', 'availableMembers'));
    }

    public function addMembers(Request $request, Project $project)
    {
        if (Gate::denies('manage-project-members', $project)) {
            abort(403);
        }

        $validated = $request->validate([
            'members' => 'required|array',
            'members.*.user_id' => 'required|exists:users,id',
            'members.*.role' => 'required|in:pic,member',
        ]);

        foreach ($validated['members'] as $member) {
            $project->members()->attach($member['user_id'], ['role' => $member['role']]);
        }

        return back()->with('success', 'Members added successfully.');
    }

    public function removeMember(Project $project, User $user)
    {
        if (Gate::denies('manage-project-members', $project)) {
            abort(403);
        }

        $project->members()->detach($user);

        return back()->with('success', 'Member removed successfully.');
    }

    public function changeMemberRole(Request $request, Project $project, User $user)
    {
        if (Gate::denies('manage-project-members', $project)) {
            abort(403);
        }

        $validated = $request->validate([
            'role' => 'required|in:pic,member',
        ]);

        $project->members()->updateExistingPivot($user->id, ['role' => $validated['role']]);

        return back()->with('success', 'Member role updated successfully.');
    }
}