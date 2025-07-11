<?php

use App\Http\Controllers\Cms\SideMenuElementController;
use Illuminate\Support\Facades\Route;


Route::get('side-menu-elements/{id}', [SideMenuElementController::class, 'index'])->name('side-menu-elements.index');

Route::get('side-menu-elements/create/{id}', [SideMenuElementController::class, 'create'])->name('side-menu-elements.create');

Route::post('side-menu-elements', [SideMenuElementController::class, 'store'])->name('side-menu-elements.store');

Route::get('side-menu-elements/{categoryId}/{pageId}/edit', [SideMenuElementController::class, 'edit'])->name('side-menu-elements.edit');

Route::put('side-menu-elements/{pageId}', [SideMenuElementController::class, 'update'])->name('side-menu-elements.update');

Route::get('/side-menu-elements/{categoryId}/deleted', [SideMenuElementController::class, 'deleted'])->name('side-menu-elements.deleted');



