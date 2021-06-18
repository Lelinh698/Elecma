@extends('admin.base')

@section('title','Trang chu')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Danh sách chi nhánh</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ajax-modal" id="create">
                            Thêm chi nhánh
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-hover text-nowrap" id="department">
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
                                    <a class="btn btn-info btn-sm btn-edit" department_id="{{$department['id']}}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                    </a>
                                    <a class="btn btn-danger btn-sm btn-delete" department_id="{{$department['id']}}">
                                        <i class="fas fa-trash">
                                        </i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $departments->links() }}
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

    <div class="modal fade" id="ajax-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="CrudModal">Thêm chi nhánh</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="form" name="form" class="form-horizontal">
                        <input type="hidden" name="department_id" id="department_id">
                        <div class="form-group">
                            <label for="name">Tên chi nhánh</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Tên chi nhánh" maxlength="255" required />
                        </div>
                        <div class="form-group">
                            <label for="address">Địa chỉ</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Địa chỉ" maxlength="255" required />
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
                    url: "/departments",
                    data: {
                        'name': $('#name').val(),
                        'address': $('#address').val()
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
                    url: "/departments/" + $('#department_id').val(),
                    data: {
                        'name': $('#name').val(),
                        'address': $('#address').val()
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
			$('#CrudModal').html("Thêm chi nhánh");
			$('#ajax-modal').modal('show');
		});

        $(document).on("click",".btn-edit",function(event){
            event.preventDefault();
            department_id = $(this).attr('department_id');

            $.ajax({
                type: "GET",
                url: "/departments/" + department_id + "/edit",
                success: function (data) {
                    $('#CrudModal').html("Sửa chi nhánh");
                    $('#btn-save').val("edit");
                    $('#ajax-modal').modal('show');
                    $('#department_id').val(department_id);
                    $("input[name='name']").val(data.name);
                    $("input[name='address']").val(data.address)
                }
            });
        });

		$(document).on("click",".btn-delete",function(){
            department_id = $(this).attr('department_id');
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
                        console.log(department_id)
                        $.ajax({
                            type: "DELETE",
                            contentType: 'application/json',
                            url: "/departments/" + department_id,
                            success: function (data) {
                                Toast.fire({
                                    icon: 'success',
                                    title: data['status']
                                })
                                setTimeout(function(){
                                    location.reload();
                                }, 3000);
                            },
                            error: function (err) {
                                Toast.fire({
                                    icon: 'error',
                                    title: "Không thể xóa chi nhánh có liên kết với nhân viên hoặc khách hàng!"
                                })
                            }
                        });
                    }
                })
        });
    })
</script>
@endsection
