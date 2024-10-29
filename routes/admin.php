<?php

use App\Http\Controllers\Backend\AdminController;
use Illuminate\Support\Facades\Route;

/* Admin Routes */
Route::get('admin/dashboard', [AdminController::class,'dashboard'])->middleware(['auth', 'role:admin'])->name('admin.dashboard');
