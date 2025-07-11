<?php

use App\Http\Controllers\Cms\DoctorController;
use Illuminate\Support\Facades\Route;

Route::get('/doctors/deleted', [DoctorController::class, 'deleted'])->name('doctors.deleted');
Route::delete('doctors/{id}/force-delete', [DoctorController::class, 'forceDelete'])->name('doctors.forceDelete');
Route::post('doctors/{id}/restore', [DoctorController::class, 'restore'])->name('doctors.restore');
Route::resource('doctors', DoctorController::class)->only(['index', 'create', 'edit', 'update', 'store', 'destroy']);


