@extends('user.partial.master')
@section('content')

    <section class="normal-sayfa content-space">
        <div class="max-width ">
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

                <div class="haberler">
                    @foreach($page->allChildrenBlog as $item)
                        <a href="{{$item->slug}}" class="haber">
                            <figure>
                                @if($item->image!=NULL)
                                    <img src="{{$item->image()}}" alt="{{$item->title}}">
                                @else
                                    <img src="{{asset("images/user/nophoto.jpg")}}" alt="{{$item->title}}">
                                @endif
                            </figure>
                            <div class="haber-content">
                                <h2 class="news-title">{{ $item->title }}</h2>
                                <p class="news-excerpt">{!! Str::limit(strip_tags($item->content), 80) !!}</p>
                                <button class="read-more-btn">Devamını Oku ➤</button>
                            </div>
                        </a>
                    @endforeach
                </div>


            </div>



        </div>
    </section>



@endsection








