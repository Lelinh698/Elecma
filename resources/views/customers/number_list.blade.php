@extends('templates.master')

@section('title','Danh sách số điện')

@section('content')
    <div class="card">
        <div class="card-header border-0">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">Số điện tiêu thụ</h3>
                <div class="input-group input-group-sm" style="width: 250px;">
                    <label for="year" class="control-label">Chọn năm</label>
                    <select name="year" id="year" class="form-control float-right">
                        <option>2021</option>
                        <option>2020</option>
                        <option>2019</option>
                    </select>
                    {{--                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">--}}

                    <div class="input-group-append">
                        <button id="search" type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
{{--            <div class="card-tools">--}}

{{--            </div>--}}
        </div>
        <div class="card-body">
{{--            <div class="d-flex">--}}
{{--                <p class="d-flex flex-column">--}}
{{--                    <span class="text-bold text-lg">820</span>--}}
{{--                    <span></span>--}}
{{--                </p>--}}
{{--                <p class="ml-auto d-flex flex-column text-right">--}}
{{--                    <span class="text-success">--}}
{{--                      <i class="fas fa-arrow-up"></i> 12.5%--}}
{{--                    </span>--}}
{{--                    <span class="text-muted">Since last week</span>--}}
{{--                </p>--}}
{{--            </div>--}}
            <!-- /.d-flex -->

            <div class="position-relative mb-4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                <canvas id="visitors-chart" height="200" width="454" class="chartjs-render-monitor" style="display: block; width: 454px; height: 200px;"></canvas>
            </div>

            <div class="d-flex flex-row justify-content-end">
{{--                  <span class="mr-2">--}}
{{--                    <i class="fas fa-square text-primary"></i> This Week--}}
{{--                  </span>--}}

                <span id="year-info">
                    Năm {{$year}}
                  </span>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    var numbers = <?= $numbers; ?>;
    $(function () {
        'use strict'
        function create_chart(numbers) {
            var ticksStyle = {
                fontColor: '#495057',
                fontStyle: 'bold'
            }

            var mode      = 'index'
            var intersect = true
            var $visitorsChart = $('#visitors-chart')
            var visitorsChart  = new Chart($visitorsChart, {
                data   : {
                    labels  : [
                        'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4',
                        'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8',
                        'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
                    datasets: [{
                        type                : 'line',
                        data                : numbers,
                        borderColor         : '#007bff',
                        pointBorderColor    : '#007bff',
                        pointBackgroundColor: '#007bff',
                        fill                : false
                        // pointHoverBackgroundColor: '#007bff',
                        // pointHoverBorderColor    : '#007bff'
                    }]
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
                                beginAtZero : true,
                                suggestedMax: 1000
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
        }
        console.log(numbers)
        create_chart(numbers)

        $('#search').click(function (e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: '/customer/{{auth('customer')->id()}}/meter/search',
                data: {
                    'customer_id': {{auth('customer')->id()}},
                    'year': $('#year').val()
                },
                success: function (data) {
                    data = JSON.parse(data);
                    console.log(data)
                    create_chart(data['numbers'])
                    $('#year-info').html('Năm ' + data['year'])
                },
            })
        });
    })
</script>
@endsection
