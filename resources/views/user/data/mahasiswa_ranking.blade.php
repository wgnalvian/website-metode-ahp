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
                    @if (array_key_exists($key + 1, $result))
                        @if ($result[$key + 1]['total_score'] !== $item['total_score'])
                            
                        <?php $i++ ?>
                        @endif
                    @endif
                @endforeach
            </table>
        </div>
    </div>
</div>
<div class="row">
    
             <div class="col card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Bar Chart</h6>
                                </div>
                                <div class="card-body">
                                   
                                        <canvas style="height: 100%" id="myBarChart"></canvas>
                                   
                                </div>
                            </div>
      
</div>
<script src="{{asset('vendor/chart.js/Chart.min.js')}}"></script>
 
<script>
    let array = "@foreach($result as $value)'{{$value['mahasiswa']->name}}'@endforeach";
    let total = "@foreach($result as $value)'{{$value['total_score']}}'@endforeach"
    array = array.split("'").map(String);
    array = array.filter((v) => v !== "")
     total = total.split("'").map(String);
    total = total.filter((v) => v !== "")
   total = total.map((v) => parseFloat(v))
   console.log(total)
    var ctx = document.getElementById("myBarChart");
var myBarChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: array,
    datasets: [{
      label: "Revenue",
      backgroundColor: "#4e73df",
      hoverBackgroundColor: "#2e59d9",
      borderColor: "#4e73df",
      data: total,
    }],
  },
 
});


</script>
@include('layout.footer')