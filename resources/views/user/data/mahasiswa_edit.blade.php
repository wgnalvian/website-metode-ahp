@include('layout.header')




<!-- Earnings (Monthly) Card Example -->

<!-- Content Row -->
<div class="row ">
    <div class="col card ">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Mahasiswa</h6>
        </div>
        <div class="card-body">

            <form action="{{ url('/mahasiswa') }}" method="post">
                @csrf
                @method('patch')
                <input type="hidden" name="mahasiswa_id" value="{{$mahasiswa->id}}" />
                <input type="hidden" name="mahasiswa_nim_old" value="{{$mahasiswa->nim}}">
                <label for="basic-url">Name</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">Name</span>
                    </div>
                    <input value="{{ $mahasiswa->name }}" name="mahasiswa_name" type="text" class="form-control"
                        id="basic-url" aria-describedby="basic-addon3">
                </div>
                @error('mahasiswa_name')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror
                <label for="basic-url">NIM</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">NIM</span>
                    </div>
                    <input value="{{ $mahasiswa->nim }}" name="mahasiswa_nim" type="text" class="form-control"
                        id="basic-url" aria-describedby="basic-addon3">
                </div>
                @error('mahasiswa_nim')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror
                <button type="submit" class="btn btn-primary">Edit Mahasiswa</button>
                <a class="btn btn-secondary" href="{{ url('/mahasiswa') }}">cancel</a>
            </form>
        </div>
    </div>

</div>


@include('layout.footer')
