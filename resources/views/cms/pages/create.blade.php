@extends("cms.partial.layout")
@section("extraCss")
    <link rel="stylesheet" href="{{asset("plugins/ckeditor/skins/moono/editor.css")}}">
    <script src="{{asset("plugins/ckeditor/lang/tr.js")}}"></script>
    <script src="{{asset("plugins/ckeditor/styles.js")}}"></script>
    <script src="{{asset("plugins/ckeditor/ckeditor.js")}}"></script>
@endsection
@section("content")
    <div class="row">
        <div class="card col-sm-12 col-md-12 col-lg-6">
            <div class="card-header">Sayfa Ekle</div>
            <div class="card-body">
                <form action="{{route("cms.pages.store")}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <label for="title">Sayfa Başlığı:</label>
                    <input type="text" name="title" id="title" placeholder="Başlık">

                    <label for="slug">Sayfa Url</label>
                    <input type="text" name="slug" id="slug" placeholder="Url">

                    <label for="contentText">İçerik</label>
                    <textarea name="content_text" id="contentText" cols="30" rows="10"></textarea>

                    <label for="image">Sayfa Resmi</label>
                    <input type="file" name="image" id="image" placeholder="Dosya Seçin">

                    <label for="hit">Sayfa Sıralaması</label>
                    <input type="number" name="hit" id="hit" placeholder="Gösterim Sırası">

                    <label for="categoryId">Bağlı Kategori</label>
                    <select name="category_id" id="categoryId" title="Hangi kategorinin sayfası ise o seçilmeli.">
                        @foreach($categories as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>

                    <label for="bladeId">Sayfa Şablonu</label>
                    <select name="blade_id" id="bladeId" title="Sayfanın görüntüleneceği tasarım şablonunu seçin.">
                        @foreach($blades as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>

                    <label for="parent_page">Üst Sayfası</label>
                    <select name="parent_page" id="parentPage">
                        <option value="">Üst Sayfa Yok</option>
                        @foreach($pages as $item)
                            <option value="{{$item->id}}">{{$item->title}}</option>
                        @endforeach
                    </select>
                    @if($languages->count()>1)
                    <label for="translationOf">Hangi Sayfanın Çevirisi</label>
                    <select name="translation_of" id="translationOf">
                        <option value="">Çeviri Sayfası Değil</option>
                        @foreach($pages as $item)
                            <option value="{{$item->id}}">{{$item->title}}</option>
                        @endforeach
                    </select>
                    @endif

                    @if($languages->count()>1)
                    <label for="langId">Sayfa Dili</label>
                    <select name="lang_id" id="langId">
                        @foreach($languages as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                    @endif
                    <input type="submit" value="Kaydet">
                </form>

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
@section("extraJs")
    <script src="{{asset("plugins/ckeditor/config.js")}}"></script>
    <script>
        let ckeditor = document.getElementById("contentText");
        if (ckeditor && typeof CKEDITOR !== "undefined") {
            CKEDITOR.replace('contentText', {
                filebrowserWindowWidth: '1000',
                filebrowserWindowHeight: '700'
            });
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const titleInput = document.getElementById('title');
            const slugInput = document.getElementById('slug');

            if (titleInput && slugInput) {
                titleInput.addEventListener('input', function () {
                    const title = this.value;

                    if (title.length > 0) {
                        axios.post('{{ route("cms.slug.maker") }}', {text: title}, {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        }).then(function (response) {
                            slugInput.value = response.data.slug;
                        }).catch(function (error) {
                            console.error("Slug oluşturulamadı", error);
                        });
                    } else {
                        slugInput.value = '';
                    }
                });
            } else {
                console.warn("#title veya #slug inputu bulunamadı.");
            }
        });
    </script>
@endsection
