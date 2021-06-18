@extends('templates.master')

@section('title','Cập nhật tài khoản')

@section('content')
<div class="row">
    <div class="col-sm-8 offset-sm-2">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <br />
        @endif
        <div class="card">
            <div class="card-header border-0">Cập nhật thông tin</div>
            <div class="card-body">
                <form method="post" action="{{ route('customer.update', $customer->id) }}">
                    @method('PATCH')
                    @csrf
                    <div class="form-group">
                        <label for="username">Tên đăng nhập</label>
                        <input type="text" class="form-control" name="username" value="{{ $customer->username }}" />
                    </div>
                    <div class="form-group">
                        <label for="name">Họ tên</label>
                        <input type="text" class="form-control" name="name" value="{{ $customer->name }}" />
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" value="{{ $customer->email }}" />
                    </div>
                    <div class="form-group">
                        <label for="phone">Điện thoại</label>
                        <input type="text" class="form-control" name="phone" value="{{ $customer->phone }}" />
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ</label>
                        <input type="text" class="form-control" name="address" value="{{ $customer->address }}" />
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
