<nav class="topbar koyu-arkaplan">
    <a href="{{route("cms.dashboard")}}" class="logo">
        <img src="{{asset("images/panel/site/logo.png")}}" alt="">
    </a>
    <div class="user">
        <figure>
            <img src="{{asset("images/panel/site/user.svg")}}" alt="">
        </figure>
        <div class="username">{{ Auth::user()->name }}<i class="las la-angle-down"></i></div>
        <ul class="alt-menu">
            <li><a href="{{route('cms.profile.edit')}}">Profil</a></li>
            <li>
                <form action="{{ route('cms.logout') }}" method="POST" class="logout-form">
                    @csrf
                    <input type="submit" value="Çıkış Yap">
                </form>
            </li>
        </ul>
    </div>
</nav>


<nav class="sidebar koyu-arkaplan">
    <ul class="ust-menu">
        <li class="ust-menu-li {{ request()->routeIs('cms.dashboard') ? 'aktif' : '' }}">
            <a href="{{route('cms.dashboard')}}">Anasayfa </a>
        </li>
        @permission('blade')
        {{--        Blade --}}
        <li class="ust-menu-li {{ request()->routeIs('cms.blades.*') ? 'aktif' : '' }}">
            <a href="{{route('cms.blades.index')}}">Blade <i class="las la-angle-right"></i></a>

            <ul class="alt-menu">

                <li class="{{ request()->routeIs('cms.blades.index') ? 'aktif' : '' }}">
                    <a href="{{route('cms.blades.index')}}">Tümü</a>
                </li>

                <li class="{{ request()->routeIs('cms.blades.create') ? 'aktif' : '' }}">
                    <a href="{{route('cms.blades.create')}}">Oluştur</a>
                </li>

            </ul>
        </li>
        @endpermission

        @permission('dil')
        {{--        Language --}}
        <li class="ust-menu-li {{ request()->routeIs('cms.languages.*') ? 'aktif' : '' }}">
            <a href="{{route('cms.languages.index')}}">Dil <i class="las la-angle-right"></i></a>

            <ul class="alt-menu">

                <li class="{{ request()->routeIs('cms.languages.index') ? 'aktif' : '' }}">
                    <a href="{{route('cms.languages.index')}}">Tümü</a>
                </li>

                <li class="{{ request()->routeIs('cms.languages.create') ? 'aktif' : '' }}">
                    <a href="{{route('cms.languages.create')}}">Oluştur</a>
                </li>

            </ul>
        </li>
        @endpermission
        @permission('kategori')
        {{--        Category --}}
        <li class="ust-menu-li {{ request()->routeIs('cms.category.*') ? 'aktif' : '' }}">
            <a href="{{route('cms.category.index')}}">Kategoriler <i class="las la-angle-right"></i></a>

            <ul class="alt-menu">

                <li class="{{ request()->routeIs('cms.category.index') ? 'aktif' : '' }}">
                    <a href="{{route('cms.category.index')}}">Tümü</a>
                </li>

                <li class="{{ request()->routeIs('cms.category.create') ? 'aktif' : '' }}">
                    <a href="{{route('cms.category.create')}}">Oluştur</a>
                </li>

                <li class="{{ request()->routeIs('cms.category.deleted') ? 'aktif' : '' }}">
                    <a href="{{route('cms.category.deleted')}}">Silinenler</a>
                </li>

            </ul>
        </li>
        @endpermission

        @permission('sayfa')
        {{--        Pages --}}
        <li class="ust-menu-li {{ request()->routeIs('cms.pages.*') ? 'aktif' : '' }}">
            <a href="{{route('cms.pages.index')}}">Sayfalar <i class="las la-angle-right"></i></a>

            <ul class="alt-menu">

                <li class="{{ request()->routeIs('cms.pages.index') ? 'aktif' : '' }}">
                    <a href="{{route('cms.pages.index')}}">Tümü</a>
                </li>

                <li class="{{ request()->routeIs('cms.pages.create') ? 'aktif' : '' }}">
                    <a href="{{route('cms.pages.create')}}">Oluştur</a>
                </li>

                <li class="{{ request()->routeIs('cms.pages.deleted') ? 'aktif' : '' }}">
                    <a href="{{route('cms.pages.deleted')}}">Silinenler</a>
                </li>

            </ul>
        </li>
        @endpermission

{{--        @permission('doktorlar')--}}
{{--        --}}{{--        Pages --}}
{{--        <li class="ust-menu-li {{ request()->routeIs('cms.doctors.*') ? 'aktif' : '' }}">--}}
{{--            <a href="{{route('cms.doctors.index')}}">Doktorlar <i class="las la-angle-right"></i></a>--}}

