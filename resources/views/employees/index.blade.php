@extends('templates.master')

@section('title','Trang chu')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
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
            <div class="card-header">
                <h3 class="card-title">Employee information</h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-6">Username</dt>
                    <dd class="col-sm-6">{{ $employee->username }}</dd>
                    <dt class="col-sm-6">Email</dt>
                    <dd class="col-sm-6">{{ $employee->email }}</dd>
                    <dt class="col-sm-6">Phone</dt>
                    <dd class="col-sm-6">{{ $employee->phone }}</dd>
                </dl>
            </div>
            <!-- /.card-body -->
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Bill information</h3>
            </div>
            <div class="card-body">
                <form method="post" action="/bill/search">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="month">Tháng</label>
                                <select id="month" name="month" class="form-control">
                                    <option>Tháng 1</option>
                                    <option>Tháng 2</option>
                                    <option>Tháng 3</option>
                                    <option>Tháng 4</option>
                                    <option>Tháng 5</option>
                                    <option>Tháng 6</option>
                                    <option>Tháng 7</option>
                                    <option>Tháng 8</option>
                                    <option>Tháng 9</option>
                                    <option>Tháng 10</option>
                                    <option>Tháng 11</option>
                                    <option>Tháng 12</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="year">Năm</label>
                                <select id="month" name="year" class="form-control">
                                    <option>2010</option>
                                    <option>2011</option>
                                    <option>2012</option>
                                    <option>2013</option>
                                    <option>2014</option>
                                    <option>2015</option>
                                    <option>2016</option>
                                    <option>2017</option>
                                    <option>2018</option>
                                    <option>2019</option>
                                    <option>2020</option>
                                    <option>2021</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button id="search" type="submit" class="btn btn-primary">Tìm kiếm</button>
                </form>
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
                            <td>{{$bill['time']}}</td>
                            <td>{{$bill['from_date']}}</td>
                            <td>{{$bill['to_date']}}</td>
                            <td>{{$bill['id']}}</td>
                            <td>{{$bill['customer']}}</td>
                            <td>{{$bill['amount']}}</td>
                            <td>{{$bill['status']}}</td>
                            <td><a href="/bill">Xem hoa don</a></td>
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
                },
            })
        });
    })
</script>
@endsection
