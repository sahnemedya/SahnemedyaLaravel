@extends("cms.partial.layout")
@section("content")

    <div class="card">
        <div class="card-header">
            CARD HEADER
        </div>
        <div class="card-body">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto deserunt ipsam nihil quas quasi. Autem
            magni numquam quibusdam repudiandae veritatis. Asperiores fugit laudantium quia quis quod sed sequi soluta
            ut?
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            Sahne Medya Sistem Analizleri
        </div>
        <div class="card-body fd-row">

            <div class="card-4">
                <div class="sb-card sb-border-left-danger">
                    <div class="sb-card-header sb-card-header-small text-danger   font-weight-600">
                        Kullanıcı Girişleri
                    </div>
                    <div class="sb-card-body">
                        <div class="text-whatsapp-color sb-card-text ">
                            <ul>
                                <li class="text-light btn color-danger" style="margin-bottom: 10px">Son 3 Gün: {{ $kullaniciSayilari['son_3_gun'] }}</li>
                                <li class="text-light btn color-danger" style="margin-bottom: 10px">Son 7 Gün: {{ $kullaniciSayilari['son_7_gun'] }}</li>
                                <li class="text-light btn color-danger" style="margin-bottom: 10px">Son 1 Ay: {{ $kullaniciSayilari['son_1_ay'] }}</li>
                                <li class="text-light btn color-danger" style="margin-bottom: 10px">Son 3 Ay: {{ $kullaniciSayilari['son_3_ay'] }}</li>
                                <li class="text-light btn color-danger" style="margin-bottom: 10px">Son 6 Ay: {{ $kullaniciSayilari['son_6_ay'] }}</li>
                                <li class="text-light btn color-danger" style="margin-bottom: 10px">Son 9 Ay: {{ $kullaniciSayilari['son_9_ay'] }}</li>
                                <li class="text-light btn color-danger" style="margin-bottom: 10px">Son 12 Ay: {{ $kullaniciSayilari['son_12_ay'] }}</li>
                                <li class="text-light btn color-danger" style="margin-bottom: 10px">Toplam: {{ $kullaniciSayilari['tum_kullanici'] }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-4"></div>
            <div class="card-4"></div>
            <div class="card-4"></div>
        </div>
    </div>





    <div class="card">
        <div class="card-body">
            <form action="/img" method="post" enctype="multipart/form-data">
                @csrf
                <input type="password" name="" id="">
                <input type="text" name="" id="">
                <div class="input-ch-rd">
                    <input type="checkbox" name="" id="ch">
                    <label for="ch">Bilgilendirme</label>
                </div>
                <input type="submit" value="Gönder">
                <input type="text" name="" id="" class="datepicker" placeholder="Tarih Seçin">
                <input type="text" name="" id="" class="datetimelocalpicker" placeholder="Tarih ve Yerel Saat Seçin">
                <input type="text" name="" id="" class="datetimepicker" placeholder="Tarih Saat Seçin">
                <div class="input-ch-rd">
                    <input type="radio" name="" id="">
                    <label for="ch">Onay</label>
                </div>
                <input type="file" name="image" id="">
                <input type="search" name="" id="">
            </form>

        </div>
    </div>

    <div class="card">
        <div class="card-header">Renkler</div>
        <div class="card-body">
            <div class="boxes">
                <div class="box flex-center bg-error">error</div>
                <div class="box flex-center bg-success">success</div>
                <div class="box flex-center bg-primary">primary</div>
                <div class="box flex-center bg-secondary">secondary</div>
                <div class="box flex-center bg-dark">dark</div>
                <div class="box flex-center bg-light">light</div>
            </div>
        </div>
    </div>
    {{--    <form method="POST" action="{{ route('cms.logout') }}"> @csrf <button type="submit">Çıkış Yap</button> </form>--}}
    <div class="card">
        <div class="card-header">Data Table</div>
        <div class="card-body">
            <table id="datatable" class="display stripe" style="width:100%">
                <thead>
                <tr>
                    <th>İsim</th>
                    <th>Pozisyon</th>
                    <th>Ofis</th>
                    <th>Aktif</th>
                    <th>Maaş</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Tiger Nixon</td>
                    <td>Sistem Yöneticisi</td>
                    <td>Edinburgh</td>
                    <td>
                        <label class="switch">
                            <input type="checkbox" name="active" value="1">
                            <span class="switch-slider"></span>
                        </label>
                    </td>
                    <td>$320,800</td>
                </tr>
                <tr>
                    <td>aiger Nixon</td>
                    <td>zistem Yöneticisi</td>
                    <td>fdinburgh</td>
                    <td>
                        <label class="switch">
                            <input type="checkbox" name="active" value="1" checked >
                            <span class="switch-slider"></span>
                        </label>
                    </td>
                    <td>$920,800</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection
@section("extraJs")
    <script>
        flatpickr(".datepicker", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });
    </script>
@endsection
