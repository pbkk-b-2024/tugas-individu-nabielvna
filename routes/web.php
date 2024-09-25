<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    });
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Team routes
    Route::get('/teams', [TeamController::class, 'myTeams'])->name('teams.my-teams');
    Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');
    Route::get('/teams/{team}/edit', [TeamController::class, 'edit'])->name('teams.edit');
    Route::put('/teams/{team}', [TeamController::class, 'update'])->name('teams.update');
    Route::delete('/teams/{team}', [TeamController::class, 'destroy'])->name('teams.destroy');
    Route::patch('/teams/{team}/cover-image', [TeamController::class, 'updateCoverImage'])->name('teams.update-cover-image');
    Route::delete('/teams/{team}/cover-image', [TeamController::class, 'deleteCoverImage'])->name('teams.delete-cover-image');

    // Team member management routes
    Route::post('/teams/{team}/members', [TeamController::class, 'addMembers'])->name('teams.members.add');
    Route::delete('/teams/{team}/members/{user}', [TeamController::class, 'removeMember'])->name('teams.members.remove');
    Route::post('/teams/{team}/members/{user}/promote', [TeamController::class, 'promoteMember'])->name('teams.members.promote');
    Route::post('/teams/{team}/members/{user}/demote', [TeamController::class, 'demoteMember'])->name('teams.members.demote');
    Route::post('/teams/{team}/leave', [TeamController::class, 'leaveTeam'])->name('teams.leave');

    // Project routes
    Route::get('/teams/{team}/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/teams/{team}/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    Route::patch('/projects/{project}/cover-image', [ProjectController::class, 'updateCoverImage'])->name('projects.update-cover-image');

    // Project member management routes
    Route::post('/projects/{project}/members', [ProjectController::class, 'addMembers'])->name('projects.add-members');
    Route::delete('/projects/{project}/members/{user}', [ProjectController::class, 'removeMember'])->name('projects.members.remove');
    Route::patch('/projects/{project}/members/{user}/role', [ProjectController::class, 'changeMemberRole'])->name('projects.members.change-role');
});

require __DIR__.'/auth.php';