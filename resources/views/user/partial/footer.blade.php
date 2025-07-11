@if($siteSetting->footer_ek)
    {!! $siteSetting->footer_ek !!}
@endif
@if(isset($pages->extraJs))
    {!! $sayfa->extraJs !!}
@endif
@yield('extraJs')
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script src="{{asset('js/user/jquery.mmenu.all.min.js')}}"></script>
<script src="{{asset('js/user/owl.carousel.min.js')}}"></script>
@vite(['resources/js/style.js'])

<script src="{{asset('js/user/script.js')}}"></script>
{{--<script>--}}
{{--    $(document).ready(function(){--}}
{{--        $('.owl-carousel-ekip').owlCarousel();--}}
{{--    });--}}
{{--</script>--}}
<div class="sabit-randevu-al">
    <a href="/teklif-al">
        <img src="{{asset('images/user/')}}/sizi-arayalim.png" alt="Sizi Arayalım">
    </a>
</div>


{{--<div class="social-media">--}}
{{--    <a href="{{$contacts->socialMedia->instagram}}"><figure><img src="{{asset("images/site/icons/siyah/instagram.svg")}}" alt=""></figure></a>--}}
{{--    <a href="{{$contacts->socialMedia->linkedin}}"><figure><img src="{{asset("images/site/icons/siyah/linkedin.svg")}}" alt=""></figure></a>--}}
{{--    <a href="{{$contacts->socialMedia->youtube}}"><figure><img src="{{asset("images/site/icons/siyah/youtube.svg")}}" alt=""></figure></a>--}}
{{--    <a href="{{$contacts->socialMedia->facebook}}"><figure><img src="{{asset("images/site/icons/siyah/facebook.svg")}}" alt=""></figure></a>--}}
{{--    <a href="{{$contacts->socialMedia->twitter}}"><figure><img src="{{asset("images/site/icons/siyah/twitter-x.svg")}}" alt=""></figure></a>--}}

{{--    <a href="https://wa.me/+9{{$contacts->phone}}?text=Randevu%20almak%20istiyorum" class="wp"><figure><img src="{{asset("images/site/icons/siyah/whatsapp.svg")}}" alt=""></figure></a>--}}
{{--</div>--}}


<footer  class="bg-gri">
    <div class="max-width content-space">
        <div class="item">
            <h2>{{$contacts->city}}</h2>
            <p>{{ $contacts->address }} {{$contacts->state }} / {{$contacts->city}}  <a href="tel:{{$contacts->phone}}">
                    {{$contacts->phone}}
                </a>
                <br>  <a href="mailto:{{$contacts->email}}">{{$contacts->email}}</a></p>

        </div>
        <div class="item">
            <h2>HİZMETLERİMİZ</h2>
            <ul>
                @foreach($footermenus as $menu)


                    <li>
                        <a href="{{ url($menu->slug) }}">{{ $menu->title }}</a>
                    </li>
{{--                    @if($menu?->page)--}}
{{--                        --}}{{-- Kategorinin ana sayfası var mı? (is_main=1) --}}

{{--                        <li>--}}
{{--                            <a href="{{ url($menu->page->slug) }}">--}}
{{--                                {{ $menu->page->title }}--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        --}}{{--main-ul sınıfı sadece sağ tarafa atılan border için secici olarak kullanılmıstır. harıcı bir işlevi yoktur.--}}

{{--                        @if($menu->children->count() > 0)--}}
{{--                            --}}{{-- Alt kategorileri kontrol et --}}

{{--                            @foreach($menu->children as $altKategori)--}}
{{--                                @if($altKategori->page)--}}
{{--                                    --}}{{-- Alt kategorinin ana sayfası var mı? --}}
{{--                                    <li>--}}
{{--                                        <a href="{{ url($altKategori->page->slug) }}">{{ $altKategori->page->title }}</a>--}}
{{--                                    </li>--}}
{{--                                @else--}}
{{--                                    <li>--}}
{{--                                        <a>{{ $altKategori->name }}</a> --}}{{-- Ana sayfa yoksa kategori adını göster --}}
{{--                                    </li>--}}
{{--                                @endif--}}
{{--                            @endforeach--}}

{{--                        @elseif($menu->subPages->count() > 0)--}}
{{--                            --}}{{-- Alt kategori yoksa kategoriye bağlı diğer sayfaları göster --}}

{{--                            @foreach($menu->subPages as $altSayfa)--}}
{{--                                --}}{{-- Hakkımızda, Misyon, Vizyon gibi --}}
{{--                                <li>--}}
{{--                                    <a href="{{ url($altSayfa->slug) }}">{{ $altSayfa->title }}</a>--}}
{{--                                </li>--}}
{{--                            @endforeach--}}

{{--                        @endif--}}

{{--                    @else--}}
{{--                        --}}{{-- Kategorinin ana sayfası yoksa (sadece alt sayfaları var) --}}
{{--                        <li>--}}
{{--                            <a href="#">{{ $menu->name }}</a> --}}{{-- Tıklanamaz kategori adı --}}
{{--                        </li>--}}
{{--                        @if($menu->children->count() > 0)--}}
{{--                            --}}{{-- Alt kategoriler varsa --}}

