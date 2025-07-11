@extends('user.partial.master')
@section('content')


    <section class="normal-sayfa content-space">
        <div class="max-width">
            <div class="text">

                <h1>{{ $page->title }}</h1>

                @if($page->image != NULL)
                    <figure class="normal"
                            @if($page->image != NULL) data-src="{{$page->image()}}"
                            @else
                                data-src="{{$page->image()}}"
                            @endif  data-fancybox="{{$page->title}}">

                        <img src="{{$page->image()}}" alt="">
                    </figure>
                @endif
                {!! $page->content !!}

                @if($sayfa->getGaleri->count()>0)

                    <h2>Foto Galeri</h2>
                    <div class="galeri">
                        @foreach($sayfa->getGaleri as $galeri)
                            <figure class="galeri-figure">
                                <img src="{{asset('images/user/galeri/')}}/{{$galeri->resim}}"
                                     alt="{{$sayfa->baslik}} Galeri Resmi {{$loop->index}}">
                            </figure>
                        @endforeach
                    </div>
                @endif
            </div>


        </div>
    </section>

@endsection


