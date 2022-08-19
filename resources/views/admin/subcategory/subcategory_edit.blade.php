@include('layout.header')






<!-- Earnings (Monthly) Card Example -->

<!-- Content Row -->
<div class="row ">
    <div class="col card sizing py-2">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Subcategory</h6>
        </div>
        <div class="card-body">
            <form action="{{ url('/admin/subcategory') }}" method="post">
                @method('patch')
                @csrf
    
                <input type="hidden" value="{{ $subcategory->id }}" name="subcategory_id" />
                <input type="hidden" name="subcategory_name_old" value="{{ $subcategory->subcategory_name }}" />
                <div class="form-group">
                    <select name="category_id" class="custom-select" aria-label="Default select example">
                        <option value="{{ $subcategory->category_id }}">{{ $subcategory->category->category_name }}</option>
                        @foreach ($categories as $category)
                            @if ($subcategory->category->category_name != $category->category_name)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endif
                        @endforeach
                    </select>
    
                </div>
                 @error('category_id')
                    <div class="error w-full">
                        {{ $message }}
                    </div>
                @enderror
                <label for="basic-url">Subcategory Name</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">Subcategory Name</span>
                    </div>
                    <input name="subcategory_name" type="text" class="form-control" id="basic-url"
                        aria-describedby="basic-addon3" value="{{ $subcategory->subcategory_name }}">
                </div>
                @error('subcategory_name')
                    <div class="error w-full">
                        {{ $message }}
                    </div>
                @enderror
                <button type="submit" class="btn btn-primary">Edit Subcategory</button>
                <a class="btn btn-secondary" href="{{ url('/admin/subcategory') }}">cancel</a>
            </form>
        </div>
      
    </div>

</div>


@include('layout.footer')
