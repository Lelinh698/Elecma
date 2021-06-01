@extends('templates.master')

@section('title','Trang chu')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        Chủ hộ: {{$customer['name']}}<br>
                        Địa chỉ: {{$customer['address']}}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div id="columnchart_material" style="width: 100%; height: 400px; margin-top: 15px;"></div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Biểu đồ sử dụng điện', '(KW)'],
                ['Tháng 1', {{$meter[0]}}],
                ['Tháng 2', {{$meter[1]}}],
                ['Tháng 3', {{$meter[2]}}],
                ['Tháng 4', {{$meter[3]}}],
                ['Tháng 5', {{$meter[4]}}],
                ['Tháng 6', {{$meter[5]}}],
                ['Tháng 7', {{$meter[6]}}],
                ['Tháng 8', {{$meter[7]}}],
                ['Tháng 9', {{$meter[8]}}],
                ['Tháng 10', {{$meter[9]}}],
                ['Tháng 11', {{$meter[10]}}],
                ['Tháng 12', {{$meter[11]}}]
            ]);

            var options = {
                chart: {
                    //title: 'Biểu đồ sử dụng điện',
                    subtitle: 'Năm sử dụng: {{$year}}',
                }
            };
            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>
@endsection
