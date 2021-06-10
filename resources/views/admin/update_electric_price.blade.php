@extends('admin.base')

@section('title','Trang chu')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Cập nhật giá tiền điện</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="/admin/update_electric_price">
                        @method('POST')
                        @csrf
                        <div class="form-group row">
                        @foreach($price as $data)
                            <label for="price_{{$data['id']}}" class="col-sm-2">
                                Từ {{$data['from_number']}} tới {{$data['to_number']}}:
                            </label>
                            <input style="margin-bottom: 10px" type="text" class="form-control col-sm-2"
                                   name="price_{{$data['id']}}" value={{ $data['price'] }} />
                        @endforeach
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
@endsection
