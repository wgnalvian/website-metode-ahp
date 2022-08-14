@include('layout.header')

<div class="row">
    <div class="col card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered"  width="100%" cellspacing="0">
                    <thead>
                        <tr class="table-success">
                           
                            <th>Category</th>
                            <th>SubCategory</th>
                            <th>Is Compare ?</th>
                            <th>Action</th>

                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($data as $key => $item)
                            <?php $old = ''; ?>
                        
                            @foreach ($item['subcategory'] as $subcategory)
                                <tr>
                                    @if ($item['category_name'] != $old)
                                       
                                        
                                        <td rowspan="{{ count($item['subcategory']) }}">{{ $item['category_name'] }}</td>
                                    @endif

                                    <td>{{ $subcategory['subcategory_name'] }}</td>
                                    <td><div class="badge {{$subcategory->is_compare == '1' ? 'badge-success' : 'badge-danger' }}">{{$subcategory->is_compare == '1' ? 'Yes' : 'No' }}</div></td>

                                    <td>
                                        <form class="d-inline" action="{{ url('/admin/subcategory/edit') }}" method="get">
                                           
                                            @csrf
                                            <input type="hidden" name="subcategory_id" value="{{$subcategory['id']}}" />
                                            <button type="submit" class="btn btn-warning ">edit</button>
                                        </form>
                                        <form class="d-inline" action="{{ url('/admin/subcategory') }}" method="post">
                                            @method('delete')
                                            @csrf
                                            <input type="hidden" name="subcategory_id" value="{{$subcategory['id']}}" />
                                            <button type="submit" class="btn btn-danger">delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php $old = $item['category_name']; ?>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>



@include('layout.footer')
