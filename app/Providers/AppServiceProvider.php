<?php

namespace App\Providers;

use App\Models\ApiKeys;
use App\Models\Blade;
use App\Models\Category;
use App\Models\Contacts;
use App\Models\Language;
use App\Models\Page;
use App\Models\Seo;
use App\Models\SiteSettings;
use App\Observers\BladeObserver;
use App\Observers\CategoryObserver;
use App\Observers\LanguageObserver;
use App\Observers\PageObserver;
use App\Observers\SeoObserve;
use App\Observers\SiteSettingsObserver;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade as BladeFacade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //otomatik
        View::composer('cms.partial.header', function ($view) {
            $specialMenus = Category::where("show_panel", true)->orderBy("name")->get();
            $view->with('specialMenus', $specialMenus);
        });


        View::composer(['user.partial.header', 'user.partial.head'], function ($view) {
            $navbarMenus = Category::with([
                'page' => function($query) {
                    $query->where('published', 1); // Page tablosundaki published kontrolü
                },
                'children' => function($query) {
                    $query->where('show_menu', 1); // Category tablosundaki show_menu kontrolü
                },
                'children.page' => function($query) {
                    $query->where('published', 1); // Alt kategorinin page'i için published kontrolü
                },
                'children.children' => function($query) {
                    $query->where('show_menu', 1); // İkinci seviye category için show_menu kontrolü
                },
                'children.children.page' => function($query) {
                    $query->where('published', 1); // İkinci seviye category'nin page'i için published kontrolü
                },
                'subPages' => function($query) {
                    $query->where('published', 1) // Page tablosundaki published kontrolü
                    ->orderBy('hit', 'asc'); // Page tablosundaki hit'e göre sırala
                },
                'children.subPages' => function($query) {
                    $query->where('published', 1) // Alt kategorilerin page'leri için published kontrolü
                    ->orderBy('hit', 'asc'); // Alt kategorilerin page'lerini sırala
                },
                'parent.page' => function($query) {
                    $query->where('published', 1); // Parent category'nin page'i için published kontrolü
                },
                'children.children.subPages' => function($query) {
                    $query->where('published', 1) // Daha derin seviyedeki page'ler için published kontrolü
                    ->orderBy('hit', 'asc'); // Daha derin seviyedeki page'leri sırala
                }
            ])
                ->whereNull("parent_category")
                ->where('show_menu', 1) // Ana kategoriler için show_menu kontrolü
                ->orderBy("hit", "asc") // Category tablosundaki hit'e göre sırala
                ->get();

            $view->with('navbarMenus', $navbarMenus);
        });
        View::composer('user.partial.sidemenu', function ($view) {
            $currentSlug = Request::segment(1);
            $navbarMenus = collect();

            if ($currentSlug) {
                $currentCategory = Category::whereHas('page', function($query) use ($currentSlug) {
                    $query->where('slug', $currentSlug);
                })
                    ->orWhereHas('subPages', function($query) use ($currentSlug) {
                        $query->where('slug', $currentSlug);
                    })
                    ->with([
                        'page',
                        'subPages' => function($query) {
                            $query->orderBy('hit', 'asc');
                        }
                    ])
                    ->first();

                if ($currentCategory) {
                    $navbarMenus = collect([$currentCategory]);
                }
            }

            $view->with('navbarMenus', $navbarMenus);
        });


//        View::composer(['user.partial.footer'], function ($view) {
//            $footermenus = Category::with([
//                'pages' => function($query) {
//                    $query->where('show_footer', 1); // Pages tablosundaki show_footer kontrolü
//                },
//                'page' => function($query) {
//                    $query->where('show_footer', 1); // Page tablosundaki show_footer kontrolü
//                },
//                'children' => function($query) {
//                    $query->where('show_footer', 1); // Alt kategori için show_footer kontrolü
//                },
//                'children.page' => function($query) {
//                    $query->where('show_footer', 1); // Alt kategorinin page'i için show_footer kontrolü
//                },
//                'children.children' => function($query) {
//                    $query->where('show_footer', 1); // İkinci seviye category için show_footer kontrolü
//                },
//                'children.children.page' => function($query) {
//                    $query->where('show_footer', 1); // İkinci seviye category'nin page'i için show_footer kontrolü
//                },
//                'subPages' => function($query) {
//                    $query->where('show_footer', 1) // Page tablosundaki show_footer kontrolü
//                    ->orderBy('hit', 'asc'); // Page tablosundaki hit'e göre sırala
//                },
//                'children.subPages' => function($query) {
//                    $query->where('show_footer', 1) // Alt kategorilerin page'leri için show_footer kontrolü
//                    ->orderBy('hit', 'asc'); // Alt kategorilerin page'lerini sırala
//                },
//                'parent.page' => function($query) {
//                    $query->where('show_footer', 1); // Parent category'nin page'i için show_footer kontrolü
//                },
//                'children.children.subPages' => function($query) {
//                    $query->where('show_footer', 1) // Daha derin seviyedeki page'ler için show_footer kontrolü
//                    ->orderBy('hit', 'asc'); // Daha derin seviyedeki page'leri sırala
//                }
//            ])
//                ->whereNull("parent_category")
//                ->where('show_footer', 1) // Ana kategoriler için show_footer kontrolü - BU SATIRI AKTİF EDİN
//                ->orderBy("hit", "asc") // Category tablosundaki hit'e göre sırala
//                ->get();
//
//            $view->with('footermenus', $footermenus);
//        });




//        View::composer('user.partial.footer', function ($view) {
//
//            $footermenus = Category::with(['page', 'children.page', 'subPages'])
////                ->whereNull("parent_category")
//                ->where('show_footer', 1)
//                ->orderBy("hit")
//                ->get();
////            dd($footermenus);
//            $view->with('footermenus', $footermenus);
//        });
        View::composer('user.partial.footer', function ($view) {
            $footermenus = Page::with(['children', 'children.children'])
                ->where('show_footer', 1)
                ->orderBy("hit")
                ->get();
            $view->with('footermenus', $footermenus);
        });

//        View::composer(['user.partial.header', 'user.partial.footer', 'user.partial.head'], function ($view) {
//            $navbarMenus = Category::whereNull("parent_category")->orderBy("hit")->get();
//            $view->with('navbarMenus', $navbarMenus);
//        });

        View::composer(['user.partial.header', 'user.partial.footer', 'user.partial.head'], function ($view) {
            $contacts = Contacts::first();
            $view->with('contacts', $contacts);
        });

        View::composer(['user.partial.header', 'user.partial.footer', 'user.partial.head', 'user.index'], function ($view) {
            $siteSetting = SiteSettings::first();
            $view->with('siteSetting', $siteSetting);
        });


//        MAİL KEYS ÇEKME
        View::composer(['user.blades.iletisim', 'user.blades.coklu-fotograf-normal', 'user.blades.insan-kaynaklari', 'user.blades.teklif-al'], function ($view) {
            $apiKeys = ApiKeys::first();
            $view->with('apiKeys', $apiKeys);
        });



        BladeFacade::directive('permission', function ($permission) {
            return "<?php if(auth()->check() && auth()->user()->hasPermission({$permission})): ?>";
        });

        BladeFacade::directive('endpermission', function () {
            return "<?php endif; ?>";
        });

        View::addLocation(storage_path('app/public/views'));
        Blade::observe(BladeObserver::class);
        Language::observe(LanguageObserver::class);
        Category::observe(CategoryObserver::class);
        Page::observe(PageObserver::class);
        SiteSettings::observe(SiteSettingsObserver::class);
        Seo::observe(SeoObserve::class);

    }
}
