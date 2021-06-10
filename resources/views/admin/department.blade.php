@extends('admin.base')

@section('title','Trang chu')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Danh sách chi nhánh</h3>
                </div>
                <div class="card-body">
                    <table class="table table-hover text-nowrap" id="bill-result">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Địa chỉ</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($departments as $department)
                            <tr>
                                <td>{{$department['id']}}</td>
                                <td>{{$department['name']}}</td>
                                <td>{{$department['address']}}</td>
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
