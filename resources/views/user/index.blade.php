@extends('user.partial.master')

@section('content')

        @if($sliders != NULL)
            <!--Slider-->
            <div class="owl-carousel owl-carousel-slider owl-theme">
                @foreach($sliders as $slider)
                    <a @if($slider->url) href="{{$slider->url}}" @endif class="item">
                        <img class="web-slider" src="{{$slider->image()}}"
                             title="{{$slider->title}} | {{$siteSetting->site_name}}"
                             alt="{{$slider->title}} | {{$siteSetting->site_name}}">
                        <img class="mobil-slider" src="{{$slider->mobilImage()}}"
                             title="{{$slider->title}} | {{$siteSetting->site_name}}"
                             alt="{{$slider->title}} | {{$siteSetting->site_name}}">
                    </a>
                @endforeach
            </div>

        @endif

    <h1 style="display: none">Adana Reklam Ajansı & SEO & Web Tasarım</h1>



    <div class="index-1 bg-gri content-space">
        <div class="max-width">
            <h3 class="ust-header">Gelecek Sizin, Sahne Sizin</h3>
            <h2>ADANA REKLAM AJANSI</h2>
            <h3 class="alt-header">Seo & Web Tasarım</h3>
            <p>Sahne Medya, dijital pazarlama, iş yaşamı, reklamcılık ve medya sektöründeki en yeni gelişmeleri,
                trendleri
                yakından takip eder. Siz de Google Partneri Sahne Medya ile bilinirliğinize ve ticari hacminizi
                arttırabilirsiniz. Sahne bizim işimiz, hayalleriniz ise önceliğimiz...</p>
        </div>

    </div>
    <div class="index-2 content-space">
        <div class="max-width">
            <figure><img src="{{asset("images/user/hakkimizda-index.png")}}" alt=""></figure>

            <div class="text">
                <h2>Hakkımızda</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima, mollitia sapiente? Alias aliquam
                    cupiditate facilis illum magnam magni minima necessitatibus quis reprehenderit sequi. Autem
                    consequuntur eligendi libero mollitia perferendis. Consequuntur.</p>

                <a href="/hakkimizda" class="transparent-btn">
                    Detaylı İncele
                    <span class="arrow">→</span>
                </a>
            </div>
        </div>
    </div>
    <div class="index-2 bg-gri">
        <div class="max-width content-space">
            <div class="text">
                <h2>Neden Sahne Medya</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima, mollitia sapiente? Alias aliquam
                    cupiditate facilis illum magnam magni minima necessitatibus quis reprehenderit sequi. Autem
                    consequuntur eligendi libero mollitia perferendis. Consequuntur.</p>

                <a href="/neden-sahne-medya" class="transparent-btn">
                    Detaylı İncele
                    <span class="arrow">→</span>
                </a>
            </div>
            <figure><img src="{{asset("images/user/neden-sahne-index.png")}}" alt=""></figure>
        </div>
    </div>
    <div class="index-2 content-space">
        <div class="max-width">
            <figure><img src="{{asset("images/user/google-partner-index.png")}}" alt=""></figure>

            <div class="text">
                <h2>Google Partner</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima, mollitia sapiente? Alias aliquam
                    cupiditate facilis illum magnam magni minima necessitatibus quis reprehenderit sequi. Autem
                    consequuntur eligendi libero mollitia perferendis. Consequuntur.</p>

                <a href="/google-partner-nedir" class="transparent-btn">
                    Detaylı İncele
                    <span class="arrow">→</span>
                </a>
            </div>
        </div>
    </div>
    <div class="index-1-slider bg-gri content-space">
        <div class="max-width">
            <h3 class="ust-header">Yaptığımız Hizmetler</h3>
            <h2>SAHNEYE ÇIKMAK İÇİN</h2>
            <h3 class="alt-header">Neyi Bekliyorsunuz?</h3>
            <p> Sahne Medya, dijital pazarlama, iş yaşamı, reklamcılık ve medya sektöründeki en yeni gelişmeleri,
                trendleri yakından takip eder. Siz de Google Partner Sahne Medya ile bilinirliğinize ve ticari hacminizi
                arttırabilirsiniz. Sahne bizim işimiz, hayalleriniz ise önceliğimiz...</p>
            <div class="owl-carousel owl-theme custom-carousel">
                <a href="/google-ads-reklamlari" class="card-item up">
                    <h3><span class="number">01.</span>Google Ads Reklamları</h3>
                    <p>Pazar ve kelime analizleri yaparak oluşturduğumuz dijital reklam kampanyaları ile...</p>
                    <div>detaylı bilgi →</div>
                </a>
                <a href="/web-tasarim-nedir" class="card-item down">
                    <h3><span class="number">02.</span>Web Tasarım</h3>
                    <p>Firmanızın internetteki görünen yüzü olan web sitesini etkili ve yaratıcı şekilde...</p>
                    <div>detaylı bilgi →</div>
                </a>
                <a href="/seo" class="card-item up">
                    <h3><span class="number">03.</span>Google SEO</h3>
                    <p>Web sitenizi arama motorlarında üst sıralara taşımak için stratejiler geliştiriyoruz...</p>
                    <div>detaylı bilgi →</div>
                </a>
                <a href="/sosyal-medya-yonetimi" class="card-item down">
                    <h3><span class="number">04.</span>Sosyal Medya Yönetimi</h3>
                    <p>Hedef kitlenizle güvenilir bir bağ kurmanız için sosyal medya hesaplarınızı yönetiyoruz...</p>
                    <div>detaylı bilgi →</div>
                </a>
                <a href="/e-ticaret" class="card-item up">
                    <h3><span class="number">05.</span>E-Ticaret Çözümleri</h3>
                    <p>Online satış platformlarınızı kurarak, dijital pazaryeri deneyiminizi en üst seviyeye
                        taşıyoruz...</p>
                    <div>detaylı bilgi →</div>
                </a>

            </div>