{{--            <ul class="alt-menu">--}}

{{--                <li class="{{ request()->routeIs('cms.doctors.index') ? 'aktif' : '' }}">--}}
{{--                    <a href="{{route('cms.doctors.index')}}">Tümü</a>--}}
{{--                </li>--}}

{{--                <li class="{{ request()->routeIs('cms.doctors.create') ? 'aktif' : '' }}">--}}
{{--                    <a href="{{route('cms.doctors.create')}}">Oluştur</a>--}}
{{--                </li>--}}

{{--                <li class="{{ request()->routeIs('cms.doctors.deleted') ? 'aktif' : '' }}">--}}
{{--                    <a href="{{route('cms.doctors.deleted')}}">Silinenler</a>--}}
{{--                </li>--}}

{{--            </ul>--}}
{{--        </li>--}}
{{--        @endpermission--}}

        @permission('ozel-menuler')
            @foreach($specialMenus as $menu)
                @php
                    $currentId = request()->route('id') ?? request()->route('categoryId');
                    $isActive = $currentId == $menu->id && request()->routeIs('cms.side-menu-elements.*');
                @endphp
                <li class="ust-menu-li {{ $isActive ? 'aktif' : '' }}">
                    <a href="#">{{$menu->name}} <i class="las la-angle-right"></i></a>
                    <ul class="alt-menu">
                        <li class="{{ request()->routeIs('cms.side-menu-elements.index') && $isActive ? 'aktif' : '' }}">
                            <a href="{{route('cms.side-menu-elements.index',$menu->id)}}">Listele</a>
                        </li>
                        <li class="{{ request()->routeIs('cms.side-menu-elements.create') && $isActive ? 'aktif' : '' }}">
                            <a href="{{route('cms.side-menu-elements.create',$menu->id)}}">Ekle</a>
                        </li>
                        <li class="{{ request()->routeIs('cms.side-menu-elements.deleted') && $isActive ? 'aktif' : '' }}">
                            <a href="{{route('cms.side-menu-elements.deleted',$menu->id)}}">Silinenler</a>
                        </li>
                    </ul>
                </li>
            @endforeach
        @endpermission

        @permission('slider')
        {{--        Slider --}}
        <li class="ust-menu-li {{ request()->routeIs('cms.slider.*') ? 'aktif' : '' }}">
            <a href="{{route('cms.slider.index')}}">Slayt - Banner <i class="las la-angle-right"></i></a>

            <ul class="alt-menu">

                <li class="{{ request()->routeIs('cms.slider.index') ? 'aktif' : '' }}">
                    <a href="{{route('cms.slider.index')}}">Tümü</a>
                </li>

                <li class="{{ request()->routeIs('cms.slider.create') ? 'aktif' : '' }}">
                    <a href="{{route('cms.slider.create')}}">Oluştur</a>
                </li>

            </ul>
        </li>
        @endpermission

        @permission('galeri')
        {{--        Slider --}}
        <li class="ust-menu-li {{ request()->routeIs('cms.gallery.*') ? 'aktif' : '' }}">
            <a href="{{route('cms.gallery.index')}}">Galeri <i class="las la-angle-right"></i></a>

            <ul class="alt-menu">

                <li class="{{ request()->routeIs('cms.gallery.index') ? 'aktif' : '' }}">
                    <a href="{{route('cms.gallery.index')}}">Tümü</a>
                </li>

            </ul>
        </li>
        @endpermission

        @permission('referanslar')
        {{--        References --}}
        <li class="ust-menu-li {{ request()->routeIs('cms.references.*') ? 'aktif' : '' }}">
            <a href="{{route('cms.references.index')}}">Referanslar <i class="las la-angle-right"></i></a>

            <ul class="alt-menu">
                <li class="{{ request()->routeIs('cms.references.index') ? 'aktif' : '' }}">
                    <a href="{{route('cms.references.index')}}">Tümü</a>
                </li>

                <li class="{{ request()->routeIs('cms.references.create') ? 'aktif' : '' }}">
                    <a href="{{route('cms.references.create')}}">Oluştur</a>
                </li>
            </ul>

        </li>
        @endpermission

        @permission('sertifikalar')
        {{--        Certificates --}}
        <li class="ust-menu-li {{ request()->routeIs('cms.certificate.*') ? 'aktif' : '' }}">
            <a href="{{route('cms.certificate.index')}}">Sertifikalar <i class="las la-angle-right"></i></a>

            <ul class="alt-menu">
                <li class="{{ request()->routeIs('cms.certificate.index') ? 'aktif' : '' }}">
                    <a href="{{route('cms.certificate.index')}}">Tümü</a>
                </li>

                <li class="{{ request()->routeIs('cms.certificate.create') ? 'aktif' : '' }}">
                    <a href="{{route('cms.certificate.create')}}">Oluştur</a>
                </li>
            </ul>

        </li>
        @endpermission
        @permission('formlar')
        {{--        Formlar --}}
        <li class="ust-menu-li {{ request()->routeIs('cms.forms.*') ? 'aktif' : '' }}">
            <a href="">Formlar <i class="las la-angle-right"></i></a>

            <ul class="alt-menu">

                <li class="{{ request()->routeIs('cms.forms.iletisimFormu') ? 'aktif' : '' }}">
                    <a href="{{ route('cms.forms.iletisimFormu') }}">İletişim Formları</a>
                </li>
                <li class="{{ request()->routeIs('cms.forms.bayilikBasvuruFormu') ? 'aktif' : '' }}">
                    <a href="{{ route('cms.forms.bayilikBasvuruFormu') }}">Bayilik Başvuru Formları</a>
                </li>
                <li class="{{ request()->routeIs('cms.forms.insanKaynaklariFormu') ? 'aktif' : '' }}">
                    <a href="{{ route('cms.forms.insanKaynaklariFormu') }}">İnsan Kaynakları Formları</a>
                </li>

            </ul>
        </li>
        @endpermission
        @permission('basin-kiti')
        {{--        Preess Kits --}}
        <li class="ust-menu-li {{ request()->routeIs('cms.press-kit.*') ? 'aktif' : '' }}">
            <a href="{{route('cms.press-kit.index')}}">Basın Kiti <i class="las la-angle-right"></i></a>

            <ul class="alt-menu">
                <li class="{{ request()->routeIs('cms.press-kit.index') ? 'aktif' : '' }}">
                    <a href="{{route('cms.press-kit.index')}}">Tümü</a>
                </li>

                <li class="{{ request()->routeIs('cms.press-kit.create') ? 'aktif' : '' }}">
                    <a href="{{route('cms.press-kit.create')}}">Oluştur</a>
                </li>
            </ul>

        </li>
        @endpermission
        @permission('popup')
        {{--        Popup --}}
        <li class="ust-menu-li {{ request()->routeIs('cms.popup.*') ? 'aktif' : '' }}">
            <a href="{{route('cms.popup.index')}}">Pop-Up <i class="las la-angle-right"></i></a>

            <ul class="alt-menu">

                <li class="{{ request()->routeIs('cms.popup.index') ? 'aktif' : '' }}">
                    <a href="{{route('cms.popup.index')}}">Tümü</a>
                </li>

                <li class="{{ request()->routeIs('cms.popup.create') ? 'aktif' : '' }}">
                    <a href="{{route('cms.popup.create')}}">Oluştur</a>
                </li>
            </ul>
        </li>
        @endpermission

        @permission('seo')
        {{--        Seo --}}
        <li class="ust-menu-li {{ request()->routeIs('cms.seos.*') ? 'aktif' : '' }}">
            <a href="{{route('cms.seos.index')}}">Seo & Geo <i class="las la-angle-right"></i></a>

            <ul class="alt-menu">

                <li class="{{ request()->routeIs('cms.seos.index') ? 'aktif' : '' }}">
                    <a href="{{route('cms.seos.index')}}">Tümü</a>
                </li>

                <li class="{{ request()->routeIs('cms.seos.create') ? 'aktif' : '' }}">
                    <a href="{{route('cms.seos.create')}}">Oluştur</a>
                </li>
            </ul>
        </li>
        @endpermission

        @permission('iletisim')
        {{--        Contacts --}}
        <li class="ust-menu-li {{ request()->routeIs('cms.contacts.*') ? 'aktif' : '' }}">
            <a href="{{route('cms.contacts.index')}}">İletişim Bilgileri <i class="las la-angle-right"></i></a>

            <ul class="alt-menu">

                <li class="{{ request()->routeIs('cms.contacts.index') ? 'aktif' : '' }}">
                    <a href="{{route('cms.contacts.index')}}">Tümü</a>
                </li>

                <li class="{{ request()->routeIs('cms.seos.create') ? 'aktif' : '' }}">
                    <a href="{{route('cms.contacts.create')}}">Oluştur</a>
                </li>
                <li class="{{ request()->routeIs('cms.seos.deleted') ? 'aktif' : '' }}">
                    <a href="{{route('cms.contacts.deleted')}}">Silinenler</a>
                </li>
            </ul>

        </li>
        @endpermission


        @permission('kullanıcılar')
        {{--        Users--}}
        <li class="ust-menu-li {{   request()->routeIs('cms.register') ||  request()->routeIs('cms.users.*')  ? 'aktif' : '' }}">
            <a href="#">Kullanıcılar <i class="las la-angle-right"></i></a>
            <ul class="alt-menu">
                <li class="{{ request()->routeIs('cms.users.index') || request()->routeIs('cms.register') ? 'aktif' : '' }}">
                    <a href="{{route('cms.users.index')}}">Tümü</a>
                </li>
                <li class="{{ request()->routeIs('cms.register') ? 'aktif' : '' }}">
                    <a href="{{route('cms.register')}}">Kullanıcı Ekle</a>
                </li>
            </ul>
        </li>
        @endpermission

        @permission('roller')
        {{--        Roles--}}
        <li class="ust-menu-li {{ request()->routeIs('cms.roles.*') ? 'aktif' : '' }}">
            <a href="#">Roller <i class="las la-angle-right"></i></a>
            <ul class="alt-menu">
                <li class="{{ request()->routeIs('cms.roles.index') ? 'aktif' : '' }}">
                    <a href="{{route('cms.roles.index')}}">Rol Listesi</a>
                </li>
                <li class="{{ request()->routeIs('cms.roles.create') ? 'aktif' : '' }}">
                    <a href="{{route('cms.roles.create')}}">Rol Ekle</a>
                </li>
            </ul>
        </li>
        @endpermission

        @permission('yetkiler')
        {{--        User Roles Setting--}}
        <li class="ust-menu-li {{ request()->routeIs('cms.role-user.*') ? 'aktif' : '' }}">
            <a href="#">Yetkiler <i class="las la-angle-right"></i></a>
            <ul class="alt-menu">
                <li class="{{ request()->routeIs('cms.role-user.index') ? 'aktif' : '' }}">
                    <a href="{{route('cms.role-user.index')}}">Yetki Listesi</a>
                </li>
                <li class="{{ request()->routeIs('cms.role-user.create') ? 'aktif' : '' }}">
                    <a href="{{route('cms.role-user.create')}}">Yetki Ata</a>
                </li>
            </ul>
        </li>
        @endpermission

        @permission('izinler')
        {{--        Permission Setting--}}
        <li class="ust-menu-li {{ request()->routeIs('cms.permission.*') ? 'aktif' : '' }}">
            <a href="#">İzinler <i class="las la-angle-right"></i></a>
            <ul class="alt-menu">
                <li class="{{ request()->routeIs('cms.permission.index') ? 'aktif' : '' }}">
                    <a href="{{route('cms.permission.index')}}">İzin Listesi</a>
                </li>
                <li class="{{ request()->routeIs('cms.permission.create') ? 'aktif' : '' }}">
                    <a href="{{route('cms.permission.create')}}">İzin Ekle</a>
                </li>
            </ul>
        </li>
        @endpermission

        @permission('yetki-izinleri')
        {{--        Role Permission Setting--}}
        <li class="ust-menu-li {{ request()->routeIs('cms.role-permission.*') ? 'aktif' : '' }}">
            <a href="#">Yetki İzinleri <i class="las la-angle-right"></i></a>
            <ul class="alt-menu">
                <li class="{{ request()->routeIs('cms.role-permission.index') ? 'aktif' : '' }}">
                    <a href="{{route('cms.role-permission.index')}}">Yetki İzin Listesi</a>
                </li>
            </ul>
        </li>
        @endpermission
        @permission('ayarlar')
        {{--        Ayarlar--}}
        <li class="ust-menu-li {{ request()->routeIs('cms.settings.*') ? 'aktif' : '' }}">
            <a href="#">Ayarlar <i class="las la-angle-right"></i></a>
            <ul class="alt-menu">
                <li class="{{ request()->routeIs('cms.settings.site.index') ? 'aktif' : '' }}">
                    <a href="{{route('cms.settings.site.index')}}">Site Ayarları</a>
                </li>
                <li class="{{ request()->routeIs('cms.settings.api-key.index') ? 'aktif' : '' }}">
                    <a href="{{route('cms.settings.api-key.index')}}">API Key Ayarları</a>
                </li>
                <li class="{{ request()->routeIs('cms.settings.panel-menu.index') ? 'aktif' : '' }}">
                    <a href="{{route('cms.settings.panel-menu.index')}}">Panel Menu Ayarları</a>
                </li>
            </ul>
        </li>
        @endpermission



    </ul>
</nav>
