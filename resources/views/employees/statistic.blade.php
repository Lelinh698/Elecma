@extends('templates.master')

@section('title','Thống kê')

@section('css')


@section('content')
{{--    <div class="row">--}}
{{--        <div class="col-12 col-sm-6 col-md-3">--}}
{{--            <div class="info-box">--}}
{{--                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>--}}

{{--                <div class="info-box-content">--}}
{{--                    <span class="info-box-text"></span>--}}
{{--                    <span class="info-box-number">--}}
{{--                  10--}}
{{--                  <small>%</small>--}}
{{--                </span>--}}
{{--                </div>--}}
{{--                <!-- /.info-box-content -->--}}
{{--            </div>--}}
{{--            <!-- /.info-box -->--}}
{{--        </div>--}}
{{--        <!-- /.col -->--}}
{{--        <div class="col-12 col-sm-6 col-md-3">--}}
{{--            <div class="info-box mb-3">--}}
{{--                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>--}}

{{--                <div class="info-box-content">--}}
{{--                    <span class="info-box-text">Likes</span>--}}
{{--                    <span class="info-box-number">41,410</span>--}}
{{--                </div>--}}
{{--                <!-- /.info-box-content -->--}}
{{--            </div>--}}
{{--            <!-- /.info-box -->--}}
{{--        </div>--}}
{{--        <!-- /.col -->--}}

{{--        <!-- fix for small devices only -->--}}
{{--        <div class="clearfix hidden-md-up"></div>--}}

{{--        <div class="col-12 col-sm-6 col-md-3">--}}
{{--            <div class="info-box mb-3">--}}
{{--                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>--}}

{{--                <div class="info-box-content">--}}
{{--                    <span class="info-box-text">Sales</span>--}}
{{--                    <span class="info-box-number">760</span>--}}
{{--                </div>--}}
{{--                <!-- /.info-box-content -->--}}
{{--            </div>--}}
{{--            <!-- /.info-box -->--}}
{{--        </div>--}}
{{--        <!-- /.col -->--}}
{{--        <div class="col-12 col-sm-6 col-md-3">--}}
{{--            <div class="info-box mb-3">--}}
{{--                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>--}}

{{--                <div class="info-box-content">--}}
{{--                    <span class="info-box-text">New Members</span>--}}
{{--                    <span class="info-box-number">2,000</span>--}}
{{--                </div>--}}
{{--                <!-- /.info-box-content -->--}}
{{--            </div>--}}
{{--            <!-- /.info-box -->--}}
{{--        </div>--}}
{{--        <!-- /.col -->--}}
{{--    </div>--}}

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title">Danh sách khách hàng</h3>
            </div>
            <div class="card-body">
                <table class="table table-hover text-nowrap" id="bill-result">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên đăng nhập</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                    </tr>
                    </thead>
                    <tbody>
{{--                    @foreach($customers as $customer)--}}
                        <tr>
{{--                            <td>{{$customer['id']}}</td>--}}
{{--                            <td>{{$customer['username']}}</td>--}}
{{--                            <td>{{$customer['name']}}</td>--}}
{{--                            <td>{{$customer['email']}}</td>--}}
{{--                            <td>{{$customer['phone']}}₫</td>--}}
{{--                            <td>{{$customer['address']}}</td>--}}
                        </tr>
{{--                    @endforeach--}}
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title">Danh sách khách hàng</h3>
            </div>
            <div class="card-body">
                <table class="table table-hover text-nowrap" id="bill-result">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên đăng nhập</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                    </tr>
                    </thead>
                    <tbody>
                    {{--                    @foreach($customers as $customer)--}}
                    <tr>
                        {{--                            <td>{{$customer['id']}}</td>--}}
                        {{--                            <td>{{$customer['username']}}</td>--}}
                        {{--                            <td>{{$customer['name']}}</td>--}}
                        {{--                            <td>{{$customer['email']}}</td>--}}
                        {{--                            <td>{{$customer['phone']}}₫</td>--}}
                        {{--                            <td>{{$customer['address']}}</td>--}}
                    </tr>
                    {{--                    @endforeach--}}
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title">Danh sách khách hàng chưa trả tiền</h3>
            </div>
            <div class="card-body">
                <table class="table table-hover text-nowrap" id="bill-result">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên đăng nhập</th>
                            <th>Họ tên</th>
{{--                            <th>CMT</th>--}}
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Thời gian</th>
                            <th>Số tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($unpaidData as $data)
                    <tr>
                        <td>{{$loop->index+1}}</td>
                        <td>{{$data['username']}}</td>
                        <td>{{$data['name']}}</td>
                        <td>{{$data['phone']}}</td>
                        <td>{{$data['address']}}</td>
                        <td>{{$data['time']}}</td>
                        <td>{{$data['amount']}}₫</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
@endsection
