@extends('templates.master')

@section('title','Cap nhat tai khoan')

@section('content')
<div class="row">
    <div class="col-sm-8 offset-sm-2">
        <h1 class="display-3">Update information</h1>

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
            <div class="card-header">Update information</div>
            <div class="card-body">
                <form method="post" action="{{ route('employee.update', $employee->id) }}">
                    @method('PATCH') 
                    @csrf
                    <div class="form-group">

                        <label for="username">Userame:</label>
                        <input type="text" class="form-control" name="username" value={{ $employee->username }} />
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control" name="email" value={{ $employee->email }} />
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" class="form-control" name="phone" value={{ $employee->phone }} />
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input type="text" class="form-control" name="address" value={{ $employee->address }} />
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection