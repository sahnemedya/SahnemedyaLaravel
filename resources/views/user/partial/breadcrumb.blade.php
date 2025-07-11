


{{--<section class="breadcrumb">--}}
{{--    <div class="breadcrumb-list max-width">--}}
{{--            <span>--}}
{{--                <a href="{{env('APP_URL')}}"><i class="las la-home homepage-icon"></i></a>--}}
{{--                <i class="las la-angle-double-right"></i>--}}
{{--                 @if(isset($pages))--}}
{{--                    @if($pages->category_id == 1)--}}
{{--                        <a href="/{{$pages->slug}}">{{$pages->baslik}}</a> <i class="las la-angle-double-right"></i>--}}
{{--                    @elseif($pages->category_id == 1)--}}

{{--                        <a href="javascript:void(0)">{{$pages->title}}</a>--}}
{{--                        <i class="las la-angle-double-right"></i>--}}

{{--                        <a href="/{{$pages->slug}}">{{$pages->baslik}}</a>--}}
{{--                        <i class="las la-angle-double-right"></i>--}}
{{--                    @elseif($breadCrumbUstKategoriler)--}}
{{--                        @foreach($breadCrumbUstKategoriler as $breadCrumbUstKategori)--}}
{{--                            <a href="@if(isset($breadCrumbUstKategori->slug)){{env('APP_URL')}}/{{$breadCrumbUstKategori->slug}}@else {{env('APP_URL')}}/javascript:void(0)@endif">{{$breadCrumbUstKategori->title}}</a>--}}
{{--                            <i class="las la-angle-double-right"></i>--}}
{{--                        @endforeach--}}
{{--                    @endif--}}
{{--                    <a style="font-weight: bold"> {{$pages->title}}</a>--}}
{{--                @endif--}}
{{--            </span>--}}
{{--    </div>--}}
{{--</section>--}}


{{--<section class="breadcrumb">--}}
{{--    <div class="breadcrumb-list max-width">--}}
{{--        <a href="{{env('APP_URL')}}"><i class="las la-home homepage-icon"></i></a>--}}

{{--        @if(isset($page))--}}
{{--            @foreach($page->breadcrumbs() as $breadcrumb)--}}
{{--                <i class="las la-angle-double-right"></i>--}}

{{--                @if($loop->last)--}}
{{--                    --}}{{-- Mevcut sayfa - bold ve link olmasın --}}
{{--                    <span style="font-weight: bold">{{ $breadcrumb->title }}</span>--}}
{{--                @else--}}
{{--                    --}}{{-- Üst sayfalar - linklendirilebilir --}}
{{--                    <a href="{{ env('APP_URL') }}/{{ $breadcrumb->slug }}">{{ $breadcrumb->title }}</a>--}}
{{--                @endif--}}
{{--            @endforeach--}}
{{--        @endif--}}
{{--    </div>--}}
{{--</section>--}}
<section class="breadcrumb">
    <div class="breadcrumb-list max-width">
        <a href="{{env('APP_URL')}}"><i class="las la-home homepage-icon"></i></a>

        @php
            $breadcrumbs = null;

            // Önce sayfa varsa onun breadcrumbs'ını al
            if(isset($page) && method_exists($page, 'breadcrumbs')) {
                $breadcrumbs = $page->breadcrumbs();
            }
            // Sayfa yoksa kategori varsa onun breadcrumbs'ını al
            elseif(isset($category) && method_exists($category, 'breadcrumbs')) {
                $breadcrumbs = $category->breadcrumbs();
            }
        @endphp

        @if($breadcrumbs && $breadcrumbs->count() > 0)
            @foreach($breadcrumbs as $breadcrumb)
                @php
                    // Breadcrumb item'ının Page mi Category mi olduğunu belirle
                    $isPage = $breadcrumb instanceof \App\Models\Page;
                    $isCategory = $breadcrumb instanceof \App\Models\Category;

                    // Title ve slug değerlerini belirle
                    $title = '';
                    $slug = '';

                    if($isPage) {
                        $title = $breadcrumb->title ?? '';
                        $slug = $breadcrumb->slug ?? '';
                    } elseif($isCategory) {
                        $title = $breadcrumb->name ?? '';
                        // Kategorinin ana sayfası varsa onun slug'ını kullan
                        $slug = $breadcrumb->page ? ($breadcrumb->page->slug ?? '') : '';
                    }
                @endphp

                @if(!empty($title))
                    <i class="las la-angle-double-right"></i>

                    @if($loop->last)
                        {{-- Mevcut sayfa/kategori - bold ve link olmasın --}}
                        <span style="font-weight: bold">{{ $title }}</span>
                    @else
                        {{-- Üst sayfalar/kategoriler - linklendirilebilir --}}
                        @if(!empty($slug))
                            <a href="{{ env('APP_URL') }}/{{ $slug }}" style="font-weight: bold">{{ $title }}</a>
                        @else
                            <span>{{ $title }}</span>
                        @endif
                    @endif
                @endif
            @endforeach
        @endif
    </div>
</section>

{{--<section class="breadcrumb">--}}
{{--    <div class="breadcrumb-list max-width">--}}
{{--        <a href="{{env('APP_URL')}}"><i class="las la-home homepage-icon"></i></a>--}}
{{--        <i class="las la-angle-double-right"></i>--}}
{{--        @if(isset($sayfa))--}}
{{--            @if($page->breadcrumbs() as $breadcrumb)--}}
{{--                <a href="/{{$sayfa->getKategori->getSayfa->slug}}">{{ $breadcrumb->title }}</a>--}}
{{--                <i class="las la-angle-double-right"></i>--}}
{{--            @elseif($$loop->last)--}}

{{--                <a href="javascript:void(0)">{{ $breadcrumb->title }}</a>--}}
{{--                <i class="las la-angle-double-right"></i>--}}

{{--                <a href="{{ env('APP_URL') }}/{{ $breadcrumb->slug }}">{{ $breadcrumb->title }}</a>--}}
{{--                <i class="las la-angle-double-right"></i>--}}
{{--            @elseif($breadCrumbUstKategoriler)--}}
{{--                @foreach($breadCrumbUstKategoriler as $breadCrumbUstKategori)--}}
{{--                    <a href="@if(isset($breadCrumbUstKategori->getSayfa->slug)){{env('APP_URL')}}/{{$breadCrumbUstKategori->getSayfa->slug}}@else {{env('APP_URL')}}/javascript:void(0)@endif">{{$breadCrumbUstKategori->kategori_adi}}</a>--}}
{{--                    <i class="las la-angle-double-right"></i>--}}
{{--                @endforeach--}}
{{--            @endif--}}
{{--            <a style="font-weight: bold"> {{$sayfa->baslik}}</a>--}}
{{--        @endif--}}
{{--    </div>--}}
{{--</section>--}}

