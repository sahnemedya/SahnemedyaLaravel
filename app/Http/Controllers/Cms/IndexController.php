<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\NumberUsers;
use App\Services\CommonService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;

class IndexController extends Controller
{
    protected CommonService $commonService;

    public function __construct(CommonService $commonService)
    {
        $this->commonService = $commonService;
    }

    public function index()
    {
        //        KULLANICI SAYILARININ BİLGİLERİ
        $aylar = [
            '01' => 'Ocak',
            '02' => 'Şubat',
            '03' => 'Mart',
            '04' => 'Nisan',
            '05' => 'Mayıs',
            '06' => 'Haziran',
            '07' => 'Temmuz',
            '08' => 'Ağustos',
            '09' => 'Eylül',
            '10' => 'Ekim',
            '11' => 'Kasım',
            '12' => 'Aralık',
        ];

        $kullaniciSayilari = [];
        $kullaniciSayilari = [];
        $mobilKullanici = [];
        $masaustuKullanici = [];
        $tabletKullanici = [];

        foreach ($aylar as $no => $adi) {
            $kullaniciAySayisi = NumberUsers::whereMonth('updated_at', $no)->whereYear('updated_at', Carbon::now()->year)->count();
            $mobilKullaniciSayisiAy = NumberUsers::whereMonth('updated_at', $no)->whereYear('updated_at', Carbon::now()->year)->where('cihaz', 'Mobil')->count();
            $masaustuKullaniciSayisiAy = NumberUsers::whereMonth('updated_at', $no)->whereYear('updated_at', Carbon::now()->year)->where('cihaz', 'Masaüstü')->count();
            $tabletKullaniciSayisiAy = NumberUsers::whereMonth('updated_at', $no)->whereYear('updated_at', Carbon::now()->year)->where('cihaz', 'Tablet')->count();
            array_push($kullaniciSayilari, $kullaniciAySayisi);
            array_push($mobilKullanici, $mobilKullaniciSayisiAy);
            array_push($tabletKullanici, $tabletKullaniciSayisiAy);
            array_push($masaustuKullanici, $masaustuKullaniciSayisiAy);

        }

//        Son 3, 7 gün ve 3,6,9,12 ay whatsapp kayıtları

//        $whatsappAramaSayilari = [
//            'son_3_gun' => AramaKayit::where('tur', 'Whatsapp')->where('updated_at', '>=', Carbon::now()->subDays(3))->get()->count(),
//            'son_7_gun' => AramaKayit::where('tur', 'Whatsapp')->where('updated_at', '>=', Carbon::now()->subDays(7))->get()->count(),
//            'son_1_ay' => AramaKayit::where('tur', 'Whatsapp')->where('updated_at', '>=', Carbon::now()->subMonth(1))->get()->count(),
//            'son_3_ay' => AramaKayit::where('tur', 'Whatsapp')->where('updated_at', '>=', Carbon::now()->subMonths(3))->get()->count(),
//            'son_6_ay' => AramaKayit::where('tur', 'Whatsapp')->where('updated_at', '>=', Carbon::now()->subMonths(6))->get()->count(),
//            'son_9_ay' => AramaKayit::where('tur', 'Whatsapp')->where('updated_at', '>=', Carbon::now()->subMonths(9))->get()->count(),
//            'son_12_ay' => AramaKayit::where('tur', 'Whatsapp')->where('updated_at', '>=', Carbon::now()->subMonths(12))->get()->count(),
//            'tum_whatsapp_aramalari' => AramaKayit::where('tur', 'Whatsapp')->get()->count()
//        ];
//        $telefonAramaSayilari = [
//            'son_3_gun' => AramaKayit::where('tur', 'Telefon')->where('updated_at', '>=', Carbon::now()->subDays(3))->get()->count(),
//            'son_7_gun' => AramaKayit::where('tur', 'Telefon')->where('updated_at', '>=', Carbon::now()->subDays(7))->get()->count(),
//            'son_1_ay' => AramaKayit::where('tur', 'Telefon')->where('updated_at', '>=', Carbon::now()->subMonth(1))->get()->count(),
//            'son_3_ay' => AramaKayit::where('tur', 'Telefon')->where('updated_at', '>=', Carbon::now()->subMonths(3))->get()->count(),
//            'son_6_ay' => AramaKayit::where('tur', 'Telefon')->where('updated_at', '>=', Carbon::now()->subMonths(6))->get()->count(),
//            'son_9_ay' => AramaKayit::where('tur', 'Telefon')->where('updated_at', '>=', Carbon::now()->subMonths(9))->get()->count(),
//            'son_12_ay' => AramaKayit::where('tur', 'Telefon')->where('updated_at', '>=', Carbon::now()->subMonths(12))->get()->count(),
//            'tum_telefon_aramalari' => AramaKayit::where('tur', 'Telefon')->get()->count()
//        ];
        $kullaniciSayilari = [
            'son_3_gun' => NumberUsers::where('updated_at', '>=', Carbon::now()->subDays(3))->count(),
            'son_7_gun' => NumberUsers::where('updated_at', '>=', Carbon::now()->subDays(7))->count(),
            'son_1_ay' => NumberUsers::where('updated_at', '>=', Carbon::now()->subMonth(1))->count(),
            'son_3_ay' => NumberUsers::where('updated_at', '>=', Carbon::now()->subMonths(3))->count(),
            'son_6_ay' => NumberUsers::where('updated_at', '>=', Carbon::now()->subMonths(6))->count(),
            'son_9_ay' => NumberUsers::where('updated_at', '>=', Carbon::now()->subMonths(9))->count(),
            'son_12_ay' => NumberUsers::where('updated_at', '>=', Carbon::now()->subMonths(12))->count(),
            'tum_kullanici' => NumberUsers::get()->count(),
        ];
//        $kullaniciIletisimMailleri=[
//            'son_3_gun' => IletisimFormu::where('updated_at', '>=', Carbon::now()->subDays(3))->count(),
//            'son_7_gun' => IletisimFormu::where('updated_at', '>=', Carbon::now()->subDays(7))->count(),
//            'son_1_ay' => IletisimFormu::where('updated_at', '>=', Carbon::now()->subMonth(1))->count(),
//            'son_3_ay' => IletisimFormu::where('updated_at', '>=', Carbon::now()->subMonths(3))->count(),
//            'son_6_ay' => IletisimFormu::where('updated_at', '>=', Carbon::now()->subMonths(6))->count(),
//            'son_9_ay' => IletisimFormu::where('updated_at', '>=', Carbon::now()->subMonths(9))->count(),
//            'son_12_ay' => IletisimFormu::where('updated_at', '>=', Carbon::now()->subMonths(12))->count(),
//            'tum_mail' => IletisimFormu::get()->count(),
//        ];
//        $kullaniciIkMailleri=[
//            'son_3_gun' => InsanKaynaklariFormu::where('updated_at', '>=', Carbon::now()->subDays(3))->count(),
//            'son_7_gun' => InsanKaynaklariFormu::where('updated_at', '>=', Carbon::now()->subDays(7))->count(),
//            'son_1_ay' => InsanKaynaklariFormu::where('updated_at', '>=', Carbon::now()->subMonth(1))->count(),
//            'son_3_ay' => InsanKaynaklariFormu::where('updated_at', '>=', Carbon::now()->subMonths(3))->count(),
//            'son_6_ay' => InsanKaynaklariFormu::where('updated_at', '>=', Carbon::now()->subMonths(6))->count(),
//            'son_9_ay' => InsanKaynaklariFormu::where('updated_at', '>=', Carbon::now()->subMonths(9))->count(),
//            'son_12_ay' => InsanKaynaklariFormu::where('updated_at', '>=', Carbon::now()->subMonths(12))->count(),
//            'tum_mail' => InsanKaynaklariFormu::get()->count(),
//        ];
//        $kullaniciRandevuMailleri=[
//            'son_3_gun' => RandevuAl::where('updated_at', '>=', Carbon::now()->subDays(3))->count(),
//            'son_7_gun' => RandevuAl::where('updated_at', '>=', Carbon::now()->subDays(7))->count(),
//            'son_1_ay' => RandevuAl::where('updated_at', '>=', Carbon::now()->subMonth(1))->count(),
//            'son_3_ay' => RandevuAl::where('updated_at', '>=', Carbon::now()->subMonths(3))->count(),
//            'son_6_ay' => RandevuAl::where('updated_at', '>=', Carbon::now()->subMonths(6))->count(),
//            'son_9_ay' => RandevuAl::where('updated_at', '>=', Carbon::now()->subMonths(9))->count(),
//            'son_12_ay' => RandevuAl::where('updated_at', '>=', Carbon::now()->subMonths(12))->count(),
//            'tum_mail' => RandevuAl::get()->count(),
//        ];
//        $kullaniciDSorMailleri=[
//            'son_3_gun' => DoktoraSorFormu::where('updated_at', '>=', Carbon::now()->subDays(3))->count(),
//            'son_7_gun' => DoktoraSorFormu::where('updated_at', '>=', Carbon::now()->subDays(7))->count(),
//            'son_1_ay' => DoktoraSorFormu::where('updated_at', '>=', Carbon::now()->subMonth(1))->count(),
//            'son_3_ay' => DoktoraSorFormu::where('updated_at', '>=', Carbon::now()->subMonths(3))->count(),
//            'son_6_ay' => DoktoraSorFormu::where('updated_at', '>=', Carbon::now()->subMonths(6))->count(),
//            'son_9_ay' => DoktoraSorFormu::where('updated_at', '>=', Carbon::now()->subMonths(9))->count(),
//            'son_12_ay' => DoktoraSorFormu::where('updated_at', '>=', Carbon::now()->subMonths(12))->count(),
//            'tum_mail' => DoktoraSorFormu::get()->count(),
//        ];


//        $buAyGelenToplamMail = (IletisimFormu::whereMonth('updated_at', Carbon::now()->month)->count()) + (InsanKaynaklariFormu::whereMonth('updated_at', Carbon::now()->month)->count());
        return view('cms.index', compact('kullaniciAySayisi', 'kullaniciSayilari'));

    }

    public function slugMaker(Request $request): JsonResponse
    {
        $slug = $this->commonService->slugMaker($request->text);
        return response()->json(['slug' => $slug]);
    }
}
