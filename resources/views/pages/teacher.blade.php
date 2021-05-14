@extends('layouts.default')

@section('username')
{{ $teacher_info->name }}
@stop

@section('content-header', 'Phân công đồ án')


@section('content')          
<div class="card">
    <div class="card-header">
        <h3 class = "card-title"> Đồ án do giảng viên quản lý </h3>
    </div>
    <div class="card-body">
        <table id="teacher_project" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Loại đồ án</th>
                    <th>Tên đề tài</th>
                </tr>
            </thead>
            <tbody>
            @foreach($doan as $key => $da)
            @if($da->type == '1')
                <tr>
                    <?php //Điền số thứ tự?>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $da->project_type_name }}</td>
                    <td><a href="/teacher/project/{{ $da->id }}">{{ $da->project_name }}</a></td>
                </tr>
            @endif
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class = "card-title"> Đồ án do bộ môn quản lý </h3>
    </div>
    <div class="card-body">
    <table id="teacher_project_2" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Loại đồ án</th>
                    <th>Tên đề tài</th>
                </tr>
            </thead>
            <tbody>
            @foreach($doan as $key => $da)
            @if($da->type == '2')
                <tr>
                    <?php //Điền số thứ tự?>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $da->project_type_name }}</td>
                    <td><a href="/teacher/project/{{ $da->id }}">{{ $da->project_name }}</a></td>
                </tr>
            @endif
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop

@section('sidebar')
    @include('includes.teacher_sidebar')
@stop