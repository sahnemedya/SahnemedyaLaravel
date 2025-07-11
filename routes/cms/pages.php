<?php

use App\Http\Controllers\Cms\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/pages/deleted', [PageController::class, 'deleted'])->name('pages.deleted');
Route::post('pages/{id}/publish',[PageController::class,"publishPage"])->name("pages.publish");
Route::post('pages/{id}/activate',[PageController::class,"activate"])->name("pages.activate");
Route::post('pages/{id}/restore',[PageController::class,"restore"])->name("pages.restore");
Route::delete('pages/{id}/force-delete',[PageController::class,"forceDelete"])->name("pages.forceDelete");
Route::resource('pages', PageController::class);


