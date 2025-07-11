{{--<div class="sidemenu">--}}
{{--    @if($navbarMenus->parent != NULL)--}}

{{--        <a class="parentPage"--}}
{{--           href="@if($navbarMenus->parent->page != NULL){{$navbarMenus->parent->page->slug}} @endif">--}}
{{--            {{$navbarMenus->parent->name}} <i class="fa fa-angle-down"></i></a>--}}

{{--        @foreach($navbarMenus->parent->childAll as $child)--}}
{{--            @if($child->page != NULL)--}}
{{--                <a href="{{$child->page->slug}}"--}}
{{--                   class="@if($child->page->slug == Request::segment(1)) active @endif">--}}
{{--                    {{$child->name}}--}}
{{--                </a>--}}
{{--            @endif--}}

{{--        @endforeach--}}
{{--    @endif--}}
{{--</div>--}}

{{-- resources/views/user/partial/breadcrumb.blade.php --}}
{{--@if(isset($breadcrumbData) && count($breadcrumbData) > 0)--}}
{{--    <div class="breadcrumb-container">--}}
{{--        <nav aria-label="breadcrumb">--}}
{{--            <ol class="breadcrumb">--}}
{{--                <li class="breadcrumb-item">--}}
{{--                    <a href="/"><i class="fa fa-home"></i></a>--}}
{{--                </li>--}}

{{--                @foreach($breadcrumbData as $item)--}}
{{--                    @if($loop->last)--}}
{{--                        <li class="breadcrumb-item active" aria-current="page">--}}
{{--                            {{$item['name']}}--}}
{{--                        </li>--}}
{{--                    @else--}}
{{--                        <li class="breadcrumb-item">--}}
{{--                            <a href="{{$item['url']}}">{{$item['name']}}</a>--}}
{{--                        </li>--}}
{{--                    @endif--}}
{{--                @endforeach--}}
{{--            </ol>--}}
{{--        </nav>--}}
{{--    </div>--}}
{{--@endif--}}





<div class="sidemenu">
    @if($navbarMenus->count() > 0)
        @foreach($navbarMenus as $category)
            <!-- Kategori başlığı -->
            <a class="parentPage" href="@if($category->page != NULL){{$category->page->slug}}@endif">
                {{$category->name}} <i class="fa fa-angle-down"></i>
            </a>

            <!-- Kategorinin ana sayfası varsa -->
            @if($category->page != NULL)
                <a href="{{$category->page->slug}}"
                   class="@if($category->page->slug == Request::segment(1)) active @endif">
                    {{$category->page->title ?? $category->name}}
                </a>
            @endif

            <!-- Kategorinin alt sayfaları -->
            @foreach($category->subPages as $subPage)
                <a href="{{$subPage->slug}}"
                   class="@if($subPage->slug == Request::segment(1)) active @endif">
                    {{$subPage->title}}
                </a>
            @endforeach
        @endforeach
    @endif
</div>









{{--@foreach($navbarMenus as $menu)--}}

{{--    @if($menu->page) --}}{{-- Kategorinin ana sayfası var mı? --}}

{{--    <li class="main-li">--}}
{{--        <a href="{{ url($menu->page->slug) }}">--}}
{{--            {{ $menu->page->title }}--}}
{{--        </a>--}}

{{--        @if($menu->children->count() > 0)--}}
{{--            <ul class="altmenu">--}}
{{--                @foreach($menu->children as $altKategori)--}}
{{--                    @if($altKategori->page)--}}
{{--                        <li>--}}
{{--                            <a href="{{ url($altKategori->page->slug) }}">{{ $altKategori->page->title }}</a>--}}

{{--                            --}}{{-- 3. Seviye: Alt kategorinin alt sayfaları varsa ve alt sayfa bir başka sayfaya ait değilse --}}
{{--                            @if ($altKategori->subPages->count() > 0)--}}
{{--                                <ul class="alt-altmenu">--}}
{{--                                    @foreach($altKategori->subPages as $altAltSayfa)--}}
{{--                                        @if (!$altAltSayfa->parent_page)--}}
{{--                                            <li>--}}
{{--                                                <a href="{{ url($altAltSayfa->slug) }}">{{ $altAltSayfa->title }}</a>--}}

