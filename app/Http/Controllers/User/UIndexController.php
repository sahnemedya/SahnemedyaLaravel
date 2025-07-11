<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormMail;
use App\Mail\ContactIkiFormMail;
use App\Models\ApiKeys;
use App\Models\Category;
use App\Models\ContactForm;
use App\Models\Contacts;
use App\Models\Gallery;
use App\Models\Language;
use App\Models\References;
use App\Models\Seo;
use App\Models\Slider;
use App\Models\SiteSettings;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class UIndexController extends Controller
{

    public function index()
    {
        $blogs = Page::where('category_id', 18)
            ->where('published', 1)
            ->whereNotIn('title', function($query) {
                $query->select('name')
                    ->from('categories')
                    ->whereColumn('categories.id', 'pages.category_id');
            })
            ->orderBy('id', 'desc')
            ->limit(3)
            ->get();
        $sliders=Slider::where('published', 1)->orderBy("hit")->get();
        $references=References::where('published', 1)->orderBy("hit")->get();
        return view('User.index', compact('references', 'sliders','blogs'));

    }

    public function aramaSonucu(Request $request)
    {
        $aramaMetni = $request->search;

        $seoObject = new Seo;
        $pages = new Page;
        $pages->id = 0;
        $seoObject->title = $aramaMetni . " Arama Sonuçları";
        $seoObject->description = $aramaMetni . " hakkındaki arama sonuçları listelenmiştir.";
        $pages->slug = "arama-sonuclari";
        $pages->title = "'" . $aramaMetni . "'" . " Arama Sonuçları";
        $pages->content = NULL;
        $pages->image = NULL;
//        $pages->sayfa_ozelligi = NULL;
        $pages->lang_id = "1";
        $pages->translation_of = NULL;
        $pages->parent_page = NULL;
        $sayfaninTumCevirileri = NULL;

        $category = [
            "id" => 0,
            "title" => "Arama Sonuçları",
            "note" => null,
            "image" => null,
            "slug" => "arama-sonuclari",

            "ust_kategori_id" => null,
            "dil_id" => 1,
            "show_menu" => 1,
            "show_homepage" => 0,
            "show_footer" => 0,
            "hit" => 0,
            "created_at" => "2024-10-07 15:43:11",
            "updated_at" => "2024-10-07 15:43:28",
            "deleted_at" => null];
        $breadCrumbUstKategoriler = [$category];

        $pages2 = Category::with(['getSayfa'])  // İlişkileri dahil et
        ->where(function ($query) use ($aramaMetni) {
            $query->whereRaw("MATCH(name, note) AGAINST(? IN BOOLEAN MODE)", [$aramaMetni])
                ->orWhere('name', 'LIKE', '%' . $aramaMetni . '%')
                ->orWhere('note', 'LIKE', '%' . $aramaMetni . '%');
        })->get();


        return view('User.blades.arama-sonuclari', compact("pages2", "aramaMetni", "seoObject", "pages", "category", "breadCrumbUstKategoriler"));
//        return view('User.blades.arama-sonuclari', compact('sayfalar', 'aramaMetni', 'searchPage'));
    }

    public function aramaGet(): RedirectResponse
    {
        return redirect()->back();
    }

    // Sayfa gösterme metodu
    public function show($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('published', 1)
            ->with('seo')
            ->firstOrFail();

        return view('user.sayfa', compact('page' ));
    }

    public function slug($slug)
    {
        // Slug'a göre sayfayı bul ve blade bilgisini de getir
        $page = Page::with('blade')->where('slug', $slug)->firstOrFail();
        // Bu sayfaya ait galeri resimlerini getir (ID'ye göre sıralı)
        $galleries = Gallery::where('page_id', $page->id)
            ->orderBy('id', 'asc')
            ->get()
            ->map(function ($gallery) {
                $gallery->image = $gallery->image(); // resim URL'ini direkt JS'e hazırla
                return $gallery;
            });

        // Blade dosyasının yolunu al ve .blade.php uzantısını kaldır
        if ($page->blade) {
            // normal.blade.php -> normal
            $fileName = str_replace('.blade.php', '', $page->blade->file);
            $bladeFile = 'user.blades.' . $fileName;
        } else {
            $bladeFile = 'user.blades.default';
        }
        $contacts = Contacts::all();
        $references=References::where('published', 1)->orderBy("hit")->get();

        $relatedNews = $this->getRelatedNews($page);
        // Sayfa verilerini view'e gönder (galleries eklendi)
        return view($bladeFile, compact('page', 'galleries','references', 'relatedNews', 'contacts'));
    }

    /**
     * İlgili haberleri getirir - sadece aynı kategoriden, önce önceki haberler sonra sonrakiler
     * Kategorinin "blog" sayfasını ve mevcut sayfayı hariç tutar
     */
    private function getRelatedNews($currentPage, $limit = 3)
    {
        // Eğer sayfa category_id'si yoksa boş collection döndür
        if (!$currentPage->category_id) {
            return collect();
        }

        // Kategorinin "blog" sayfasını bul (eğer varsa)
        $categoryBlogPage = Page::where('category_id', $currentPage->category_id)
            ->where('slug', 'blog')
            ->first();

        // Hariç tutulacak ID'leri belirle
        $excludeIds = [$currentPage->id];
        if ($categoryBlogPage) {
            $excludeIds[] = $categoryBlogPage->id;
        }

        // Mevcut haberin tarihinden önce yayınlanmış haberler (aynı kategoriden)
        $previousNews = Page::where('category_id', $currentPage->category_id)
            ->where('created_at', '<', $currentPage->created_at)
            ->whereNotIn('id', $excludeIds)
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();

        // Eğer yeterli haber yoksa, sonra yayınlananlardan tamamla (yine aynı kategoriden)
        if ($previousNews->count() < $limit) {
            $needed = $limit - $previousNews->count();

            $nextNews = Page::where('category_id', $currentPage->category_id)
                ->where('created_at', '>', $currentPage->created_at)
                ->whereNotIn('id', $excludeIds)
                ->orderBy('created_at', 'asc')
                ->take($needed)
                ->get();

            // Önceki ve sonraki haberleri birleştir
            $relatedNews = $previousNews->merge($nextNews);
        } else {
            $relatedNews = $previousNews;
        }

        return $relatedNews;
    }
    public function iletisimPost(Request $request)
    {
        $rules = ['adSoyad' => 'required|max:250', 'email' => 'required|max:250|email', 'konu' => 'required|max:250', 'mesaj' => 'required', 'kvkk' => 'required'];
        $rulesError = ['adSoyad.required' => 'Adınızı ve Soyadınızı girin (max:250)',
            'adsoyad.max' => 'Ad Soyad en fazla 250 karakter olabilir',
            'email.required' => 'E-mail adresinizi girin',
            'email.max' => 'E-mail adresiniz en fazla 250 karakter olabilir',
            'email.email' => 'E-mail adresi bulunamadı',
            'konu.required' => 'Konuyu yazınız.',
            'konu.max' => 'Konu en fazla 250 karakter olabilir',
            'mesaj.required' => 'Mesajınızı yazınız.',
            'kvkk.required' => 'Bilgilendirme Metnini İşaretleyin.'
        ];
        $request->flash();
        $validator = Validator::make($request->all(), $rules, $rulesError);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        function url_get_contents($url)
        {
            if (!function_exists('curl_init')) {
                die('CURL is not installed!');
            }

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            curl_close($ch);
            return $output;
        }

        $response = $request->g_recaptcha_response;
        $secret = ApiKeys::select('recaptcha_secret_key')->first()->recaptcha_secret_key;
        $remoteip = $_SERVER['REMOTE_ADDR'];
        $captcha = url_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip");
        $result = json_decode($captcha);

        if ($result->success != true && (isset($result->score) && $result->score < 0.5)) {
            Alert::error("Hata", "Doğrulama Kodu Hatası");
            return Redirect::to($request->server->get("HTTP_ORIGIN"));
        }

        $iletisimFormu = new ContactForm;
        $iletisimFormu->formAdi = $request->formAdi;
        $iletisimFormu->adSoyad = $request->adSoyad;
        $iletisimFormu->telefon = $request->telefon;
        $iletisimFormu->email = $request->email;
        $iletisimFormu->konu = $request->konu;
        $iletisimFormu->mesaj = $request->mesaj;
        $iletisimFormu->izin = $request->izin;

        $kvkkOnayi = 'Evet';
        if ($iletisimFormu->izin != 1) {
            $iletisimFormu->izin = 0;
            $kvvkOnayi = 'Hayır';
        }

        $gonderilecekMailAdresi = Contacts::find(1);
        $companyMail = $gonderilecekMailAdresi->email;
        $companyMail2 = $gonderilecekMailAdresi->email2;

        $mailData = [
            "email" => $companyMail,
            "subject" => $request->formAdi . " Formu | " . env('APP_NAME'),
            "formAdi" => $request->formAdi,
            "kullaniciAdSoyad" => $request->adSoyad,
            "kullaniciBirim" => $request->birim,
            "kullaniciTelefon" => $request->telefon,
            "kullaniciEmail" => $request->email,
            "kullaniciKonu" => $request->konu,
            "kullaniciKvkkOnayi" => $kvkkOnayi,
            "kullaniciMesaj" => $request->mesaj,
            'kullaniciTarih' => date('d.m.Y'),
            'kullaniciIP' => $request->ip()
        ];

        if ($companyMail == NULL) {
            if (Mail::to(["firmamailformlari@sahnemedya.com"])->send(new ContactFormMail($mailData))) {
                if ($iletisimFormu->save()) {
                    Log::channel('userLog')->info("[" . $mailData['kullaniciAdSoyad'] . " - " . $mailData['kullaniciEmail'] . "]");
                    Alert::success('Başarılı', 'Mesajınız gönderildi.');
                    return Redirect::to($request->server->get('HTTP_ORIGIN'));
                } else {
                    Alert::error("Hata", 'Mesajınız gönderilemedi. Sayfayı yenileyip tekrar deneyin.');
                    return redirect()->back();
                }
            } else {
                Alert::error('Hata!', 'Mesajınız gönderilemedi. Sayfayı yenileyip tekrar deneyin.');
                return redirect()->back();
            }

        } else {
            if (Mail::to([$companyMail, "firmamailformlari@sahnemedya.com"])->send(new ContactFormMail($mailData))) {
                if ($iletisimFormu->save()) {
                    Log::channel('userLog')->info("[" . $mailData['kullaniciAdSoyad'] . " - " . $mailData['kullaniciEmail'] . " - " . $mailData['kullaniciIP'] . "]");
                    Alert::success('Başarılı', 'Mesajınız gönderildi.');
                    return redirect()->back();
                } else {
                    Alert::warning('Uyarı!', 'Mesajınız kaydedildi ama gönderilemedi.');
                    return redirect()->back();
                }
            } else {
                Alert::error('Hata!', 'Mesajınız gönderilemedi. Sayfayı yenileyip tekrar deneyin.');
                return redirect()->back();
            }
        }


    }
    public function insanKaynaklariPost(Request $request)
    {

        $rules = ['adSoyad' => 'required|max:250', 'email' => 'required|max:250|email', 'konu' => 'required|max:250', 'mesaj' => 'required', 'kvkk' => 'required'];
        $rulesError = ['adSoyad.required' => 'Adınızı ve Soyadınızı girin (max:250)',
            'adsoyad.max' => 'Ad Soyad en fazla 250 karakter olabilir',
            'email.required' => 'E-mail adresinizi girin',
            'email.max' => 'E-mail adresiniz en fazla 250 karakter olabilir',
            'email.email' => 'E-mail adresi bulunamadı',
            'konu.required' => 'Departman yazınız.',
            'konu.max' => 'Departman en fazla 250 karakter olabilir',
            'mesaj.required' => 'Mesajınızı yazınız.',
            'kvkk.required' => 'Bilgilendirme Metnini İşaretleyin.'
        ];
        $request->flash();
        $validator = Validator::make($request->all(), $rules, $rulesError);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        function url_get_contents($url)
        {
            if (!function_exists('curl_init')) {
                die('CURL is not installed!');
            }

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            curl_close($ch);
            return $output;
        }

        $response = $request->g_recaptcha_response;
        $secret = ApiKeys::select('recaptcha_secret_key')->first()->recaptcha_secret_key;
        $remoteip = $_SERVER['REMOTE_ADDR'];
        $captcha = url_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip");
        $result = json_decode($captcha);

        if ($result->success != true && (isset($result->score) && $result->score < 0.5)) {
            Alert::error("Hata", "Doğrulama Kodu Hatası");
            return Redirect::to($request->server->get("HTTP_ORIGIN"));
        }

        $iletisimFormu = new ContactForm;
        $iletisimFormu->formAdi = $request->formAdi;
        $iletisimFormu->adSoyad = $request->adSoyad;
        $iletisimFormu->telefon = $request->telefon;
        $iletisimFormu->email = $request->email;
        $iletisimFormu->konu = $request->konu;
        $iletisimFormu->mesaj = $request->mesaj;
        $iletisimFormu->izin = $request->izin;
        $cv = NULL;
        $cvVarMi = 'Yok';
        $cvName = NULL;
        if ($request->hasFile('cv')) {
            $cvVarMi = 'Var';
            $cv = $request->file('cv');
            $cvName = Str::slug($iletisimFormu->adSoyad, '-') . '-' . Str::random(16) . '.' . $cv->getClientOriginalExtension();

            try {
                $cv->move(public_path('ik-cv/'), $cvName);
                $iletisimFormu->cv = $cvName;
            } catch (\Exception $e) {
                Alert::warning('CV yüklenirken hata oluştu');
                return redirect()->back();
            }
        }
        $kvkkOnayi = 'Evet';
        if ($iletisimFormu->izin != 1) {
            $iletisimFormu->izin = 0;
            $kvvkOnayi = 'Hayır';
        }

        $gonderilecekMailAdresi = Contacts::find(1);
        $companyMail = $gonderilecekMailAdresi->email;
        $companyMail2 = $gonderilecekMailAdresi->email2;

        $mailData = [
            "email" => $companyMail,
            "subject" => $request->formAdi . " Formu | " . env('APP_NAME'),
            "formAdi" => $request->formAdi,
            "kullaniciAdSoyad" => $request->adSoyad,
            "kullaniciBirim" => $request->birim,
            "kullaniciTelefon" => $request->telefon,
            "kullaniciEmail" => $request->email,
            "kullaniciCvVarMi" => $cvVarMi,
            'kullaniciCvName' => $cvName,
            "kullaniciKonu" => $request->konu,
            "kullaniciKvkkOnayi" => $kvkkOnayi,
            "kullaniciMesaj" => $request->mesaj,
            'kullaniciTarih' => date('d.m.Y'),
            'kullaniciIP' => $request->ip()
        ];

        if ($companyMail == NULL) {
            if (Mail::to(["firmamailformlari@sahnemedya.com"])->send(new ContactIkiFormMail($mailData))) {
                if ($iletisimFormu->save()) {
                    Log::channel('userLog')->info("[" . $mailData['kullaniciAdSoyad'] . " - " . $mailData['kullaniciEmail'] . "]");
                    Alert::success('Başarılı', 'Mesajınız gönderildi.');
                    return Redirect::to($request->server->get('HTTP_ORIGIN'));
                } else {
                    Alert::error("Hata", 'Mesajınız gönderilemedi. Sayfayı yenileyip tekrar deneyin.');
                    return redirect()->back();
                }
            } else {
                Alert::error('Hata!', 'Mesajınız gönderilemedi. Sayfayı yenileyip tekrar deneyin.');
                return redirect()->back();
            }

        } else {
            if (Mail::to([$companyMail, "firmamailformlari@sahnemedya.com"])->send(new ContactIkiFormMail($mailData))) {
                if ($iletisimFormu->save()) {
                    Log::channel('userLog')->info("[" . $mailData['kullaniciAdSoyad'] . " - " . $mailData['kullaniciEmail'] . " - " . $mailData['kullaniciIP'] . "]");
                    Alert::success('Başarılı', 'Mesajınız gönderildi.');
                    return redirect()->back();
                } else {
                    Alert::warning('Uyarı!', 'Mesajınız kaydedildi ama gönderilemedi.');
                    return redirect()->back();
                }
            } else {
                Alert::error('Hata!', 'Mesajınız gönderilemedi. Sayfayı yenileyip tekrar deneyin.');
                return redirect()->back();
            }
        }


    }
}
