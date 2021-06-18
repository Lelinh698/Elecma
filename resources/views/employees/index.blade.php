@extends('templates.master')

@section('title','Trang chu')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">hông tin chi nhánh điện</h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-6">Tên chi nhánh</dt>
                    <dd class="col-sm-6">{{ $department->name }}</dd>
                    <dt class="col-sm-6">Địa chỉ</dt>
                    <dd class="col-sm-6">{{ $department->address }}</dd>
                </dl>
            </div>
            <!-- /.card-body -->
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Thông tin nhân viên</h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-6">Username</dt>
                    <dd class="col-sm-6">{{ $employee->username }}</dd>
                    <dt class="col-sm-6">Email</dt>
                    <dd class="col-sm-6">{{ $employee->email }}</dd>
                    <dt class="col-sm-6">Số điện thoại</dt>
                    <dd class="col-sm-6">{{ $employee->phone }}</dd>
                </dl>
            </div>
            <!-- /.card-body -->
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Các hóa đơn chưa được trả</h3>
            </div>
            <div class="card-body">
                <table class="table table-hover text-nowrap">
                    <thead>
                    <tr>
                        <th>Thời gian</th>
                        <th>Từ ngày</th>
                        <th>Tới ngày</th>
                        <th>Số hóa đơn</th>
                        <th>Khách hàng</th>
                        <th>Số tiền</th>
                        <th>Trạng thái</th>
                        <th>Xem hóa đơn</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bills as $bill)
                        <tr>
                            <td>{{ date('M-y', strtotime($bill['from_date'])) }}</td>
                            <td>{{ date('d-M-y', strtotime($bill['from_date'])) }}</td>
                            <td>{{ date('d-M-y', strtotime($bill['from_date'])) }}</td>
                            <td>{{$bill['id']}}</td>
                            <td>{{$bill['customer']['name']}}</td>
                            <td>{{$bill['amount']}}₫</td>
                            <td>
                                @if($bill['status'] == 1)
                                    Đã trả
                                @else
                                    Chưa trả
                                @endif
                            </td>
                            <td>
                                <button class="bill btn btn-info" customer_id="{{$bill['customer']['id']}}" bill_id="{{$bill['id']}}">Xem hóa đơn</button>
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
<div class="modal fade" id="bill-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h4 class="modal-title" id="title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="bill-content"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(function () {
        $(document).on("click", ".bill",function(){
            customer_id = $(this).attr("customer_id")
            $("#bill-content").empty()
            var bill_id = $(this).attr("bill_id")
            $.ajax({
                url: '/get_bill_info',
                dataType: 'json',
                // type: "POST",
                data: {
                    'customer_id': customer_id,
                    'bill_id': bill_id
                },
                success: function(data) {
                    // console.log(data)
                    date = new Date().toJSON().slice(0,10).replace(/-/g,'/');
                    // $("#title").text(title)
                    $('#bill-content').append(`@include('bill.bill')`)
                    $(".no-print").empty()
                    $('#bill-modal').modal('show')
                }
            });
        });
    })
</script>
@endsection