{{--            <a href="" class="transparent-btn">--}}
{{--                Tümünü İncele--}}
{{--                <span class="arrow">→</span>--}}
{{--            </a>--}}
        </div>

    </div>
    <div class="index-1 content-space">
        <div class="max-width">
            <h3 class="ust-header">Düşünün!</h3>
            <h2>BİR ADIM ÖNDE OLMAK</h2>
            <h3 class="alt-header">Neleri Değiştirebilir?</h3>
            <p>Sahne Medya, dijital pazarlama, iş yaşamı, reklamcılık ve medya sektöründeki en yeni gelişmeleri,
                trendleri yakından takip eder. Siz de Google Partneri Sahne
                Medya ile bilinirliğinize ve ticari hacminizi arttırabilirsiniz. Sahne bizim işimiz, hayalleriniz ise önceliğimiz...</p>
        </div>

    </div>
    <div class="index-2 bg-gri content-space">
        <div class="max-width">
            <figure><img src="{{asset("images/user/seo-index.png")}}" alt=""></figure>

            <div class="text">
                <h2>SEO NEDİR?</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima, mollitia sapiente? Alias aliquam
                    cupiditate facilis illum magnam magni minima necessitatibus quis reprehenderit sequi. Autem
                    consequuntur eligendi libero mollitia perferendis. Consequuntur.</p>

                <a href="/seo" class="transparent-btn">
                    Detaylı İncele
                    <span class="arrow">→</span>
                </a>
            </div>
        </div>
    </div>
    <div class="index-2 content-space">
        <div class="max-width ">
            <div class="text">
                <h2>Geo</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima, mollitia sapiente? Alias aliquam
                    cupiditate facilis illum magnam magni minima necessitatibus quis reprehenderit sequi. Autem
                    consequuntur eligendi libero mollitia perferendis. Consequuntur.</p>

                <a href="/geo" class="transparent-btn">
                    Detaylı İncele
                    <span class="arrow">→</span>
                </a>
            </div>
            <figure><img src="{{asset("images/user/internet-reklamlari-index.png")}}" alt=""></figure>
        </div>
    </div>
    <div class="index-2 bg-gri content-space">
        <div class="max-width ">
            <figure><img src="{{asset("images/user/internet-reklamlari-index.png")}}" alt=""></figure>
            <div class="text">
                <h2>İNTERNET REKLAMLARI</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima, mollitia sapiente? Alias aliquam
                    cupiditate facilis illum magnam magni minima necessitatibus quis reprehenderit sequi. Autem
                    consequuntur eligendi libero mollitia perferendis. Consequuntur.</p>

                <a href="/google-ads-reklamlari" class="transparent-btn">
                    Detaylı İncele
                    <span class="arrow">→</span>
                </a>
            </div>

        </div>
    </div>
    <div class="index-2  content-space">
        <div class="max-width">

            <div class="text">
                <h2>MODERN WEB</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima, mollitia sapiente? Alias aliquam
                    cupiditate facilis illum magnam magni minima necessitatibus quis reprehenderit sequi. Autem
                    consequuntur eligendi libero mollitia perferendis. Consequuntur.</p>

                <a href="/web-tasarim-nedir" class="transparent-btn">
                    Detaylı İncele
                    <span class="arrow">→</span>
                </a>
            </div>
            <figure><img src="{{asset("images/user/modern-web-index.png")}}" alt=""></figure>

        </div>
    </div>
    <div class="index-1 bg-gri content-space">
        <div class="max-width">
            <h3 class="ust-header">HAYAT BİR SAHNE</h3>
            <h2>Neden Sahne Medya?</h2>
            <h3 class="alt-header">Ve İzleyicileriniz Tüketiciler!</h3>
            <p> Sahne Medya, dijital pazarlama, iş yaşamı, reklamcılık ve medya sektöründeki en yeni gelişmeleri, trendleri yakından takip eder. Siz de Google Partneri Sahne
                Medya ile bilinirliğinize ve ticari hacminizi arttırabilirsiniz. Sahne bizim işimiz, hayalleriniz ise  önceliğimiz...</p>
           <div class="owl-carousel owl-theme owl-referanslar">
               @foreach($references as $reference)
               <div class="item">
                   <figure>
                       <img src="{{$reference->image()}}" alt="{{$reference->name}}">
                   </figure>
               </div>
               @endforeach
           </div>

            <a href="/referanslarimiz" class="transparent-btn">
                Tümünü İncele
                <span class="arrow">→</span>
            </a>
        </div>

    </div>
    <div class="index-1  content-space">
        <div class="max-width">
            <h3 class="ust-header">Sahne Medya</h3>
            <h2>ADANA REKLAM AJANSI</h2>
            <h3 class="alt-header">Haberler & Blog</h3>
            <p>Sahne Medya, dijital pazarlama, iş yaşamı, reklamcılık ve medya sektöründeki en yeni gelişmeleri,
                trendleri
                yakından takip eder. Siz de Google Partneri Sahne Medya ile bilinirliğinize ve ticari hacminizi
                arttırabilirsiniz. Sahne bizim işimiz, hayalleriniz ise önceliğimiz...</p>

            <div class="haberler mt-20">
                @foreach($blogs as $blog)

                    <a href="{{ $blog->slug }}" class="haber anasayfa-none">
                        <figure>
                            <img src="{{ $blog->image() }}" alt="{{ $blog->title }}"/>
                        </figure>
                        <div class="haber-icerik">
                            <h3>{{ $blog->title }}</h3>
                            <div class="haber-alt">
                                <div class="detayli-incele">
                                    Detaylı İncele
                                    <span class="arrow">→</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach

            </div>
            <a href="/blog" class="transparent-btn mt-20">
                Tümünü İncele
                <span class="arrow">→</span>
            </a>
        </div>

    </div>
@endsection
