@include('layout.header')






<!-- Earnings (Monthly) Card Example -->

<!-- Content Row -->
<div class="row ">
    <div class="col card ">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add Subcategory</h6>
        </div>
        <div class="card-body">

            <form action="{{ url('/admin/subcategory') }}" method="post">
                @csrf
                <label for="basic-url">Category</label>
                <div class="form-group">
                    <select  name="category_id" class="custom-select"
                        aria-label="Default select example">
                        <option value="" >Choose Category ...</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                 
                </div>
                   @error('category_id')
                        <div class="error">{{ $message }}</div>
                    @enderror
                <label for="basic-url">SubCategory Name</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">Category Name</span>
                    </div>
                    <input value="{{old('subcategory_name')}}" name="subcategory_name" type="text" class="form-control" id="basic-url"
                        aria-describedby="basic-addon3">
                </div>
                @error('subcategory_name')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror
                <button type="submit" class="btn btn-primary">Add Category</button>
                <a class="btn btn-secondary" href="{{url('/admin/subcategory')}}">cancel</a>
            </form>
        </div>
    </div>

</div>


@include('layout.footer')
