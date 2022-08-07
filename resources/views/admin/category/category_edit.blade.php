@include('layout.header')






<!-- Earnings (Monthly) Card Example -->

<!-- Content Row -->
<div class="row ">
    <div class="col card sizing py-2">
        <form action="{{ url('/admin/category') }}" method="post">
            @method('patch')
            @csrf
           
          <input type="hidden" value="{{$category->id}}" name="category_id" />
             <input type="hidden" name="category_name_old" value="{{$category->category_name}}" />
           
            <label for="basic-url">Category Name</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">Category Name</span>
                </div>
                <input  name="category_name" type="text" class="form-control" id="basic-url"
                    aria-describedby="basic-addon3" value="{{$category->category_name}}">
            </div>
            @error('category_name')
                <div class="error w-full">
                    {{ $message }}
                </div>
            @enderror
            <button type="submit" class="btn btn-primary">Edit Category</button>
            <a class="btn btn-secondary" href="{{url('/admin/category')}}">cancel</a>
        </form>
    </div>

</div>


@include('layout.footer')
