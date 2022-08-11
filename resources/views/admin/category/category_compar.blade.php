@include('layout.header')


<div class="row ">
    <div class="col card sizing py-2">
        <div class="card-body">
            <form action="{{ url('/admin/category/compar') }}" method="POST">
                @csrf
                <?php $temp = []; ?>
                <?php $i = 1; ?>
                @foreach ($categories as $precategory)
                    <?php array_push($temp, $precategory['category_name']); ?>
                    @foreach ($categories as $sufcategory)
                        @if ($sufcategory['category_name'] != $precategory['category_name'] &&
                            !in_array($sufcategory['category_name'], $temp))
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"
                                        id="basic-addon2">{{ $precategory['category_name'] }}</span>
                                </div>
                                <select name="category_compar_{{ $i }}" class="custom-select"
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
                                        id="basic-addon2">{{ $sufcategory['category_name'] }}</span>
                                </div>
                            </div>
                            @if ($errors->has("category_compar_$i"))
                                <div class="error"> {{ $errors->first("category_compar_$i") }}</div>
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
@include('layout.footer')
