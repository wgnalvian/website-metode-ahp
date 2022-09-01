<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
    <title>Document</title>
</head>
<body>
    
<table class="table table-bordered" >
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
</body>
</html>