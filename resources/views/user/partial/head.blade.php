<!doctype html>

<html lang="tr">
<head>
    @if(isset($siteSetting) && $siteSetting !== null && $siteSetting->head_code)
        {!! $siteSetting->head_code !!}
    @endif

    <script type="application/ld+json">
        {
          "@context": "https://schema.org/",
          "@type": "WebSite",
          "name": "{{env("APP_NAME")}}",
          "url": "{{env("APP_URL")}}"
        }
    </script>

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="stylesheet"
          href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="{{asset('css/user/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/user/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/user/jquery.mmenu.all.css')}}">

        @vite(['resources/css/style.scss'])
    <link rel="stylesheet" href="{{asset('css/user/table.css')}}">
    <link href="{{asset('lightbox/dist/css/lightbox.css')}}" rel="stylesheet">
    <script src="{{asset('lightbox/dist/js/lightbox.js')}}"></script>



        @php
            // Mevcut sayfayı URL'den belirle
            $currentPage = null;
            $currentSlug = request()->segment(1) ?: 'anasayfa';

            // URL'den sayfayı bul (seo bilgileriyle birlikte)
            if($currentSlug && $currentSlug != 'anasayfa') {
                $currentPage = \App\Models\Page::with(['seo', 'blade'])
                                              ->where('slug', $currentSlug)
                                              ->first();
            }
        @endphp

        @if(isset($currentPage) && $currentPage && isset($currentPage->extraCss))
            {!! $currentPage->extraCss !!}
        @endif
        @yield('extraCss')

        @php
            $TITLE = '';
            $DESCRIPTION = '';
            $CANNONICAL = url()->current();
            $IMAGE = '';
            $KEYWORDS = '';

            // Ana sayfa kontrolü
            $isHomePage = (url()->current() == env('APP_URL')) ||
                          (request()->segment(1) == '' || request()->segment(1) == 'anasayfa');

            if($isHomePage) {
                // Ana sayfa için site ayarlarını kullan
                $TITLE = (isset($siteSetting->seo_title) && $siteSetting->seo_title ? $siteSetting->seo_title : $siteSetting->site_name) .
                         (isset($siteSetting->site_name) ? ' | ' . $siteSetting->site_name : '');
                $DESCRIPTION = isset($siteSetting->seo_description) ? $siteSetting->seo_description : '';
                $IMAGE = env('APP_URL')."/images/site/".(isset($siteSetting->logo) ? $siteSetting->logo : '');
                $KEYWORDS = isset($siteSetting->seo_keywords) ? $siteSetting->seo_keywords : '';
            } else {
                // Diğer sayfalar için
                if($currentPage) {
                    // Önce seo tablosundan kontrol et
                    if($currentPage->seo) {
                        $TITLE = ($currentPage->seo->title ? $currentPage->seo->title : $currentPage->title) .
                                 (isset($siteSetting->site_name) ? ' | ' . $siteSetting->site_name : '');
                        $DESCRIPTION = $currentPage->seo->description ?: '';

                    } else {
                        // Seo tablosunda yoksa page tablosundan al
                        $TITLE = $currentPage->title .
                                 (isset($siteSetting->site_name) ? ' | ' . $siteSetting->site_name : '');
                        $DESCRIPTION = isset($currentPage->seo->description) ? $currentPage->seo->description : '';

                    }

                    // Sayfa resmi
                    $IMAGE = env('APP_URL')."/images/user/sayfalar/".(isset($currentPage->image) ? $currentPage->image : '');
                } else {
                    // 404 durumu
                    $TITLE = '404 - Sayfa Bulunamadı' .
                             (isset($siteSetting->site_name) ? ' | ' . $siteSetting->site_name : '');
                    $DESCRIPTION = 'Aradığınız sayfa bulunamadı';
                    $IMAGE = env('APP_URL')."/images/site/".(isset($siteSetting->logo) ? $siteSetting->logo : '');
                }
            }
        @endphp

        <title>{{ $TITLE }}</title>
        <meta name="description" content="{{ $DESCRIPTION }}">
        @if($KEYWORDS)
            <meta name="keywords" content="{{ $KEYWORDS }}">
        @endif
        <meta name="robots" content="index,follow">
        <meta property="og:locale" content="tr_TR">
        <meta property="og:type" content="website">
        <meta property="og:title" content="{{ $TITLE }}">
        <meta property="og:description" content="{{ $DESCRIPTION }}">
        <meta property="og:url" content="{{ $CANNONICAL }}">
        <meta property="og:site_name" content="{{ isset($siteSetting->site_name) ? $siteSetting->site_name : '' }}">
        @if($IMAGE)
            <meta property="og:image:url" content="{{ $IMAGE }}">
            <meta property="og:image:secure_url" content="{{ $IMAGE }}">
            <meta property="og:image:width" content="320">
            <meta property="og:image:height" content="200">
        @endif
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:description" content="{{ $DESCRIPTION }}">
        <meta name="twitter:title" content="{{ $TITLE }}">
        @if($IMAGE)
            <meta name="twitter:image" content="{{ $IMAGE }}">
        @endif
        <link rel="canonical" href="{{ $CANNONICAL }}"/>
    @if(isset($siteSetting->favicon))
        <link rel="icon" type="image/x-icon" href="{{asset('images/site/'.$siteSetting->favicon)}}">
    @endif

    {{-- Alternate hreflang --}}
    @if(isset($language))
        @if($isHomePage || !$currentPage)
            <link rel="alternate" hreflang="{{$language->code}}" href="{{env('APP_URL')}}/{{$language->code}}"/>
        @else
            @if($currentPage && isset($currentPage->slug))
                <link rel="alternate" hreflang="{{$language->code}}" href="{{env('APP_URL')}}/{{$currentPage->slug}}"/>
            @endif
        @endif
    @endif

    {{-- HREFLANGS --}}
    @if(isset($diller) && $diller != NULL)
        @foreach($diller as $dil)
            @if($isHomePage)
                <link rel="alternate" hreflang="{{$dil->code}}" href="{{env('APP_URL')}}/{{$dil->code}}"/>
            @else
                @if(isset($pagesninTumCevirileri) && $pagesninTumCevirileri != NULL)
                    @foreach($pagesninTumCevirileri as $ceviri)
                        @if(isset($ceviri->dil_id, $ceviri->slug) && $ceviri->dil_id == $dil->id)
                            <link rel="alternate" hreflang="{{$dil->code}}"
                                  href="{{env('APP_URL')}}/{{$ceviri->slug}}"/>
                        @endif
                    @endforeach
                @endif
            @endif
        @endforeach
    @endif
    {{-- ###HREFLANGS --}}

    <script src="https://kit.fontawesome.com/8687eee5bc.js" crossorigin="anonymous"></script>
    <!-- fancybox -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css"/>
    <!--    google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">

</head>
<body>
@if(isset($siteSetting->body_ek) && $siteSetting->body_ek)
    {!! $siteSetting->body_ek !!}
@endif
