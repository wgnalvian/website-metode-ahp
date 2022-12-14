@include('layout.header')




<!-- Earnings (Monthly) Card Example -->

<!-- Content Row -->
<div class="row ">
    <div class="col card ">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add Category</h6>
        </div>
        <div class="card-body">

            <form action="{{ url('/admin/category') }}" method="post">
                @csrf
              
           
                <label for="basic-url">Category Name</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">Category Name</span>
                    </div>
                    <input value="{{old('category_name')}}" name="category_name" type="text" class="form-control" id="basic-url"
                        aria-describedby="basic-addon3">
                </div>
                @error('category_name')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror
                <button type="submit" class="btn btn-primary">Add Category</button>
                <a class="btn btn-secondary" href="{{url('/admin/category')}}">cancel</a>
            </form>
        </div>
    </div>

</div>


@include('layout.footer')
