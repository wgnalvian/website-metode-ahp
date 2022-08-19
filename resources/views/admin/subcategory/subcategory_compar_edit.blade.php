@include('layout.header')


<div class="row ">
    <div class="col card sizing py-2">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Compare Subcategory</h6>
        </div>
        <div class="card-body">
            <form  action="{{ url('/admin/subcategory/compar') }}" method="POST">
                @method('patch')
                @csrf
                <label for="basic-url">Category </label>
                <div class="input-group mb-3">
              
                  
                    <select class="custom-select" name="category_id" id=""  style="width: 100%">
                        <option selected value="{{$category->id}}">{{$category->category_name}}</option>
                    </select>
                </div>
                <label for="basic-url">Compare SubCategory </label>
                @foreach ($arrCompareEdit as $i => $subcategory)
                 
                
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"
                                        id="basic-addon2">{{ $subcategory->subcategoryA->subcategory_name }}</span>
                                </div>
                                <select name="subcategory_compar_{{ $i }}" class="custom-select"
                                    aria-label="Default select example">

                                    @if ((float) $subcategory->value < 1)
                                        
                                    <option value="{{ $subcategory->subcategoryA->id }},{{(int) round(1 / (float) $subcategory->value)}},{{ $subcategory->subcategoryB->id }}">1 : {{(int) round(1 / (float) $subcategory->value)}}</option>
                                    @else
                                    <option value="{{ $subcategory->subcategoryA->id }},{{$subcategory->value}},{{ $subcategory->subcategoryB->id }}">{{ $subcategory->value}}</option>
                                    @endif
                                    <option value="{{ $subcategory->subcategoryA->id }},1,{{ $subcategory->subcategoryB->id }}">( 1 : 1 ), Sama Penting
                                    </option>
                                    <option value="{{ $subcategory->subcategoryA->id }},2,{{ $subcategory->subcategoryB->id }}">( 2  : 1 ), Mendekati
                                        Mutlak Dari
                                    </option>
                                    <option value="{{ $subcategory->subcategoryA->id }},3,{{ $subcategory->subcategoryB->id }}">( 3  : 1 ), Sedikit
                                        lebih penting
                                        dari </option>
                                    <option value="{{ $subcategory->subcategoryA->id }},4,{{ $subcategory->subcategoryB->id }}">( 4  : 1 ), Mendekati
                                        lebih
                                        penting dari</option>
                                    <option value="{{ $subcategory->subcategoryA->id }},5,{{ $subcategory->subcategoryB->id }}"> ( 5  : 1 ), Lebih
                                        Penting dari
                                    </option>
                                    <option value="{{ $subcategory->subcategoryA->id }},6,{{ $subcategory->subcategoryB->id }}">( 6  : 1 ), Mendekati
                                        sangat
                                        penting dari </option>
                                    <option value="{{ $subcategory->subcategoryA->id }},7,{{ $subcategory->subcategoryB->id }}">( 7  : 1 ), Sangat
                                        penting dari
                                    </option>
                                    <option value="{{ $subcategory->subcategoryA->id }},8,{{ $subcategory->subcategoryB->id }}">( 8  : 1 ), Mendekati
                                        mutlak
                                        dari </option>
                                    <option value="{{ $subcategory->subcategoryA->id }},9,{{ $subcategory->subcategoryB->id }}">( 9  : 1 ), Mutlak
                                        sangat
                                        penting dari </option>
                                        <option value="{{ $subcategory->subcategoryB->id }},2,{{ $subcategory->subcategoryA->id }}">( 1  : 2 ), Mendekati
                                            Mutlak Dari
                                        </option>
                                        <option value="{{ $subcategory->subcategoryB->id }},3,{{ $subcategory->subcategoryA->id }}">( 1  : 3 ), Sedikit
                                            lebih penting
                                            dari </option>
                                        <option value="{{ $subcategory->subcategoryB->id }},4,{{ $subcategory->subcategoryA->id }}">( 1  : 4 ), Mendekati
                                            lebih
                                            penting dari</option>
                                        <option value="{{ $subcategory->subcategoryB->id }},5,{{ $subcategory->subcategoryA->id }}"> ( 1  : 5 ), Lebih
                                            Penting dari
                                        </option>
                                        <option value="{{ $subcategory->subcategoryB->id }},6,{{ $subcategory->subcategoryA->id }}">( 1  : 6 ), Mendekati
                                            sangat
                                            penting dari </option>
                                        <option value="{{ $subcategory->subcategoryB->id }},7,{{ $subcategory->subcategoryA->id }}">( 1  : 7 ), Sangat
                                            penting dari
                                        </option>
                                        <option value="{{ $subcategory->subcategoryB->id }},8,{{ $subcategory->subcategoryA->id }}">( 1  : 8 ), Mendekati
                                            mutlak
                                            dari </option>
                                        <option value="{{ $subcategory->subcategoryB->id }},9,{{ $subcategory->subcategoryA->id }}">( 1  : 9 ), Mutlak
                                            sangat
                                            penting dari </option>
                                </select>

                                <div class="input-group-append">
                                    <span class="input-group-text"
                                        id="basic-addon2">{{ $subcategory->subcategoryB->subcategory_name }}</span>
                                </div>
                            </div>
                            @if ($errors->has("subcategory_compar_$i"))
                                <div class="error"> {{ $errors->first("subcategory_compar_$i") }}</div>
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

