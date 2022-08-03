@include('auth.layout.header')
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
                                    <h1 class="h4 text-gray-900 mb-4">Sign Up</h1>
                                </div>
                                <form class="user" method="POST" action="/register">
                                    @csrf
                                    <div class="form-group">
                                        <input name="username" type="text" class="form-control form-control-user" value="{{old('username')}}"  placeholder="Enter Username..">
                                    </div>
                                    @error('username')
                                    <div class="error">{{$message}}</div>
                                    @enderror
                                        
                    
                                    <div class="form-group">
                                        <input name="password" type="password" class="form-control form-control-user" id="exampleInputPassword" {{old('password')}}  placeholder="Enter Password..">
                                    </div>
                                     @error('password')
                                    <div class="error">{{$message}}</div>
                                    @enderror
                                    <div class="form-group">
                                        <input name="password_confirmation" type="password" class="form-control form-control-user" id="exampleInputPassword" {{old('password_confirmation')}} placeholder="Enter Password Confirmation..">
                                    </div>

                                    <button type="submit"  class="btn btn-primary btn-user btn-block">
                                        Sign Up
                                    </button>

                                </form>
                                <hr>
                               
                                <div class="text-center">
                                    <a class="small" href="register.html">Create an Account!</a>
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