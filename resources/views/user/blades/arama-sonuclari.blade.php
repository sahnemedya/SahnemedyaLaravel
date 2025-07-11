@extends('user.partial.master')

@section('content')
    <section class="normal-sayfa content-space">
        <div class="max-width">


            <h1 style="font-size: 36px">{{$pages->title}}</h1>
            <p><b>{{$aramaMetni}}</b> aramanızda <b>{{$pages2->count()}}</b> adet Sonuç bulunmuştur.</p>

            <div class="arama-list">
                @foreach($pages2 as $urun)
                    @if($urun->getSayfa!=NULL)
                        <a href="{{$urun->getSayfa->slug}}" class="arama">
                            <figure>
                                @if($urun->getSayfa->image!=NULL)
                                    <img src="{{asset("images/user/sayfalar/")}}/{{$urun->getSayfa->image}}"
                                         alt="">
                                @else
                                    <img src="{{asset("images/nophoto-urunler.jpg")}}"
                                         alt="">
                                @endif
                            </figure>
                            <div class="text">
                                <div class="aciklama">
                                    <span>{{$urun->note}}</span>
                                    <h2><span style="display: none">{{$urun->note}}</span> {{$urun->getSayfa->title}}</h2>
                                </div>
                                <i class="las la-arrow-right"></i>
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>


    </section>
@endsection
@section("extraJs")
    <script>
        document.querySelectorAll('.ozellik-checkbox').forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                filterProducts();
            });
        });

        function filterProducts() {
            // tüm checkboxları al
            let selectedFilters = Array.from(document.querySelectorAll('.ozellik-checkbox:checked')).map(cb => cb.id);

            // tüm urunleri al
            let products = document.querySelectorAll('.urun-listesi');

            products.forEach(function (product) {
                // Check if the product has all the selected filters as class names
                let hasAllFilters = selectedFilters.every(filter => product.classList.contains(filter));

                if (hasAllFilters) {
                    product.classList.remove('urun-none');
                    product.classList.add('urun-show');
                } else {
                    product.classList.remove('urun-show');
                    product.classList.add('urun-none');
                }
            });
        }
    </script>
@endsection
