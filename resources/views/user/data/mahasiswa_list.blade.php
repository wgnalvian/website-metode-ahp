@include('layout.header')

<div class="row">
    <div class="col card">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List Mahasiswa</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>nim </th>
                              <th></th>
                            <th>Action</th>

                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($mahasiswas as $mahasiswa)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $mahasiswa->name }}</td>
                                <td>{{ $mahasiswa->nim }}</td>
                               <td>  <a  href="{{url("/mahasiswa/choose/$mahasiswa->id")}}"class="btn btn-primary">Select Data</a> </td>
                                <th>
                                    <form class="d-inline" action="{{ url('/mahasiswa/edit') }}" method="get">
                                       
                                        @csrf
                                        <input type="hidden" name="mahasiswa_id" value="{{$mahasiswa->id}}" />
                                        <button type="submit" class="btn btn-warning ">edit</button>
                                    </form>
                                    <form class="d-inline" action="{{ url('/mahasiswa') }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <input type="hidden" name="mahasiswa_id" value="{{$mahasiswa->id}}" />
                                        <button type="submit" class="btn btn-danger ">delete</button>
                                    </form>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script>
    document.querySelector('.DELETEC').addEventListener('submit',(e) => {
        e.preventDefault();

        Swal.fire({
            title : 'Are you sure for delete ?',
            text : 'It will also remove sub category constrained and will reset value comparation category & subcategory',
            icon : 'warning',
            showCancelButton : true,
            confirmButtonText : 'oke',
            cancelButtonText : 'cancel',
            allowOutsideClick : false
        }).then((result) => {
            if(result.isConfirmed) {
                document.querySelector('.DELETEC').submit();
            }else{
                return false
            }
        })
    })
</script>




@include('layout.footer')
