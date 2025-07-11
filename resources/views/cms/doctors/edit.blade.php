@extends("cms.partial.layout")
@section("content")
    <div class="row">
        <div class="card col-sm-12 col-md-12 col-lg-6">
            <div class="card-header">Doktor Güncelle</div>
            <div class="card-body">
                <form action="{{route("cms.doctors.update",$doctor->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <label for="doctorTitle">Ünvan:</label>
                    <select name="doctor_title" id="doctorTitle">
                        <option value="Dr." @if($doctor->doctor_title == "Dr.") selected @endif >Dr. (Doktor)
                        </option>
                        <option value="Uzm. Dr." @if($doctor->doctor_title == "Uzm. Dr.") selected @endif >Uzm. Dr.
                            (Uzman Doktor)
                        </option>
                        <option value="Doç. Dr." @if($doctor->doctor_title == "Doç. Dr.") selected @endif >Doç. Dr.
                            (Doçent Doktor)
                        </option>
                        <option value="Prof. Dr." @if($doctor->doctor_title == "Prof. Dr.") selected @endif >Prof.
                            Dr. (Profesör Doktor)
                        </option>
                        <option value="Dyt." @if($doctor->doctor_title == "Dyt.") selected @endif >Dyt.
                            (Diyetisyen)
                        </option>
                        <option value="Psk." @if($doctor->doctor_title == "Psk.") selected @endif >Psk.
                            (Psikolog)
                        </option>
                        <option value="Uzm. Psk." @if($doctor->doctor_title == "Uzm. Psk.") selected @endif >Uzm.
                            Psk. (Uzman Psikolog)
                        </option>
                    </select>
                    <label for="name">Doktor Adı:</label>
                    <input type="text" name="name" id="name" placeholder="Adı" value="{{$doctor->name}}">
                    <label for="surname">Doktor Soyadı:</label>
                    <input type="text" name="surname" id="surname" placeholder="Soyadı"
                           value="{{$doctor->surname}}">
                    <label for="medicalUnit">Birimi:</label>
                    <select name="medical_unit" id="medicalUnit">
                        @foreach($medicalUnit->subPages as $item)
                            <option value="{{$item->id}}"
                                    @if($doctor->medical_unit == $item->id) selected @endif >{{$item->title}}</option>
                        @endforeach
                    </select>
                    <label for="image">Doktor Resmi:</label>
                    <input type="file" name="image" id="image">
                    <label for="image2">Doktor Resmi 2:</label>
                    <input type="file" name="image2" id="image2">
                    <label for="title">SEO Title:</label>
                    <input type="text" name="title" id="title" placeholder="Seo Title" value="{{$doctor->title}}">
                    <label for="description">SEO Description</label>
                    <input type="text" name="description" id="description" placeholder="Seo Description"
                           value="{{$doctor->description}}">
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
