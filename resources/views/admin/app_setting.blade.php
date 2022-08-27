@include('layout.header')
<div class="row">
    <div class="col card">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">App Setting</h6>
        </div>
        <div class="card-body">
            <p>Reset App</p>
            <form action="{{url('/admin/reset-app')}}" method="post">
            @csrf
            <button type="submit" class="btn btn-primary" >Reset App</button>
            </form>
        </div>
    </div>
</div>
@include('layout.footer')
