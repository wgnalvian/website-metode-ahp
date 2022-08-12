@include('layout.header')

{{-- 
@if ($isExistCompareCategory)
    <script>
          Swal.fire({
            title : 'You have compare value before !',
            text : 'Add Category will reset all data compare value from category & subcategory, are you sure add category ?',
            icon : 'warning',
            showCancelButton : true,
            confirmButtonText : 'oke',
            cancelButtonText : 'cancel',
            allowOutsideClick : false
        }).then((result) => {
            if(result.isConfirmed) {
                document.querySelector('.DELETEC').submit();
            }else{
                return false
            }
        })
    </script>
@endif --}}



<!-- Earnings (Monthly) Card Example -->

<!-- Content Row -->
<div class="row ">
    <div class="col card sizing py-2">
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


@include('layout.footer')
