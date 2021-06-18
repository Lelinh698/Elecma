<!DOCTYPE html>
<html lang="en" style="height: auto">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}" type="text/css">
</head>
<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <div class="content-wrapper">
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="invoice p-3 mb-3">
                                <!-- title row -->
                                <div class="row">
                                    <div class="col-12">
                                        <h4>
                                            <i class="fas fa-globe"></i> {{$data['department']['name']}}
                                            <small class="float-right">Date: {{$data['date']}}</small>
                                        </h4>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- info row -->
                                <div class="row invoice-info">
                                    <div class="col-sm-4 invoice-col">
                                        From
                                        <address>
                                            <strong>{{$data['department']['name']}}</strong><br>
                                            {{$data['department']['address']}}<br>
                            {{--                Phone: (804) 123-5432<br>--}}
                                        </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 invoice-col">
                                        To
                                        <address>
                                            <strong>{{$data['customer']['name']}}</strong><br>
                                            {{$data['customer']['address']}}<br>
                                            Phone: {{$data['customer']['phone']}}<br>
                                            Email: {{$data['customer']['email']}}
                                        </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 invoice-col">
                                        <b>Bill ID:</b>{{$data['bill']['id']}}<br>
                                        <br>
                                        <b>Account:</b> {{$data['customer']['username']}}
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                <tr>
                                                    <th style="width:50%">Chỉ số đầu:</th>
                                                    <td>{{$data['bill']['initial_number']}}</td>
                                                </tr>
                                                <tr>
                                                    <th style="width:50%">Chỉ số cuối:</th>
                                                    <td>{{$data['bill']['final_number']}}</td>
                                                </tr>
                                                <tr>
                                                    <th style="width:50%">Từ ngày:</th>
                                                    <td>{{$data['bill']['from_date']}}</td>
                                                </tr>
                                                <tr>
                                                    <th style="width:50%">Đến ngày:</th>
                                                    <td>{{$data['bill']['to_date']}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Giá tiền mỗi số:</th>
                                                    <td>{{$data['bill']['price_per_number']}}₫</td>
                                                </tr>
                                                <tr>
                                                    <th>Tổng tiền:</th>
                                                    <td>{{$data['bill']['amount']}}₫</td>
                                                </tr>
                                                </tbody></table>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<script type="text/javascript" src="{!! url('js/jquery.min.js') !!}"></script>
	<script type="text/javascript" src="{!! url('js/bootstrap.bundle.min.js') !!}"></script>
	<script type="text/javascript" src="{!! url('js/adminlte.min.js') !!}"></script>
</body>
</html>
