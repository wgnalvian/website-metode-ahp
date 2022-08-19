@include('layout.header')

<div class="row">
    <div class="col card">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Ranking Mahasiswa</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="dataTable">
                <tr>
                    <th>Name</th>
                    <th>Nim</th>
                    <th>Total Score</th>
                    <th>Rank</th>
                </tr>
                <?php $i = 1 ?>
                @foreach ($result as $key => $item)
                    <tr>
                        <td>{{$item['mahasiswa']->name}}</td>
                        <td>{{$item['mahasiswa']->nim}}</td>
                        <td>{{$item['total_score']}}</td>
                        <td>@if ($i == 1)
                            <b>{{$i}} <i class="fas fa-crown"></i></b>
                        @else {{$i}} @endIf</td>
                    </tr>
                <?php $i++ ?>
                @endforeach
            </table>
        </div>
    </div>
</div>
<script>
    let array = "@foreach($result as $value)'{{$value['mahasiswa']->name}}'@endforeach"
    array = array.split("'").map(String);
</script>
@include('layout.footer')