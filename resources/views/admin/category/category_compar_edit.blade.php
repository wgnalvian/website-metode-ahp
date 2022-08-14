@include('layout.header')


<div class="row ">
    <div class="col card sizing py-2">
        <div class="card-body">
            <form  action="{{ url('/admin/category/compar') }}" method="POST">
                @csrf
                @method('patch');
                @foreach ($arrCompareEdit as $i => $category)
                 
                
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"
                                        id="basic-addon2">{{ $category->categoryA->category_name }}</span>
                                </div>
                                <select name="category_compar_{{ $i }}" class="custom-select"
                                    aria-label="Default select example">

                                    <option value="{{ $category->categoryA->id }},{{$category->value}},{{ $category->categoryB->id }}">{{$category->value}}</option>
                                    <option value="{{ $category->categoryA->id }},1,{{ $category->categoryB->id }}">1, Sama Penting
                                    </option>
                                    <option value="{{ $category->categoryA->id }},2,{{ $category->categoryB->id }}">2, Mendekati
                                        Mutlak Dari
                                    </option>
                                    <option value="{{ $category->categoryA->id }},3,{{ $category->categoryB->id }}">3, Sedikit
                                        lebih penting
                                        dari </option>
                                    <option value="{{ $category->categoryA->id }},4,{{ $category->categoryB->id }}">4, Mendekati
                                        lebih
                                        penting dari</option>
                                    <option value="{{ $category->categoryA->id }},5,{{ $category->categoryB->id }}">5, Lebih
                                        Penting dari
                                    </option>
                                    <option value="{{ $category->categoryA->id }},6,{{ $category->categoryB->id }}">6, Mendekati
                                        sangat
                                        penting dari </option>
                                    <option value="{{ $category->categoryA->id }},7,{{ $category->categoryB->id }}">7, Sangat
                                        penting dari
                                    </option>
                                    <option value="{{ $category->categoryA->id }},8,{{ $category->categoryB->id }}">8, Mendekati
                                        mutlak
                                        dari </option>
                                    <option value="{{ $category->categoryA->id }},9,{{ $category->categoryB->id }}">9, Mutlak
                                        sangat
                                        penting dari </option>
                                </select>

                                <div class="input-group-append">
                                    <span class="input-group-text"
                                        id="basic-addon2">{{ $category->categoryA->category_name }}</span>
                                </div>
                            </div>
                            @if ($errors->has("category_compar_$i"))
                                <div class="error"> {{ $errors->first("category_compar_$i") }}</div>
                            @endif
                @endforeach
                <button type="submit" class="btn btn-primary">Compar Category</button>
            </form>
        </div>
    </div>
</div>
<script>
    document.querySelector('.COMPARE').addEventListener('submit',(e) => {
        e.preventDefault();

        Swal.fire({
            title : 'Are you sure for compare ?',
            text : 'There is have value compare from old compare, this action will remove olde compare value',
            icon : 'warning',
            showCancelButton : true,
            confirmButtonText : 'oke',
            cancelButtonText : 'cancel',
            allowOutsideClick : false
        }).then((result) => {
            if(result.isConfirmed) {
                document.querySelector('.COMPARE').submit();
            }else{
                return false
            }
        })
    })
</script>
@include('layout.footer')

