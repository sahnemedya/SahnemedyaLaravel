@extends("cms.partial.layout")

@section("extraCss")
    <link rel="stylesheet" href="{{asset("plugins/ckeditor/skins/moono/editor.css")}}">
    <script src="{{asset("plugins/ckeditor/lang/tr.js")}}"></script>
    <script src="{{asset("plugins/ckeditor/styles.js")}}"></script>
    <script src="{{asset("plugins/ckeditor/ckeditor.js")}}"></script>
@endsection
@section("content")
    <div class="row">
        <div class="card col-sm-12 col-md-12 col-lg-12">
            <div class="card-header">Sayfa Güncelle</div>
            <div class="card-body">
                <form action="{{route("cms.side-menu-elements.update",$page->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @if($page->image)
                        <figure class="form-figure">
                            <img src="{{$page->getImagePath()}}" id="formFigure" alt="">
                            <label onclick="removeImage()" class="btn delete-image-btn bg-error" id="removeButton">Resmi
                                Sil</label>
                        </figure>
                    @endif
                    <input type="checkbox" style="display: none" name="removeImage" id="removeCheckbox" id=""
                           value="1">

                    <label for="title">Sayfa Başlığı:</label>
                    <input type="text" name="title" id="title" placeholder="Başlık" value="{{$page->title}}">

                    <label for="slug">Sayfa Url</label>
                    <input type="text" name="slug" id="slug" placeholder="Url" value="{{$page->slug}}">

                    <label for="contentText">İçerik</label>
                    <textarea name="content_text" id="contentText" cols="30"
                              rows="10">{{$page->content}}</textarea>
                    <br>

                    <label for="image">Sayfa Resmini Değiştir</label>
                    <input type="file" name="image" id="image" placeholder="Dosya Seçin">

                    <label for="hit">Sayfa Sıralaması</label>
                    <input type="number" name="hit" id="hit" placeholder="Gösterim Sırası"
                           value="{{$page->hit}}">
                    <label for="categoryId">Bağlı Kategori</label>
                    <select name="category_id" id="categoryId" title="Hangi kategorinin sayfası ise o seçilmeli.">
                        @foreach($categories as $item)
                            <option value="{{$item->id}}"
                                    @if($page->category_id == $item->id) selected @endif>{{$item->name}}</option>
                        @endforeach
                    </select>

                    <label for="bladeId">Sayfa Şablonu</label>
                    <select name="blade_id" id="bladeId" title="Sayfanın görüntüleneceği tasarım şablonunu seçin.">
                        @foreach($blades as $item)
                            <option value="{{$item->id}}"
                                    @if($page->blade_id == $item->id) selected @endif>{{$item->name}}</option>
                        @endforeach
                    </select>

                    <label for="parentPage">Üst Sayfası</label>
                    <select name="parent_page" id="parentPage">
                        <option value="" @if($page->parent_page==NULL) selected @endif>Üst Sayfa Yok</option>
                        @foreach($pages as $item)
                            <option value="{{$item->id}}"
                                    @if($page->parent_page == $item->id) selected @endif>{{$item->title}}</option>
                        @endforeach
                    </select>


                    @if($languages->count()>1)
                        <label for="translationOf">Hangi Sayfanın Çevirisi</label>
                        <select name="translation_of" id="translationOf">
                            <option value="">Çeviri Sayfası Değil</option>
                            @foreach($pages as $item)
                                <option value="{{$item->id}}"
                                        @if($page->translation_of == $item->id) selected @endif>{{$item->title}}</option>
                            @endforeach
                        </select>
                    @endif
                    @if($languages->count()>1)
                        <label for="langId">Sayfa Dili</label>
                        <select name="lang_id" id="langId">
                            @foreach($languages as $item)
                                <option value="{{$item->id}}"
                                        @if($page->lang_id == $item->id) selected @endif>{{$item->name}}</option>
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

        function removeImage() {
            let categoryImage = document.getElementById('formFigure');
            const removeButton = document.getElementById("removeButton");
            const removeCheckbox = document.getElementById("removeCheckbox")
            if (categoryImage.style.display === "none") {
                categoryImage.style.display = "block";
                removeButton.classList.remove("bg-success");
                removeButton.classList.add("bg-error");
                removeButton.innerHTML = "Resmi Sil";
                removeCheckbox.removeAttribute("checked");
            } else {
                categoryImage.style.display = "none";
                removeButton.classList.add("bg-success");
                removeButton.classList.remove("bg-error");
                removeButton.innerHTML = "Resmi Geri Yükle";
                removeCheckbox.setAttribute("checked", "checked");
            }
        }


    </script>
@endsection
