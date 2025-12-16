<?php

use App\Http\Controllers\LogtimeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ProjectsController;

Route::get('/report', [ReportsController::class, 'index'])->name('report.index');
Route::post('/crete_report', [ReportsController::class, 'store'])->name('report.store');

Route::get('/members', [MembersController::class, 'index'])->name('members.index');
Route::get('/members/create', [MembersController::class, 'create'])->name('members.create');
Route::post('/members', [MembersController::class, 'store'])->name('members.store');
Route::get('/members/{member}', [MembersController::class, 'show'])->name('members.show');
Route::get('/members/{member}/edit', [MembersController::class, 'edit'])->name('members.edit');
Route::put('/members/{member}', [MembersController::class, 'update'])->name('members.update');
Route::delete('/members/{member}', [MembersController::class, 'destroy'])->name('members.destroy');

Route::post('/logtime', [LogtimeController::class, 'store'])->name('logtime.store');
Route::post('/delete-logtime', [LogtimeController::class, 'deleteSpentTime'])->name('logtime.delete');

Route::get('/projects', [ProjectsController::class, 'index'])->name('projects.index');
Route::post('/projects', [ProjectsController::class, 'store'])->name('projects.store');
Route::post('/projects/delete-member', [ProjectsController::class, 'deleteMemberFromProject'])->name('project.deleteMember');
