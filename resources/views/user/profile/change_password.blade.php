@include('layout.header')
@if (Session::has('error'))
    <script>
        Swal.fire({
            title: 'Error!',
            text: '<?= Session::get('error') ?>',
            icon: 'error',

        })
    </script>
@endif
<div class="row">
    <div class="col card">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Change Password</h6>
        </div>
        <div class="card-body">
            <form action="{{url('/change-password')}}" method="post">
            @csrf
            @method('patch')
                <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">Old Password</span>
                </div>
                <input  name="old_password" type="text" class="form-control" id="basic-url"
                    aria-describedby="basic-addon3">
            </div>
            @error('old_password')
                <div class="error">{{$message}}</div>
            @enderror
             <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">New Password</span>
                </div>
                <input  name="new_password" type="text" class="form-control" id="basic-url"
                    aria-describedby="basic-addon3">
            </div>
            @error('new_password')
                <div class="error">{{$message}}</div>
            @enderror
            <button type="submit" class="btn btn-primary">submit</button>
        </form>
        </div>
    </div>
</div>
@include('layout.footer')