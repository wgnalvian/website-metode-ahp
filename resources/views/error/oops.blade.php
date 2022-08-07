@include('layout.header')
<div class="container-fluid">

    <!-- 404 Error Text -->
    <div class="text-center">
        <div class="error mx-auto" data-text="404">Oops.....</div>
        <p class="lead text-gray-800 mb-5">{{$msg}}</p>
   
        <a href="index.html">{{url()->previous()}}</a>
    </div>

</div>
@include('layout.footer')