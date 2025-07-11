@extends("cms.partial.layout")
@section("content")
    <div class="card">
        <div class="card-header">Silinen Doktorlar</div>
        <div class="card-body">
            <table id="datatable" class="display stripe table-responsive-sm table-responsive-md" style="width:100%">

                <thead>
                <tr>
                    <th>Doktor</th>
                    <th>Birimi</th>
                    <th>Eklenme Tarihi</th>
                    <th>İşlem</th>
                </tr>
                </thead>

                <tbody>
                @foreach($doctors as $item)
                    <tr data-id="{{ $item->id }}">
                        <th>{{$item->doctor()}}</th>
                        <th>{{$item->medicalUnit->title}}</th>
                        <th>
                            {{$item->updated_at->diffForHumans()}}
                        </th>
                        <th class="islemler">

                            <a onclick="restoreCategory('{{route("cms.doctors.restore",$item->id)}}')" class="btn bg-warning">
                                <i class="las la-recycle"></i>
                            </a>
                            <a onclick="deleteFunc('{{route("cms.doctors.forceDelete",$item->id)}}')" class="btn bg-error">
                                <i class="las la-trash"></i>
                            </a>
                        </th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
@section("extraJs")
    <script>
         function restoreCategory(route) {
            axios.post(route, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(response => {
                    if (response.data.status === "success") {
                        notyf.success(response.data.message);
                        setTimeout(function () {
                            window.location.reload();
                        },1250)
                    } else if (response.data.status === "warning") {
                        notyf.open({
                            type: "warning",
                            message: response.data.message
                        });
                    } else {
                        notyf.error(response.data.message);
                    }
                })
                .catch(response => {
                    notyf.error(response.data.message);
                })
        }
        function deleteFunc(route) {
            axios.delete(route, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(response => {
                    if (response.data.status === "success") {
                        notyf.success(response.data.message);
                        setInterval(function (){
                            window.location.reload();
                        },1500)
                    } else if (response.data.status === "warning") {
                        notyf.open({
                            type: "warning",
                            message: response.data.message
                        });
                    } else {
                        notyf.error(response.data.message);
                    }
                })
                .catch(error => {
                    notyf.error(response.data.message);
                });
        }
    </script>
@endsection
