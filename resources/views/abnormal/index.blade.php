@extends('templates.master')

@section('title','Trang chu')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        Danh sách các hộ có số điện bất thường tháng {{$month}} năm {{$year}}
                    </h3>
                    <div class="card-tools">
                        <form class="form-inline ml-3">
                            <div class="input-group input-group-sm">
                                <select name="month" id="month" class="form-control float-right" title="Tháng">
                                    <option value="1">Tháng 1</option>
                                    <option value="2">Tháng 2</option>
                                    <option value="3">Tháng 3</option>
                                    <option value="4">Tháng 4</option>
                                    <option value="5">Tháng 5</option>
                                    <option value="6">Tháng 6</option>
                                    <option value="7">Tháng 7</option>
                                    <option value="8">Tháng 8</option>
                                    <option value="9">Tháng 9</option>
                                    <option value="10">Tháng 10</option>
                                    <option value="11">Tháng 11</option>
                                    <option value="12">Tháng 12</option>
                                </select>
                                <select name="year" id="year" class="form-control float-right" title="Năm">
                                    <option value="2021">2021</option>
                                    <option value="2020">2020</option>
                                    <option value="2019">2019</option>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Chủ hộ</th>
                            <th>Địa chỉ</th>
                            <th></th>
                        {{--                            <th>Mức</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($res as $item)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$item['name']}}</td>
                                <td>{{$item['address']}}</td>
                                <td><a href="/abnormal/{{$item['customer_id']}}/{{$year}}/{{$month}}" class="btn btn-info" role="button">xem chi tiết</a></td>
                                {{--                            <td>Mức {{$item->level}}</td>--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
{{--                    <a href="month" class="btn btn-info" style="margin-top: 30px;" role="button">Xem tất cả danh--}}
{{--                        sách</a>--}}
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('#search').click(function (e) {
            console.log($('#month').val())
            // var month = $("#month").val()
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: '/abnormal',
                data: {
                    'month': $('#month').val()
                },
                success: function (data) {
                    data = JSON.parse(data);
                    console.log(data)
                },
            })
        });
    </script>
@endsection
