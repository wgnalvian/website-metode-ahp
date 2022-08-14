@include('layout.header')


<div class="row ">
    <div class="col card sizing py-2">
        <div class="card-body">
            <form class="{{ $isCompareExist ? 'COMPARE' : '' }}" action="{{ url('/admin/subcategory/compar') }}"
                method="POST">
                @csrf
                <label for="basic-url">Category </label>
                <div class="input-group mb-3">
                  
                    <select class="custom-select" name="category_id" id=""  style="width: 100%">
                        <option selected value="{{$category->id}}">{{$category->category_name}}</option>
                    </select>
                   
                </div>
                <?php $temp = []; ?>
                <?php $i = 1; ?>
                     <label for="basic-url">SubCategory Compar </label>
                @foreach ($category->subcategory as $precategory)
                    <?php array_push($temp, $precategory['subcategory_name']); ?>
                    @foreach ($category->subcategory as $sufcategory)
                        @if ($sufcategory['subcategory_name'] != $precategory['subcategory_name'] &&
                            !in_array($sufcategory['subcategory_name'], $temp))
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"
                                        id="basic-addon2">{{ $precategory['subcategory_name'] }}</span>
                                </div>
                                <select name="subcategory_compar_{{ $i }}" class="custom-select"
                                    aria-label="Default select example">

                                    <option value="">Choose Category ...</option>
                                    <option value="{{ $precategory['id'] }},1,{{ $sufcategory['id'] }}">1, Sama Penting
                                    </option>
                                    <option value="{{ $precategory['id'] }},2,{{ $sufcategory['id'] }}">2, Mendekati
                                        Mutlak Dari
                                    </option>
                                    <option value="{{ $precategory['id'] }},3,{{ $sufcategory['id'] }}">3, Sedikit
                                        lebih penting
                                        dari </option>
                                    <option value="{{ $precategory['id'] }},4,{{ $sufcategory['id'] }}">4, Mendekati
                                        lebih
                                        penting dari</option>
                                    <option value="{{ $precategory['id'] }},5,{{ $sufcategory['id'] }}">5, Lebih
                                        Penting dari
                                    </option>
                                    <option value="{{ $precategory['id'] }},6,{{ $sufcategory['id'] }}">6, Mendekati
                                        sangat
                                        penting dari </option>
                                    <option value="{{ $precategory['id'] }},7,{{ $sufcategory['id'] }}">7, Sangat
                                        penting dari
                                    </option>
                                    <option value="{{ $precategory['id'] }},8,{{ $sufcategory['id'] }}">8, Mendekati
                                        mutlak
                                        dari </option>
                                    <option value="{{ $precategory['id'] }},9,{{ $sufcategory['id'] }}">9, Mutlak
                                        sangat
                                        penting dari </option>
                                </select>

                                <div class="input-group-append">
                                    <span class="input-group-text"
                                        id="basic-addon2">{{ $sufcategory['subcategory_name'] }}</span>
                                </div>
                            </div>
                            @if ($errors->has("subcategory_compar_$i"))
                                <div class="error"> {{ $errors->first("subcategory_compar_$i") }}</div>
                            @endif
                            <?php $i++; ?>
                        @endif
                    @endforeach
                @endforeach
                <button type="submit" class="btn btn-primary">Compar Category</button>
            </form>
        </div>
    </div>
</div>
<script>
    document.querySelector('.COMPARE').addEventListener('submit', (e) => {
        e.preventDefault();

        Swal.fire({
            title: 'Are you sure for compare ?',
            text: 'There is have value compare from old compare, this action will remove olde compare value',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'oke',
            cancelButtonText: 'cancel',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                document.querySelector('.COMPARE').submit();
            } else {
                return false
            }
        })
    })
</script>
@include('layout.footer')
