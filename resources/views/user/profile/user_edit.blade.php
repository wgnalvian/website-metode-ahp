@include('layout.header')
<form class="formEdit" action="{{ url('/profile') }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('patch')
    <div class="row">
        <div class="col-11 card">
            <div class="card-body">
                <button type="submit" class="btn btn-primary submitBtn">submit</button>
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

                    <input value="{{ $user->name }}" name="username" type="text" class="form-control"
                        id="basic-url" aria-describedby="basic-addon3">
                </div>
                @error('username')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-1"></div>
        <div class="col-4 card">
            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">Foto Profile</h6>
            </div>
            <div class="card-body">
                <div style="width : 100%;position: relative;">
                    <img class="image-view" style="width : 100%" src="{{ url("/image/$user->image") }}" alt=""
                        srcset="">
                    <input class="inputImg" style="opacity : 0;position:absolute;left :0;width :100%;height : 100%"
                        type="file" name="userimage" id="">
                    @error('userimage')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    <div class="error error-img"></div>
                </div>
            </div>
        </div>
    </div>

</form>
<script>
    let error = '';
    let getError = (e) => {

        let allowType = ["image/png", "image/svg", "image/jpg", "image/jpeg"]
        if (!allowType.includes(e.target.files[0].type)) {
            error = 'File must be image type'
            document.querySelector('.error-img').innerHTML = error
            document.querySelector('.image-view').src = "{{ url('/image/cancel.svg') }}"

            return false
        }

        error = '';
        document.querySelector('.error-img').innerHTML = error

        return true
    }

    document.querySelector('.inputImg').addEventListener('change', function(e) {
        if (getError(e)) {
            document.querySelector('.image-view').src = URL.createObjectURL(e.target.files[0])

        }



    })

    document.querySelector('.submitBtn').addEventListener('click', function(e) {
        e.preventDefault()
        if (error == '') {
            document.querySelector('.formEdit').submit();
        }

    })
</script>


@include('layout.footer')
