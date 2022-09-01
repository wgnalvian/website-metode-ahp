@include('layout.header')




<!-- Earnings (Monthly) Card Example -->

<!-- Content Row -->
<div class="row ">
    <div class="col card ">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add Mahasiswa</h6>
        </div>
        <div class="card-body">

            <form action="{{ url('/mahasiswa') }}" method="post">
                @csrf
            
           
                <label for="basic-url">Name</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">Name</span>
                    </div>
                    <input value="{{old('mahasiswa_name')}}" name="mahasiswa_name" type="text" class="form-control" id="basic-url"
                        aria-describedby="basic-addon3">
                </div>
                @error('mahasiswa_name')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror
                <label for="basic-url">Nim</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">Nim</span>
                    </div>
                    <input value="{{old('mahasiswa_nim')}}" name="mahasiswa_nim" type="text" class="form-control" id="basic-url"
                        aria-describedby="basic-addon3">
                </div>
                @error('mahasiswa_nim')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror
                <button type="submit" class="btn btn-primary">Add Mahasiswa</button>
                <a class="btn btn-secondary" href="{{url('/mahasiswa')}}">cancel</a>
            </form>
        </div>
    </div>

</div>


@include('layout.footer')
