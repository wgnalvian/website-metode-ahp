<table >
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