{{--                                                --}}{{-- 4. Seviye (isteğe bağlı): alt-alt sayfanın çocukları varsa --}}
{{--                                                @if ($altAltSayfa->children && $altAltSayfa->children->count())--}}
{{--                                                    <ul class="alt-altmenu">--}}
{{--                                                        @foreach ($altAltSayfa->children as $thirdLevelPage)--}}
{{--                                                            <li>--}}
{{--                                                                <a href="{{ url($thirdLevelPage->slug) }}">{{ $thirdLevelPage->title }}</a>--}}
{{--                                                            </li>--}}
{{--                                                        @endforeach--}}
{{--                                                    </ul>--}}
{{--                                                @endif--}}
{{--                                            </li>--}}
{{--                                        @endif--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}
{{--                            @endif--}}
{{--                        </li>--}}
{{--                    @else--}}
{{--                        <li>--}}
{{--                            <a>{{ $altKategori->name }}</a>--}}
{{--                        </li>--}}
{{--                    @endif--}}
{{--                @endforeach--}}
{{--            </ul>--}}

{{--        @elseif($menu->subPages->count() > 0)--}}
{{--            <ul class="altmenu">--}}
{{--                @foreach($menu->subPages as $altSayfa)--}}
{{--                    @if (!$altSayfa->parent_page)--}}
{{--                        <li>--}}
{{--                            <a href="{{ url($altSayfa->slug) }}">{{ $altSayfa->title }}</a>--}}

{{--                            --}}{{-- 3. Seviye: Alt sayfanın alt sayfaları varsa --}}
{{--                            @if ($altSayfa->children && $altSayfa->children->count())--}}
{{--                                <ul class="alt-altmenu">--}}
{{--                                    @foreach ($altSayfa->children as $altAltSayfa)--}}
{{--                                        <li>--}}
{{--                                            <a href="{{ url($altAltSayfa->slug) }}">{{ $altAltSayfa->title }}</a>--}}

{{--                                            --}}{{-- 4. Seviye (isteğe bağlı): alt-alt sayfanın çocukları varsa --}}
{{--                                            @if ($altAltSayfa->children && $altAltSayfa->children->count())--}}
{{--                                                <ul class="alt-altmenu">--}}
{{--                                                    @foreach ($altAltSayfa->children as $thirdLevelPage)--}}
{{--                                                        <li>--}}
{{--                                                            <a href="{{ url($thirdLevelPage->slug) }}">{{ $thirdLevelPage->title }}</a>--}}
{{--                                                        </li>--}}
{{--                                                    @endforeach--}}
{{--                                                </ul>--}}
{{--                                            @endif--}}
{{--                                        </li>--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}
{{--                            @endif--}}
{{--                        </li>--}}
{{--                    @endif--}}
{{--                @endforeach--}}
{{--            </ul>--}}
{{--        @endif--}}
{{--    </li>--}}

{{--    @else--}}
{{--        <li class="main-li">--}}
{{--            <a href="#">{{ $menu->name }}</a>--}}

{{--            @if($menu->children->count() > 0)--}}
{{--                <ul class="altmenu">--}}
{{--                    @foreach($menu->children as $altKategori)--}}
{{--                        @if($altKategori->page)--}}
{{--                            <li>--}}
{{--                                <a href="{{ url($altKategori->page->slug) }}">{{ $altKategori->page->title }}</a>--}}

{{--                                --}}{{-- 3. Seviye: Alt kategorinin alt sayfaları varsa --}}
{{--                                @if ($altKategori->subPages->count() > 0)--}}
{{--                                    <ul class="alt-altmenu">--}}
{{--                                        @foreach($altKategori->subPages as $altAltSayfa)--}}
{{--                                            @if (!$altAltSayfa->parent_page)--}}
{{--                                                <li>--}}
{{--                                                    <a href="{{ url($altAltSayfa->slug) }}">{{ $altAltSayfa->title }}</a>--}}
{{--                                                </li>--}}
{{--                                            @endif--}}
{{--                                        @endforeach--}}
{{--                                    </ul>--}}
{{--                                @endif--}}
{{--                            </li>--}}
{{--                        @else--}}
{{--                            <li>--}}
{{--                                <a>{{ $altKategori->name }}</a>--}}
{{--                            </li>--}}
{{--                        @endif--}}
{{--                    @endforeach--}}
{{--                </ul>--}}

{{--            @elseif($menu->subPages->count() > 0)--}}
{{--                <ul class="altmenu">--}}
{{--                    @foreach($menu->subPages as $altSayfa)--}}
{{--                        @if (!$altSayfa->parent_page)--}}
{{--                            <li>--}}
{{--                                <a href="{{ url($altSayfa->slug) }}">{{ $altSayfa->title }}</a>--}}

{{--                                @if ($altSayfa->children && $altSayfa->children->count())--}}
{{--                                    <ul class="alt-altmenu">--}}
{{--                                        @foreach ($altSayfa->children as $altAltSayfa)--}}
{{--                                            <li>--}}
{{--                                                <a href="{{ url($altAltSayfa->slug) }}">{{ $altAltSayfa->title }}</a>--}}
{{--                                            </li>--}}
{{--                                        @endforeach--}}
{{--                                    </ul>--}}
{{--                                @endif--}}
{{--                            </li>--}}
{{--                        @endif--}}
{{--                    @endforeach--}}
{{--                </ul>--}}
{{--            @endif--}}
{{--        </li>--}}
{{--    @endif--}}

{{--@endforeach--}}
