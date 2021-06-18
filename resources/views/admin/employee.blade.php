@extends('admin.base')

@section('title','Trang chu')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Danh sách nhân viên</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ajax-modal" id="create">
                            Thêm nhân viên
                        </button>
                    </div>
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
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($employees as $employee)
                            <tr>
                                <td>{{$employee['id']}}</td>
                                <td>{{$employee['username']}}</td>
                                <td>{{$employee['name']}}</td>
                                <td>{{$employee['email']}}</td>
                                <td>{{$employee['phone']}}</td>
                                <td>{{$employee['department']['name']}}</td>
                                <td class="project-actions text-right">
                                    <a class="btn btn-info btn-sm btn-edit" employee_id="{{$employee['id']}}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                    </a>
                                    <a class="btn btn-danger btn-sm btn-delete" employee_id="{{$employee['id']}}">
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
    <div class="modal fade" id="ajax-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="CrudModal">Thêm người dùng</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="form" name="form" class="form-horizontal">
                    <input type="hidden" name="employee_id" id="employee_id">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="username">Tên đăng nhập</label>
                                    <input type="text" class="form-control" id="username" name="username" required/>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="password">Mật khẩu</label>
                                    <input type="password" class="form-control" id="password" name="password" required/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Họ tên</label>
                                    <input type="text" class="form-control" id="name" name="name" required/>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="phone">Điện thoại</label>
                                    <input type="text" class="form-control" id="phone" name="phone" required />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="department">Chi nhánh</label>
                                    <select id="department" name="department" class="form-control">
                                        @foreach($departments as $department)
                                        <option value="{{$department->id}}">{{$department->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <button type="submit" id="btn-save" class="btn btn-primary" form="form">Lưu lại</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script type="text/javascript" src="{!! url('js/jquery.dataTables.min.js') !!}"></script>
<script>
    $(document).ready( function () {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
 
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000
        })

        $(document).on("click","#btn-save",function(e){
            e.preventDefault()
            if ($('#btn-save').val() == 'create') {
                $.ajax({
                    type: "POST",
                    url: "/employee",
                    data: {
                        'username': $('#username').val(),
                        'name': $('#name').val(),
                        'email': $('#email').val(),
                        'phone': $('#phone').val(),
                        'password': $('#password').val(),
                        'department_id': $('#department').val()
                    },
                    success: function (data) {
                        Toast.fire({
                            icon: 'success',
                            title: "Thêm thành công"
                        })
                        setTimeout(function(){
                            location.reload();
                        }, 3000);
                    },
                    error: function (err) {
                        if (err.status == 422) {
                            Toast.fire({
                                icon: 'error',
                                title: err.responseJSON.message
                            })
                        }
                    }
                });
            } 
            else if($('#btn-save').val() == 'edit')
            {
                console.log('edit')
                $.ajax({
                    type: "PUT",
                    url: "/employee/" + $('#employee_id').val(),
                    data: {
                        'username': $('#username').val(),
                        'name': $('#name').val(),
                        'email': $('#email').val(),
                        'phone': $('#phone').val(),
                        'password': $('#password').val(),
                        'department_id': $('#department').val()
                    },
                    success: function (data) {
                        Toast.fire({
                            icon: 'success',
                            title: "Cập nhật thành công"
                        })
                        setTimeout(function(){
                            location.reload();
                        }, 3000);
                    },
                    error: function (err) {
                        if (err.status == 422) {
                            Toast.fire({
                                icon: 'error',
                                title: err.responseJSON.message
                            })
                        }
                    }
                });
            }
        });

        $('#create').click(function () {
			$('#btn-save').val("create");
			$('#form').trigger("reset");
			$('#CrudModal').html("Thêm nhân viên");
			$('#ajax-modal').modal('show');
		});

        $(document).on("click",".btn-edit",function(event){
            event.preventDefault();
            employee_id = $(this).attr('employee_id');

            $.ajax({
                type: "GET",
                url: "/employee/" + employee_id + "/edit",
                success: function (data) {
                    $('#CrudModal').html("Sửa nhân viên");
                    $('#btn-save').val("edit");
                    $('#ajax-modal').modal('show');
                    $('#employee_id').val(employee_id);
                    $('#username').val(data.username)
                    $('#name').val(data.name)
                    $('#email').val(data.email)
                    $('#phone').val(data.phone)
                    $('#password').val(data.password)
                    $('#department').val(data.department_id)
                }
            });
        });

		$(document).on("click",".btn-delete",function(){
            employee_id = $(this).attr('employee_id');
            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa không?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Có',
                cancelButtonText: 'Không'
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log(employee_id)
                        $.ajax({
                            type: "DELETE",
                            contentType: 'application/json',
                            url: "/employee/" + employee_id,
                            success: function (data) {
                                Toast.fire({
                                    icon: 'success',
                                    title: data['status']
                                })
                                setTimeout(function(){
                                    location.reload();
                                }, 3000);
                            },
                            error: function (data) {
                                Toast.fire({
                                    icon: 'error',
                                    title: "Bị lỗi khi xóa nhân viên!"
                                })
                            }
                        });
                    }
                })
        });
    })
</script>
@endsection
