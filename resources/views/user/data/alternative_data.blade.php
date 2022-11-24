@include('layout.header')

<div class="row">
    <div class="col card">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Alternative</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatTables" class="table table-bordered "  width="100%" cellspacing="0">
                    <thead>
                        <tr class="">
                           
                            <th>Mahasiswa</th>
                            <th>Category</th>
                             <th>Score</th>
                            <th>SubCategory</th>
                            <th>Score</th>
                            <th>Action</th>

                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($mahasiswas as $key => $item)
                            <?php $old = ''; ?>
                            @if (count($item->alternativeData)  < 1)
                            <tr>

                                <td>{{$item->name}}</td>
                                <td>*</td>
                                 <td>0</td>
                                <td>*</td>
                                <td>0</td>
                                <td><a  href="{{url("/mahasiswa/choose/$item->id")}}"class="btn btn-primary">Select Data</a></td>
                            </tr>
                            @endIf
                            @foreach ($item->alternativeData as $value)
                                <tr>
                                    @if ($item->name != $old)
                                       
                                        
                                        <td rowspan="{{ count($item->alternativeData) }}">{{ $item->name }}</td>
                                    @endif
                                 
                                        
                                    <td>{{$value->subcategory->category->category_name}}</td>
                                      <td>{{$value->subcategory->category->final_score}}</td>
                                    <td>{{ $value->subcategory->subcategory_name }}</td>
                                    <td>{{$value->subcategory->final_score}}</td>

                                    <td>
                                    
                                        <form class="d-inline" action="{{ url('/alternative-data') }}" method="post">
                                            @method('delete')
                                            @csrf
                                            <input type="hidden" name="alternative_id" value="{{ $value->id}}" />
                                            <button type="submit" class="btn btn-danger">delete</button>
                                        </form>
                                    </td>
                                  
                                </tr>
                                <?php $old = $item->name; ?>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>



@include('layout.footer')
