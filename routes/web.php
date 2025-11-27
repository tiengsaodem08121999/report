<?php

use App\Http\Controllers\MembersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportsController;

Route::get('/report', [ReportsController::class, 'index'])->name('report.index');

Route::get('/members', [MembersController::class, 'index'])->name('members.index');
Route::get('/members/create', [MembersController::class, 'create'])->name('members.create');
Route::post('/members', [MembersController::class, 'store'])->name('members.store');
Route::get('/members/{member}', [MembersController::class, 'show'])->name('members.show');
Route::get('/members/{member}/edit', [MembersController::class, 'edit'])->name('members.edit');
Route::put('/members/{member}', [MembersController::class, 'update'])->name('members.update');
Route::delete('/members/{member}', [MembersController::class, 'destroy'])->name('members.destroy');