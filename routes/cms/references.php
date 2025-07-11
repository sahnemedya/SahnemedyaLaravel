<?php

use App\Http\Controllers\Cms\ReferencesController;
use Illuminate\Support\Facades\Route;

Route::post("references/{id}/publish", [ReferencesController::class, 'publish'])->name('references.publish');
Route::resource('references', ReferencesController::class);


