@extends('admin.base')

@section('title','Trang chu')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Danh sách hóa đơn</h3>
                </div>
                <div class="card-body">
                    <table class="table table-hover text-nowrap" id="bill-result">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Khách hàng</th>
                            <th>Số tiền</th>
                            <th>Thời gian</th>
                            <th>Trạng thái</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($bills as $bill)
                            <tr>
                                <td>{{$bill['id']}}</td>
                                <td>{{$bill['customer']['name']}}</td>
                                <td>{{$bill['amount']}}</td>
                                <td>{{$bill['to_date']}}</td>
                                <td>
                                    @if($bill['status'] == 1)
                                        Đã trả
                                    @else
                                        Chưa trả
                                    @endif
                                </td>
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
