@extends('templates.master')

@section('title','Trang chu')

@section('content')
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
                        @foreach($customers as $customer)
                            <tr>
                                <td>{{$customer['id']}}</td>
                                <td>{{$customer['username']}}</td>
                                <td>{{$customer['name']}}</td>
                                <td>{{$customer['email']}}</td>
                                <td>{{$customer['phone']}}₫</td>
                                <td>{{$customer['address']}}</td>
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
