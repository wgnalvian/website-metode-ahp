@include('layout.header')
<div class="row">
    <div class="card" style="width: 100%">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Category Comparation List</h6>
        </div>
        <div class="card-body">
            <a href="{{url("/admin/subcategory/compar/edit?category_id=".strval($subcategories[0]->category_id))}}" class="btn btn-primary">edit</a>
        </div>
    </div>
    <div class="card" style="width: 100%">
        
        <div class="card-body">
            <h6>Comparation of category</h6>
            <div class="row" style="width: 100%">
                <div class="col-2">
                       <table class="table table-bordered">
                        <tr>
                               
                                <th>Category</th>
                              
                            </tr>

                  
                        @foreach ($subcategories as $subcategory)
                        <tr>
                                <th>{{ $subcategory['subcategory_name'] }}</th>
                            </tr>
                            @endforeach

                    </table>
                </div>
                <div class="col-10">
                    <table class="table table-bordered">
                        <tr>
                                @foreach ($subcategories as $subcategory)
                                <th>{{ $subcategory['subcategory_name'] }}</th>
                                @endforeach
                            </tr>

                 
                        @foreach ($subcategory_compar as $items)
                            <tr>
                                @foreach ($items as $item)
                                    <td style="width: 33%">{{ $item['value'] }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </table>
                </div>
              
            </div>

        </div>
    </div>
    <div class="card mt-4" style="width: 100%">
        <div class="card-body">
            <h6>Eigen Value of subcategory</h6>
            <div class="row" style="width: 100%;overflow: auto;">
                <div class="col-2">
                       <table class="table table-bordered">
                        <tr>
                               
                                <th>Category</th>
                              
                            </tr>

                  
                        @foreach ($subcategories as $subcategory)
                        <tr>
                                <th>{{ $subcategory['subcategory_name'] }}</th>
                            </tr>
                            @endforeach

                    </table>
                </div>
                <div class="col-10">
                    <table class="table table-bordered">
                        <tr>
                                @foreach ($subcategories as $subcategory)
                                <th >{{ $subcategory['subcategory_name'] }}</th>
                                @endforeach
                                <th >Total Eigen</th>
                                <th >Mean Eigen (final score)</th>
                            </tr>

                
                        @foreach ($subcategory_compar as $key => $items)
                            <tr>
                                @foreach ($items as $item)
                                    <td >{{ $item['eigen_value'] }}</td>
                                @endforeach
                                <td >{{$total_eigen[$key]}}</td>
                                <td s>{{$mean_eigen[$key]}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
              
            </div>

        </div>
    </div>
</div>
@include('layout.footer')
