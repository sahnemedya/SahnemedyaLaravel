@extends("cms.partial.layout")
@section("content")
    <div class="row">
        <div class="card col-sm-12 col-md-12 col-lg-6">
            <div class="card-header">Referans Ekle</div>
            <div class="card-body">
                <form action="{{route("cms.references.store")}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <label for="name">Referans Adı</label>
                    <input type="text" name="name" id="name" placeholder="Referans Adı" required>

                    <label for="type">Referans Türü</label>
                    <input type="text" name="type" id="type" placeholder="Referans Türü" required>

                    <label for="image">Referans Resmi</label>
                    <input type="file" name="image" id="image" placeholder="Referans Resmi">

                    <label for="hit">Gösterim Sırası</label>
                    <input type="number" name="hit" id="hit" placeholder="Gösterim Sırası">

                    <label for="url">Yönlendirilecek URL</label>
                    <input type="text" name="url" id="url" placeholder="Yönlendirilecek URL">
@if($languages->count()>1)
                    <label for="langId">Dil</label>
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
