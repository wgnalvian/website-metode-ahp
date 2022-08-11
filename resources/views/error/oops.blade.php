@include('layout.header')
<div class="container-fluid w-full">

    <!-- 404 Error Text -->
   <div class="row"  style="width : 100%">
        <div class="card" style="width : 100%">
            <div class="card-body " style="border: 2px solid red">
                <div class="row">
                    <div class="col">
                        <h1 style="color: red">Oops</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p>{{$msg}}</p>
                    </div>
                </div>
            </div>
        </div>
   </div>
</div>
@include('layout.footer')