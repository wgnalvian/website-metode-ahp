@include('layout.header')


<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Category</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['category'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            SubCategory</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['subcategory'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Mahasiswa
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $data['mahasiswa'] }}</div>
                            </div>

                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<!-- Content Row -->

<div class="row">

    <!-- Area Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Grafik Rank</h6>

            </div>
            <!-- Card Body -->
            <div class="card-body">
            
                    <canvas id="myBarChart"></canvas>
              
            </div>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-xl-4 col-lg-5">

        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Rank Mahasiswa</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <table class="table table-bordered" id="dataTable">
                    <tr>
                        <th>Name</th>
                        <th>Nim</th>
                        <th>Total Score</th>
                        <th>Rank</th>

                    </tr>
                    <?php $i = 1; ?>
                    @foreach ($data['result'] as $key => $item)
                        <tr>
                            <td>{{ $item['mahasiswa']->name }}</td>
                            <td>{{ $item['mahasiswa']->nim }}</td>
                            <td>{{ $item['total_score'] }}</td>
                            <td>
                                @if ($i == 1)
                                    <b>{{ $i }} <i class="fas fa-crown"></i></b>
                                @else
                                    {{ $i }}
                                @endIf
                            </td>

                        </tr>
                        @if (array_key_exists($key + 1, $data['result']))
                            @if ($data['result'][$key + 1]['total_score'] !== $item['total_score'])
                                <?php $i++; ?>
                            @endif
                        @endif
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->


<script src="{{asset('vendor/chart.js/Chart.min.js')}}"></script>
<script>
    let array = "@foreach($data['result'] as $value)'{{$value['mahasiswa']->name}}'@endforeach";
    let total = "@foreach($data['result'] as $value)'{{$value['total_score']}}'@endforeach"
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
      label: "Mahasiswa",
      backgroundColor: "#4e73df",
      hoverBackgroundColor: "#2e59d9",
      borderColor: "#4e73df",
      data: total,
    }],
  },
 
});


</script>
@include('layout.footer')
