@extends('admin.base')

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
                            <th>Chi nhánh</th>
{{--                            <th style="width: 20%;">Địa chỉ</th>--}}
                            <th></th>
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
                                <td>{{$customer['department']['name']}}</td>
{{--                                <td>{{$customer['address']}}</td>--}}
                                <td class="project-actions text-right">
                                    <a class="btn btn-info btn-sm" href="#">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                    </a>
                                    <a class="btn btn-danger btn-sm" href="#">
                                        <i class="fas fa-trash">
                                        </i>
                                    </a>
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
