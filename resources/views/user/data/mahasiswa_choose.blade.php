@include('layout.header')

<div class="row">
    <div class="col card">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Choose Data Mahasiswa</h6>
        </div>
        <div class="card-body">
            
            <div class="alert alert-success">
                <h6><b>Name &ThickSpace; : {{ $mahasiswa->name }}</b></h6>
                <h6><b>Nim &ThickSpace; &ThickSpace; &ThinSpace; : {{ $mahasiswa->nim }}</b></h6>
            </div>
            <form action="{{ url('/mahasiswa/choose') }}" method="POST">
                @csrf
                <input type="hidden" name="mahasiswa_id" value="{{ $mahasiswa->id }}">
                @foreach ($categories as $category)
                    <div class="input-group mb-3 mt-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">{{ $category->category_name }}</span>
                        </div>
                        <select class="custom-select" name="category_id_{{ $category->id }}" id="">
                            @foreach ($category->subcategory as $subcategory)
                                <option value="{{ $subcategory->id }}">{{ $subcategory->subcategory_name }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has("category_id_$category->id"))
                            <div class="error"> {{ $errors->first("category_id_$category->id") }}</div>
                        @endif

                    </div>
                @endforeach

                <button type="submit" class="btn btn-primary">Choose</button>
            </form>
        </div>
    </div>
</div>
@include('layout.footer')
