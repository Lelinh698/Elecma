@extends('templates.master')

@section('title','Trang chu')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title">Department information</h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-6">Deaprtment name</dt>
                    <dd class="col-sm-6">{{ $department->name }}</dd>
                    <dt class="col-sm-6">Adress</dt>
                    <dd class="col-sm-6">{{ $department->address }}</dd>
                </dl>
            </div>
            <!-- /.card-body -->
        </div>
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title">Customer information</h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-6">Username</dt>
                    <dd class="col-sm-6">{{ $customer->username }}</dd>
                    <dt class="col-sm-6">Email</dt>
                    <dd class="col-sm-6">{{ $customer->email }}</dd>
                    <dt class="col-sm-6">Phone</dt>
                    <dd class="col-sm-6">{{ $customer->phone }}</dd>
                    <dt class="col-sm-6">Address</dt>
                    <dd class="col-sm-6">{{ $customer->address }}</dd>
                </dl>
            </div>
            <!-- /.card-body -->
        </div>
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title">Bill information</h3>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="month">Tháng</label>
                                <select id="month" name="month" class="form-control">
                                    <option value="1">Tháng 1</option>
                                    <option value="2">Tháng 2</option>
                                    <option value="3">Tháng 3</option>
                                    <option value="4">Tháng 4</option>
                                    <option value="5">Tháng 5</option>
                                    <option value="6">Tháng 6</option>
                                    <option value="7">Tháng 7</option>
                                    <option value="8">Tháng 8</option>
                                    <option value="9">Tháng 9</option>
                                    <option value="10">Tháng 10</option>
                                    <option value="11">Tháng 11</option>
                                    <option value="12">Tháng 12</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="year">Năm</label>
                                <select id="year" name="year" class="form-control">
                                    <option>2021</option>
                                    <option>2020</option>
                                    <option>2019</option>
                                    <option>2018</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button id="search" type="submit" class="btn btn-primary">Tìm kiếm</button>
                </form>
                <table class="table table-hover text-nowrap" id="bill-result">
                    <thead>
                        <tr>
                            <th>Thời gian</th>
                            <th>Từ ngày</th>
                            <th>Tới ngày</th>
                            <th>Số hóa đơn</th>
                            <th>Số tiền</th>
                            <th>Trạng thái</th>
                            <th>Xem hóa đơn</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bills as $bill)
                        <tr>
                            <td>{{$bill['time']}}</td>
                            <td>{{$bill['from_date']}}</td>
                            <td>{{$bill['to_date']}}</td>
                            <td id="bill-id">{{$bill['id']}}</td>
                            <td>{{$bill['amount']}}₫</td>
                            <td>{{$bill['status']}}</td>
                            <td>
                                <button class="bill btn btn-info" bill_id="{{$bill['id']}}">Xem hoa don</button>
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
            $('#search').click(function (e) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                e.preventDefault();
                $.ajax({
                    type: "GET",
                    url: '/customer/{{auth('customer')->id()}}/bill/search',
                    data: {
                        'customer_id': {{auth('customer')->id()}},
                        'month': $('#month').val(),
                        'year': $('#year').val()
                    },
                    success: function (data) {
                        data = JSON.parse(data);
                        console.log(data)
                        if (data != null) {
                            $('#bill-result tbody').html(
                                `<tr>
                            <td>${data['time']}</td>
                            <td>${data['from_date']}</td>
                            <td>${data['to_date']}</td>
                            <td>${data['id']}</td>
                            <td>${data['amount']}</td>
                            <td>${data['status']}</td>
                            <td>
                                <button class="bill btn btn-info" bill_id="${data['id']}">Xem hoa don</button>
                            </td>
                            </tr>`
                            )
                        }
                        else {
                            $('#bill-result tbody').html(
                                'Không tìm thấy dữ liệu!'
                            )
                        }
                    },
                })
            });

            $(document).on("click", ".bill",function(){
                $("#bill-content").empty()
                var customer_id = "{{$customer['id']}}";
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
                        if (data['bill']['status'] == 1) {
                            $(".no-print").empty()
                            $("#payment-method").remove()
                            $("#bill-list").removeClass()
                            $("#bill-list").addClass("col-12")
                        }
                        $('#bill-modal').modal('show')
                        $("#confirm").click(function () {
                            $.ajax({
                                type: "POST",
                                url: 'bill/pay',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    'amount': data['bill']['amount']
                                },
                                success: function (d) {
                                    console.log(d)
                                    document.open()
                                    document.write(d['html'])
                                    document.close()
                                }
                            });
                        });
                    }
                });
            });

            $('#bill-content').on("click", "#vnpay",function() {
                $("#payment").empty()
                $("#payment").append(`@include('bill.vnpay_form')`)
            })
        })

    </script>
@endsection
