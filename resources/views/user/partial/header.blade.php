<header class="sabitheader">

    <div class="top" id="top">
        <div class="max-width">
            <div class="left">
                @if($contacts?->phone)
                    <div class="telefon">
                        <img src="{{asset("images/site/icons/siyah/footer-telefon.svg")}}" alt="" width="16px">
                        <a href="tel:{{$contacts->phone}}"
                           onclick="telefonpAramasi(event,'tel:{{$contacts->phone}}')">
                            {{--                            +9{{$contacts->phone}}--}}

                            @php
                                $phone = $contacts->phone;
                                // 05321234567 -> +90 (532) 123 45 67
                                // İlk karakteri (0) atla ve 1. indexten başla
                                $formatted = '+90 (' . substr($phone, 1, 3) . ') ' . substr($phone, 4, 3) . ' ' . substr($phone, 7, 2) . ' ' . substr($phone, 9, 2);
                            @endphp
                            {{ $formatted }}
                        </a>

                    </div>
                @endif
                @if($contacts?->phone2)
                    <div class="telefon">

                        <img src="{{asset("images/site/icons/siyah/footer-telefon.svg")}}" alt="" width="16px">
                        <a href="tel:{{$contacts->phone2}}"
                           onclick="telefonpAramasi(event,'tel:{{$contacts->phone2}}')">
                            @php
                                $phone = $contacts->phone2;
                                // 05321234567 -> +90 (532) 123 45 67
                                // İlk karakteri (0) atla ve 1. indexten başla
                                $formatted = '+90 (' . substr($phone, 1, 3) . ') ' . substr($phone, 4, 3) . ' ' . substr($phone, 7, 2) . ' ' . substr($phone, 9, 2);
                            @endphp
                            {{ $formatted }}
                        </a>

                    </div>
                @endif
                <div class="mail">
                    <img src="{{asset("images/site/icons/siyah/footer-mail.svg")}}" alt="" width="16px">
                    <a href="mailto:{{$contacts->email}}" class="yazi">{{$contacts->email}}</a>
                </div>

            </div>
            <div class="right">
                <div class="social-media">
                    <form class="search-form" action="{{route('pageSearch')}}" method="post">
                        @csrf
                        <div class="search-box">
                            <input type="search" placeholder="Ara..." name="search" id="searchInput" required>
                            <button type="submit" aria-label="Ara">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round" class="search-icon">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                            </button>
                        </div>
                    </form>
                    <a href="{{$contacts->socialMedia->instagram}}">
                        <figure><img src="{{asset("images/site/icons/siyah/instagram.svg")}}" alt=""></figure>
                    </a>
                    <a href="{{$contacts->socialMedia->linkedin}}">
                        <figure><img src="{{asset("images/site/icons/siyah/linkedin.svg")}}" alt=""></figure>
                    </a>
                    <a href="{{$contacts->socialMedia->youtube}}">
                        <figure><img src="{{asset("images/site/icons/siyah/youtube.svg")}}" alt=""></figure>
                    </a>
                    <a href="{{$contacts->socialMedia->facebook}}">
                        <figure><img src="{{asset("images/site/icons/siyah/facebook.svg")}}" alt=""></figure>
                    </a>
                    <a href="{{$contacts->socialMedia->twitter}}">
                        <figure><img src="{{asset("images/site/icons/siyah/twitter-x.svg")}}" alt=""></figure>
                    </a>
                    <a href="https://wa.me/+9{{$contacts->phone}}?text=Randevu%20almak%20istiyorum" class="wp">
                        <figure><img src="{{asset("images/site/icons/siyah/whatsapp.svg")}}" alt=""></figure>
                    </a>


                </div>
            </div>
        </div>
    </div>


    <div class="bottom">
        <nav>
            <div class="max-width">
                <a href="{{env('APP_URL')}}" class="logo">
                    <img @if($siteSetting->logo)
                             src="{{asset("images/site/".$siteSetting->logo )}}"
                         @else
                             src="{{asset("images/site/nophoto.png")}}"
                         @endif class="logo">
                </a>


                <div class="right">
                    <ul>
                        {{--                        <li class="main-li">--}}
                        {{--                            <a href="{{env("APP_URL")}}">Anasayfa</a>--}}
                        {{--                        </li>--}}


                        @foreach($navbarMenus as $menu)

                            @if($menu->page) {{-- Kategorinin ana sayfası var mı? --}}

                            <li class="main-li">
                                <a href="{{ url($menu->page->slug) }}">
                                    {{ $menu->page->title }}
                                </a>

                                @if($menu->children->count() > 0)
                                    <ul class="altmenu">
                                        @foreach($menu->children as $altKategori)
                                            @if($altKategori->page)
                                                <li>
                                                    <a href="{{ url($altKategori->page->slug) }}">{{ $altKategori->page->title }}</a>

                                                    {{-- 3. Seviye: Alt kategorinin alt sayfaları varsa ve alt sayfa bir başka sayfaya ait değilse --}}
                                                    @if ($altKategori->subPages->count() > 0)
                                                        <ul class="alt-altmenu">
                                                            @foreach($altKategori->subPages as $altAltSayfa)
                                                                @if (!$altAltSayfa->parent_page)
                                                                    <li>
                                                                        <a href="{{ url($altAltSayfa->slug) }}">{{ $altAltSayfa->title }}</a>

                                                                        {{-- 4. Seviye (isteğe bağlı): alt-alt sayfanın çocukları varsa --}}
                                                                        @if ($altAltSayfa->children && $altAltSayfa->children->count())
                                                                            <ul class="alt-altmenu">
                                                                                @foreach ($altAltSayfa->children as $thirdLevelPage)
                                                                                    <li>
                                                                                        <a href="{{ url($thirdLevelPage->slug) }}">{{ $thirdLevelPage->title }}</a>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        @endif
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @else
                                                <li>
                                                    <a>{{ $altKategori->name }}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>

                                @elseif($menu->subPages->count() > 0)
                                    <ul class="altmenu">
                                        @foreach($menu->subPages as $altSayfa)
                                            @if (!$altSayfa->parent_page)
                                                <li>
                                                    <a href="{{ url($altSayfa->slug) }}">{{ $altSayfa->title }}</a>

                                                    {{-- 3. Seviye: Alt sayfanın alt sayfaları varsa --}}
                                                    @if ($altSayfa->children && $altSayfa->children->count())
                                                        <ul class="alt-altmenu">
                                                            @foreach ($altSayfa->children as $altAltSayfa)
                                                                <li>
                                                                    <a href="{{ url($altAltSayfa->slug) }}">{{ $altAltSayfa->title }}</a>

                                                                    {{-- 4. Seviye (isteğe bağlı): alt-alt sayfanın çocukları varsa --}}
                                                                    @if ($altAltSayfa->children && $altAltSayfa->children->count())
                                                                        <ul class="alt-altmenu">
                                                                            @foreach ($altAltSayfa->children as $thirdLevelPage)
                                                                                <li>
                                                                                    <a href="{{ url($thirdLevelPage->slug) }}">{{ $thirdLevelPage->title }}</a>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            </li>

                            @else
                                <li class="main-li">
                                    <a href="javascript:void(0)">{{ $menu->name }}</a>

                                    @if($menu->children->count() > 0)
                                        <ul class="altmenu">
                                            @foreach($menu->children as $altKategori)
                                                @if($altKategori->page)
                                                    <li>
                                                        <a href="{{ url($altKategori->page->slug) }}">{{ $altKategori->page->title }}</a>

                                                        {{-- 3. Seviye: Alt kategorinin alt sayfaları varsa --}}
                                                        @if ($altKategori->subPages->count() > 0)
                                                            <ul class="alt-altmenu">
                                                                @foreach($altKategori->subPages as $altAltSayfa)
                                                                    @if (!$altAltSayfa->parent_page)
                                                                        <li>
                                                                            <a href="{{ url($altAltSayfa->slug) }}">{{ $altAltSayfa->title }}</a>
                                                                        </li>
                                                                    @endif
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @else
                                                    <li>
                                                        <a>{{ $altKategori->name }}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>

                                    @elseif($menu->subPages->count() > 0)
                                        <ul class="altmenu">
                                            @foreach($menu->subPages as $altSayfa)
                                                @if (!$altSayfa->parent_page)
                                                    <li>
                                                        <a href="{{ url($altSayfa->slug) }}">{{ $altSayfa->title }}</a>

                                                        @if ($altSayfa->children && $altSayfa->children->count())
                                                            <ul class="alt-altmenu">
                                                                @foreach ($altSayfa->children as $altAltSayfa)
                                                                    <li>
                                                                        <a href="{{ url($altAltSayfa->slug) }}">{{ $altAltSayfa->title }}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endif

                        @endforeach



                        <li class="main-li social-link web-none">
                                        <a class="web-none" href="{{$contacts->socialMedia->instagram}}"><i
                                                class="lab la-instagram"></i></a>
                                        <a class="web-none" href="{{$contacts->socialMedia->threads}}"><img
                                                src="{{asset("images/user/icons/tiktok.svg")}}" alt=""></a>
                                        <a class="web-none" href="{{$contacts->socialMedia->linkedin}}"><i
                                                class="lab la-linkedin"></i></a>
                                        <a class="web-none" href="{{$contacts->socialMedia->youtube}}"><i
                                                class="lab la-youtube"></i></a>
                                        <a class="web-none" href="{{$contacts->socialMedia->facebook}}"><i
                                                class="lab la-facebook-f"></i></a>
                                        <a class="web-none" href="{{$contacts->socialMedia->twitter}}"><img
                                                src="{{asset("images/user/site/icons/x-twitter.svg")}}" alt=""></a>
                                        <a class="web-none wp"
                                           onclick="whatsAppAramasi(event,'https://wa.me/+9{{$contacts->phone}}?text=Bilgi%20almak%20istiyorum')"
                                           href="https://wa.me/+9{{$contacts->phone}}?text=Bilgi%20almak%20istiyorum"
                                           target="_blank"><i class="lab la-whatsapp"></i></a>
{{--                                        <a style="display: none" class="lang-link">--}}
{{--                                            <img src="{{asset('images/user/site/icons/globe.svg')}}">--}}
{{--                                            <span>{{\Illuminate\Support\Str::upper($language->code)}}</span>--}}
{{--                                        </a>--}}
                                    </li>
                        <li>
                            <a href="/teklif-al" class="teklifal-btn">Teklif Al</a>
                        </li>

                    </ul>
                </div>


                <a href="#mobilmenu" id="close">
                    <div class="bar">
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                    </div>

                    {{--                    <i class="las la-bars"></i>--}}

                </a>

            </div>
        </nav>
    </div>
</header>

@section('extraJS')


@endsection
