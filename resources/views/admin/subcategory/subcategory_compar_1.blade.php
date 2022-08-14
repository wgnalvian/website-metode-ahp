@include('layout.header')
<div class="row">
    <div class="card">
        <div class="card-body">
            <form action="{{ url('/admin/subcategory/compar/2') }}" method="get">
                @csrf
                <label for="basic-url">Choose Category</label>
                <div class="form-group">
                    <select name="category_id" class="custom-select" aria-label="Default select example">
                        <option value="">Choose Category ...</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    <button class="btn btn-primary mt-2">Next</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('layout.footer')
