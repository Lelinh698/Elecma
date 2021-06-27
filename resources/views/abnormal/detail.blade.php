@extends('templates.master')

@section('title','Trang chu')

@section('content')
    <div class="row">
        <div class="col-12">
{{--            <div class="card">--}}
{{--                <div class="card-header border-0">--}}
{{--                    <h3 class="card-title">--}}
{{--                        Chủ hộ: {{$customer['name']}}<br>--}}
{{--                        Địa chỉ: {{$customer['address']}}--}}
{{--                    </h3>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-md-1"></div>--}}
{{--                        <div class="col-md-10">--}}
{{--                            <div id="columnchart_material" style="width: 100%; height: 400px; margin-top: 15px;"></div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-1"></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <!-- /.card-body -->--}}
{{--            </div>--}}
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        Chủ hộ: {{$customer['name']}}<br>
                        Địa chỉ: {{$customer['address']}}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <p class="d-flex flex-column">
{{--                            <span class="text-bold text-lg">$18,230.00</span>--}}
                            <span>Số điện</span>
                        </p>
{{--                        <p class="ml-auto d-flex flex-column text-right">--}}
{{--                    <span class="text-success">--}}
{{--                      <i class="fas fa-arrow-up"></i> 33.1%--}}
{{--                    </span>--}}
{{--                            <span class="text-muted">Since last month</span>--}}
{{--                        </p>--}}
                    </div>
                    <!-- /.d-flex -->

                    <div class="position-relative mb-4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <canvas id="sales-chart" height="200" style="display: block; width: 454px; height: 200px;" width="454" class="chartjs-render-monitor"></canvas>
                    </div>

                    <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> 12 tháng gần nhất
                  </span>

                        <span>
                    <i class="fas fa-square text-gray"></i> Tháng trước đó 1 năm
                  </span>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(function(){
            'use strict'
            const previous_data = {!! $previous  !!};
            const current_data = {!! $current  !!}
            // console.log(current['number'])
            var months = {{$month}};
            var label = []
            months.forEach(function (month) {
                label.push("Tháng " + month)
            })

            var ticksStyle = {
                fontColor: '#495057',
                fontStyle: 'bold'
            }

            var mode      = 'index'
            var intersect = true

            var $salesChart = $('#sales-chart')
            var salesChart  = new Chart($salesChart, {
                type   : 'bar',
                data   : {
                    labels  : label,
                    datasets: [
                        {
                            backgroundColor: '#ced4da',
                            borderColor    : '#ced4da',
                            data           : previous_data['number']
                        },
                        {
                            backgroundColor: '#007bff',
                            borderColor    : '#007bff',
                            data           : current_data['number']
                        }
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips           : {
                        mode     : mode,
                        intersect: intersect
                    },
                    hover              : {
                        mode     : mode,
                        intersect: intersect
                    },
                    legend             : {
                        display: false
                    },
                    scales             : {
                        yAxes: [{
                            // display: false,
                            gridLines: {
                                display      : true,
                                lineWidth    : '4px',
                                color        : 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent'
                            },
                            ticks    : $.extend({
                                beginAtZero: true,

                                // Include a dollar sign in the ticks
                                callback: function (value, index, values) {
                                    return value
                                }
                            }, ticksStyle)
                        }],
                        xAxes: [{
                            display  : true,
                            gridLines: {
                                display: false
                            },
                            ticks    : ticksStyle
                        }]
                    }
                }
            })
        })
    </script>
@endsection
