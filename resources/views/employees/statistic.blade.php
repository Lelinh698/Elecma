@extends('templates.master')

@section('title','Thống kê')

@section('css')


@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title">Danh sách khách hàng đã trả tiền</h3>
            </div>
            <div class="card-body">
                <table class="table table-hover text-nowrap" id="bill-result">
                <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên đăng nhập</th>
                            <th>Họ tên</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Thời gian</th>
                            <th>Số tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($paidData as $data)
                    <tr>
                        <td>{{$loop->index+1}}</td>
                        <td>{{$data['customer']['username']}}</td>
                        <td>{{$data['customer']['name']}}</td>
                        <td>{{$data['customer']['phone']}}</td>
                        <td>{{$data['customer']['address']}}</td>
                        <td>{{ date('M-y', strtotime($data['from_date'])) }}</td>
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
                        <td>{{$data['customer']['username']}}</td>
                        <td>{{$data['customer']['name']}}</td>
                        <td>{{$data['customer']['phone']}}</td>
                        <td>{{$data['customer']['address']}}</td>
                        <td>{{ date('M-y', strtotime($data['from_date'])) }}</td>
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
