@extends("cms.partial.layout")
@section("content")
    <div class="row">
        <div class="card col-sm-12 col-md-12 col-lg-6">
            <div class="card-header">Doktor Ekle</div>
            <div class="card-body">
                <form action="{{route("cms.doctors.store")}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <label for="doctorTitle">Ünvan:</label>
                    <select name="doctor_title" id="doctorTitle">
                        <option value="Dr.">Dr. (Doktor)</option>
                        <option value="Uzm. Dr.">Uzm. Dr. (Uzman Doktor)</option>
                        <option value="Doç. Dr.">Doç. Dr. (Doçent Doktor)</option>
                        <option value="Prof. Dr.">Prof. Dr. (Profesör Doktor)</option>
                        <option value="Dyt.">Dyt. (Diyetisyen)</option>
                        <option value="Psk.">Psk. (Psikolog)</option>
                        <option value="Uzm. Psk.">Uzm. Psk. (Uzman Psikolog)</option>
                    </select>
                    <label for="name">Doktor Adı:</label>
                    <input type="text" name="name" id="name" placeholder="Adı">
                    <label for="surname">Doktor Soyadı:</label>
                    <input type="text" name="surname" id="surname" placeholder="Soyadı">
                    <label for="medicalUnit">Birimi:</label>
                    <select name="medical_unit" id="medicalUnit">
                        @foreach($medicalUnit->subPages as $item)
                            <option value="{{$item->id}}">{{$item->title}}</option>
                        @endforeach
                    </select>
                    <label for="image">Doktor Resmi:</label>
                    <input type="file" name="image" id="image">
                    <label for="image2">Doktor Resmi 2:</label>
                    <input type="file" name="image2" id="image2">
                    <label for="title">SEO Title:</label>
                    <input type="text" name="title" id="title" placeholder="Seo Title">
                    <label for="description">SEO Description</label>
                    <input type="text" name="description" id="description" placeholder="Seo Description">
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
