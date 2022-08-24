@include('layout.header')
<div class="row">
    <div class="col-11 card">
        <div class="card-body">
            <a href="{{url('/profile/edit')}}" class="btn btn-primary">edit</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6 card">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Username</h6>
        </div>
        <div class="card-body">
            <div class="input-group mb-3">
                
                <input value="{{$user->name}}" disabled name="mahasiswa_name" type="text" class="form-control" id="basic-url"
                    aria-describedby="basic-addon3">
            </div>
        </div>
    </div>
    <div class="col-1"></div>
    <div class="col-4 card">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Foto Profile</h6>
        </div>
        <div class="card-body">
            <img style="width : 100%" src="{{url("/image/$user->image")}}" alt="" srcset="">
        </div>
    </div>
</div>
@include('layout.footer')