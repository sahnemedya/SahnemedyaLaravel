<?php

use App\Http\Controllers\Cms\ContactFormController;
use App\Http\Controllers\Cms\DealerFormController;
use App\Http\Controllers\Cms\HumanResourcesFormController;
use Illuminate\Support\Facades\Route;

Route::prefix('/forms')->name('forms.')->group(function () {
    # İletişim Formları
    Route::get('/contact-forms', [ContactFormController::class, 'iletisimFormu'])->name('iletisimFormu');
    Route::get('/get-imail', [ContactFormController::class, 'getMail'])->name('getImail');

    Route::get('/dealers-forms', [DealerFormController::class, 'bayilikBasvurusuFormu'])->name('bayilikBasvuruFormu');
    Route::get('/get-bmail', [DealerFormController::class, 'getBMail'])->name('getBmail');

    Route::get('/human-resources-forms', [HumanResourcesFormController::class, 'insanKaynaklariFormu'])->name('insanKaynaklariFormu');
    Route::get('/get-Imail', [HumanResourcesFormController::class, 'getIMail'])->name('getImail');
});


