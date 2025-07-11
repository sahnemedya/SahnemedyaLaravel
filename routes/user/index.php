
<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UIndexController;

Route::get('', 'index')->name('home');
Route::get('/sitemap.xml', [UIndexController::class, 'sitemap'])->name('sitemap');
Route::post('/arama-kayit', [UIndexController::class, 'aramaKayit'])->name('aramaKayit');

Route::post('/sayfa-ara', [UIndexController::class, 'aramaSonucu'])->name('pageSearch');
Route::get('/sayfa-ara', [UIndexController::class, 'aramaGet'])->name('pageSearchGet');


//Route::get('/sertifika-sorgula/{sno}', [UIndexController::class, 'sertifikaSorgula'])->name('sertifikaSorgula');
//Route::post('/sertifika-sorgula', [UIndexController::class, 'sertifikaSorgula'])->name('sertifikaSorgulaPost');




Route::post('/iletisim-formu', [UIndexController::class, 'iletisimPost'])->name('iletisimPost');
//Route::post('/randevu-al-post', [UIndexController::class, 'randevuAlPost'])->name('randevuAlPost');
//Route::post('/doktora-sor-post', [UIndexController::class, 'doktoraSorPost'])->name('doktoraSorPost');
Route::post('/insan-kaynaklari-post', [UIndexController::class, 'insanKaynaklariPost'])->name('insanKaynaklariPost');

Route::get('/{slug}', [UIndexController::class, 'slug'])->name('siteUrl');
