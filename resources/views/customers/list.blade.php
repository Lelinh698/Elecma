@extends('templates.master')

@section('title','Danh sách đồ án')

@section('content')

    {{--    @include('student.studentMenu')--}}

    <?php //Hiển thị thông báo thành công?>
    <div class="page-header"><h4>Danh sách đồ án</h4></div>

    @if ( Session::has('success') )
        <div class="alert alert-success alert-dismissible" role="alert">
            <strong>{{ Session::get('success') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
        </div>
    @endif

    <?php //Hiển thị thông báo lỗi?>
    @if ( Session::has('error') )
        <div class="alert alert-danger alert-dismissible" role="alert">
            <strong>{{ Session::get('error') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
        </div>
    @endif

    <?php //Hiển thị danh sách học sinh?>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="table-responsive">
                <table id="DataList" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Adress</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php //Khởi tạo vòng lập foreach lấy giá vào bảng?>
                    @foreach($customers as $key => $customer)
                        <tr>
                            <?php //Điền số thứ tự?>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $customer->username }}</td>
                            <td><a href="/student/student/{{ $customer->id }}">{{ $customer->email }}</a></td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->address }}</td>
                        </tr>
                        <?php //Kết thúc vòng lập foreach?>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
