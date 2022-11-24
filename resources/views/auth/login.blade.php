@include('auth.layout.header')
{{-- Alert error --}}
@if (Session::has('error'))
    <script>
        Swal.fire({
            title: 'Error!',
            text: '<?= Session::get('error') ?>',
            icon: 'error',

        })
    </script>
@endif
<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-4 col-lg-4 col-md-4">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">

                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4 ">Sign In</h1>
                                </div>
                                <form class="user" method="POST" action={{ url('/login') }}>
                                    @csrf
                                    <div class="form-group">
                                        <input autocomplete="false" name="username" type="text" class="form-control form-control-user"
                                            value="{{ old('username') }}" placeholder="Enter Username..">
                                    </div>
                                    @error('username')
                                        <div class="error">{{ $message }}</div>
                                    @enderror


                                    <div class="form-group">
                                        <input name="password" type="password" class="form-control form-control-user"
                                            id="exampleInputPassword" {{ old('password') }}
                                            placeholder="Enter Password..">
                                    </div>
                                    @error('password')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                    <div class="form-group">
                                        <select name="role_id" class="custom-select"
                                            aria-label="Default select example">
                                            <option value=""  >Sign as ...</option>
                                            @foreach ($roleUser as $role)
                                                <option value="{{ $role->id }}">{{ $role->role }}</option>
                                            @endforeach
                                        </select>
                                        @error('role_id')
                                            <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Sign In
                                    </button>

                                </form>
                                <hr>

                                <div class="text-center">
                                    <a class="small" href={{ url('/register') }}>Create an Account!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@include('auth.layout.footer')
