
@extends('layouts.app')

@section('content')
<div class="container">
  <div class="table-responsive">
    <table id="admintable" class="table table-bordred table-striped table-condensed" style="margin-top:7px">
      <b>Adminを抜いたユーザ数：{{$users_count}}<br></b>
      <b><font color="blue">120時間以下 = 青</font></b><br>
      <b><font color="purple">180時間以上 = 紫</font></b><br>
      <b><font color="red">200時間以上 = 赤</font></b><br>

      <thead>
        <th class="col-ms-1 text-center">名前</th>
        <th class="col-ms-1 text-center"><php>{{date('Y-m')}}月</php></th>
        <th class="col-ms-1 text-center"><php>{{date('Y-m',strtotime("-1 month"))}}月</php></th>
        <th class="col-ms-1 text-center"><php>{{date('Y-m',strtotime("-2 month"))}}月</php></th>
        <th class="col-ms-1 text-center"><php>{{date('Y-m',strtotime("-3 month"))}}月</php></th>
        <th class="col-ms-1 text-center"><php>{{date('Y-m',strtotime("-4 month"))}}月</php></th>
        <th class="col-ms-1 text-center"><php>{{date('Y-m',strtotime("-5 month"))}}月</php></th>
        <th class="col-ms-1 text-center"><php>{{date('Y-m',strtotime("-6 month"))}}月</php></th>
      </thead>

      <tbody>
        @for($i = 0; $i < $users_count; $i++)
          <tr>
            <td class="text-center"><a href="{{url('/usertasks/'.$month_works[$i][0])}}" >{{$month_works[$i][1]}}</a></td>

            @if($month_works[$i][2] >= 200)
              <td class="col-ms-1 text-center"><b><font color="red">{{$month_works[$i][2]}}</font></b></td>
            @elseif($month_works[$i][2] >= 180)
              <td class="col-ms-1 text-center"><b><font color="purple">{{$month_works[$i][2]}}</font></b></td>
            @else
              <td class="col-ms-1 text-center">{{$month_works[$i][2]}}</td>
            @endif

            @if($last_month_works[$i][2] >= 200)
              <td class="col-ms-1 text-center"><b><font color="red">{{$last_month_works[$i][2]}}</font></b></td>
            @elseif($last_month_works[$i][2] >= 180)
              <td class="col-ms-1 text-center"><b><font color="purple">{{$last_month_works[$i][2]}}</font></b></td>
            @else
              <td class="col-ms-1 text-center">{{$last_month_works[$i][2]}}</td>
            @endif

            @if($second_month_works[$i][2] >= 200)
              <td class="col-ms-1 text-center"><b><font color="red">{{$second_month_works[$i][2]}}</font></b></td>
            @elseif($second_month_works[$i][2] >= 180)
              <td class="col-ms-1 text-center"><b><font color="purple">{{$second_month_works[$i][2]}}</font></b></td>
            @else
              <td class="col-ms-1 text-center">{{$second_month_works[$i][2]}}</td>
            @endif

            @if($third_month_works[$i][2] >= 200)
              <td class="col-ms-1 text-center"><b><font color="red">{{$third_month_works[$i][2]}}</font></b></td>
            @elseif($third_month_works[$i][2] >= 180)
              <td class="col-ms-1 text-center"><b><font color="purple">{{$third_month_works[$i][2]}}</font></b></td>
            @else
              <td class="col-ms-1 text-center">{{$third_month_works[$i][2]}}</td>
            @endif

            @if($forth_month_works[$i][2] >= 200)
              <td class="col-ms-1 text-center"><b><font color="red">{{$forth_month_works[$i][2]}}</font></b></td>
            @elseif($forth_month_works[$i][2] >= 180)
              <td class="col-ms-1 text-center"><b><font color="purple">{{$forth_month_works[$i][2]}}</font></b></td>
            @else
              <td class="col-ms-1 text-center">{{$forth_month_works[$i][2]}}</td>
            @endif

            @if($five_month_works[$i][2] >= 200)
              <td class="col-ms-1 text-center"><b><font color="red">{{$five_month_works[$i][2]}}</font></b></td>
            @elseif($five_month_works[$i][2] >= 180)
              <td class="col-ms-1 text-center"><b><font color="purple">{{$five_month_works[$i][2]}}</font></b></td>
            @else
              <td class="col-ms-1 text-center">{{$five_month_works[$i][2]}}</td>
            @endif

            @if($six_month_works[$i][1] >= 200)
              <td class="col-ms-1 text-center"><b><font color="red">{{$six_month_works[$i][2]}}</font></b></td>
            @elseif($six_month_works[$i][1] >= 180)
              <td class="col-ms-1 text-center"><b><font color="purple">{{$six_month_works[$i][2]}}</font></b></td>
            @else
              <td class="col-ms-1 text-center">{{$six_month_works[$i][2]}}</td>
            @endif

          </tr>
        @endfor
      </tbody>
    </table>
  </div>

  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">Dashboard</div>
        <div class="panel-body">
          <div class="col-md-9">
            <canvas id="myChart" width="100" height="100"></canvas>
          </div>
        </div>
         </div>
      </div>
    </div>
</div>

@endsection

@section('script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>

<script>
    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
            datasets: [{
                label: '# of Votes',
                data: [1, 2, 1, 2, 2, 1],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
</script>
@endsection