{{--                            @foreach($menu->children as $altKategori)--}}
{{--                                @if($altKategori->page)--}}
{{--                                    <li>--}}
{{--                                        <a href="{{ url($altKategori->page->slug) }}">{{ $altKategori->page->title }}</a>--}}
{{--                                    </li>--}}
{{--                                @else--}}
{{--                                    <li>--}}
{{--                                        <a>{{ $altKategori->name }}</a>--}}
{{--                                    </li>--}}
{{--                                @endif--}}
{{--                            @endforeach--}}

{{--                        @elseif($menu->subPages->count() > 0)--}}
{{--                            --}}{{-- Sadece alt sayfalar varsa --}}

{{--                            @foreach($menu->subPages as $altSayfa)--}}
{{--                                <li>--}}
{{--                                    <a href="{{ url($altSayfa->slug) }}">{{ $altSayfa->title }}</a>--}}
{{--                                </li>--}}
{{--                            @endforeach--}}

{{--                        @endif--}}

{{--                    @endif--}}
                @endforeach
            </ul>
        </div>

        <div class="item social-media">
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
        <div class="item">
            <figure><img src="{{asset("images/user/google-partner.svg")}}" alt=""></figure>

        </div>


    </div>
    <div class="copyright content-space">
        <div class="max-width">
            <div class="copyright-left">
                {{--            <p class="copy-text">Copyright © {{date('Y')}}<b> {{env("APP_NAME")}} </b>@lang("resources.ckeditor.about.copy")</p>--}}
                <p>Copyright © {{date('Y')}} <b>{{env("APP_NAME")}}.</b> Tüm Hakları Saklıdır.  <a href="https://www.sahnemedya.com/" target="_blank" class="copyright-right">
                        <b> Kvkk</b>
                    </a></p>

            </div>

        </div>
    </div>
</footer>


<div class="yuzenalan">
    <a onclick="whatsAppAramasi(event,'https://wa.me/+9{{$contacts->phone}}?text=Bilgi%20almak%20istiyorum')"
       href="https://wa.me/+9{{$contacts->phone}}?text=Randevu%20almak%20istiyorum" id="whatsapp-message">
        <div class=" yuzalandiv"></div>
    </a>
    <a href="/teklif-al" id="yuzenRandevu">
        <div class="col-2 yuzalandiv"></div>
    </a>
    <a onclick="telefonpAramasi(event,'tel:{{$contacts->phone}}')" href="tel:{{$contacts->phone}}"
       id="callPhone">
        <div class=" yuzalandiv"></div>
    </a>
</div>





{{--<a href="javascript:void(0)" id="yukari" title="Başa Dön" style="display: none;">--}}
{{--    <i class="las la-arrow-up"></i>--}}
{{--</a>--}}
<script>

    $(window).scroll(function () {
        if ($(this).scrollTop() >= 350) {
            $('#yukari').fadeIn(200);
        } else {
            $('#yukari').fadeOut(200);
        }
    });

    $('a#yukari').click(function () {
        $('html, body').animate({scrollTop: $('body').offset().top}, 'slow');
        return false;
    });
</script>


<script>
    function whatsAppAramasi(e, link) {
        e.preventDefault();
        console.log("whatsapp aramasi yapildi" + link);
        $.ajax({
            url: '{{route('aramaKayit')}}',
            type: 'POST',
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {'arama': 'wp'},
            success: function (result) {
                console.log('result.success');
            },
            error: function (result) {
                console.log('result.error');
            }
        });
        window.open(link, '_blank');
    }

    function telefonpAramasi(e, link) {
        e.preventDefault();
        $.ajax({
            url: '{{route('aramaKayit')}}',
            type: 'POST',
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {'arama': 'tel'},
            success: function (result) {
                console.log('result.success');
            },
            error: function (result) {
                console.log('result.error');
            }
        });
        window.open(link, '_blank');
    }
</script>
<script>
    $(document).ready(function () {
        $('.owl-carousel-slider').owlCarousel({
            loop: true,
            margin: 10,
            responsiveClass: true,
            nav: false,
            dots: false,
            autoplay: true,
            autoplayTimeout: 5500,
            smartSpeed: 2500,
            responsive: {
                0: {
                    items: 1,
                },
                600: {
                    items: 1,
                },
                1000: {
                    items: 1,
                }
            }
        });
    })
    ;
    $(document).ready(function () {
        $('.custom-carousel').owlCarousel({
            loop: true,
            margin: 20,
            nav: true, // Bunu true yapın
            navText: ['‹', '›'], // Basit ok karakterleridots: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            stagePadding: 0,
            center: false,
            responsive: {
                0: {
                    items: 1,
                    margin: 10
                },
                600: {
                    items: 2,
                    margin: 15
                },
                900: {
                    items: 3,
                    margin: 20
                },
                1200: {
                    items: 4,
                    margin: 20
                }
            }
        });
    });
    $('.owl-referanslar').owlCarousel({
        loop: true,
        margin: 20,
        nav: true, // Bunu true yapın
        navText: ['‹', '›'], // Basit ok karakterleridots: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        stagePadding: 0,
        center: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 6
            }
        }
    });

</script>
@yield('js')
</body>
</html>
