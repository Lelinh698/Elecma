@extends('templates.master')

@section('title','Cập nhật chỉ số')

@section('css')


@section('content')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
{{--            <h1 class="display-3">Update information</h1>--}}

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
            <div class="card" id="update-number">
                <div class="card-header border-0">Cập nhật chỉ số</div>
                <div class="card-body">
                    <form class="form-horizontal" id="update-form">
                        <div class="form-group row">
                            <label for="customer" class="col-sm-2 control-label">Khách hàng</label>
                            <select id="customer" name="customer" class="select2 col-sm-10">
                            </select>
                        </div>
                        <div class="row form-group" id="previous-row">
                        </div>
                        <div class="form-group row">
                            <label for="initial-number" class="col-sm-2 control-label">Số điện đầu</label>
                            <input id="initial-number" name="initial-number" type="number" min="0" required class="col-sm-4">
                            <label for="final-number" class="col-sm-2 control-label">Số điện cuối</label>
                            <input id="final-number" name="final-number" type="number" min="0" required class="col-sm-4">
                        </div>
                        <div class="form-group row">
                            <label for="from_date" class="col-sm-2 control-label">Từ ngày</label>
                            <input id="from_date" name="from_date" type="date" required class="col-sm-4">
                            <label for="to_date" class="col-sm-2 control-label">Đến ngày</label>
                            <input id="to_date" name="to_date" type="date" required class="col-sm-4">
                        </div>
                        <button id="submit" type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="bill">

    </div>
@endsection

@section('js')
    <script src="{{ asset('js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({

            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/get_customer_list',
                dataType: 'json',
                success: function(data) {
                    $( "select[name='customer']").empty();
                    $.each(data, function(key, value) {
                        $("select[name='customer']").append(
                            '<option value="'+ key +'">'+ value['username'] +" - "+ value['name'] +'</option>'
                        );
                    });
                }
            });

            $( "select[name='customer']").on("change", function() {
                const  customer_id = $( "select[name='customer']").val()
                // console.log(customer_id)
                $.ajax({
                    url: '/get_latest_number',
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        "customer_id": customer_id
                    },
                    success: function(data) {
                        // console.log(data)
                        $("#previous-row").html(
                            "<label>Số điện tháng trước:</label>" + " " + data['number']
                        )
                    }
                });
            })

            $( "#submit" ).click(function (e) {
                e.preventDefault()
                $('#bill').empty()
                var customer_id = $('#customer').val();
                var initial_number = $('#initial-number').val()
                var final_number = $('#final-number').val()
                console.log(customer_id + " " + initial_number + " " + final_number)
                if (customer_id) {
                    $.ajax({
                        url: '/get_customer_info',
                        dataType: 'json',
                        // type: "POST",
                        data: {
                            'customer_id': customer_id,
                            'initial_number': initial_number,
                            'final_number': final_number,
                            'from_date': $('#from_date').val(),
                            'to_date': $('#to_date').val()
                        },
                        success: function(data) {
                            date = new Date().toJSON().slice(0,10).replace(/-/g,'/');
                            console.log(data['bill']['amount'])
                            $('#bill').append(`@include('bill.bill')`)
                            $('#confirm').click(function (e) {
                                e.preventDefault()

                                var customer_id = $('#customer').val();
                                var initial_number = $('#initial-number').val()
                                var final_number = $('#final-number').val()
                                $.ajax({
                                    url: '/bill',
                                    dataType: 'json',
                                    type: "POST",
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        'customer_id': customer_id,
                                        'initial_number': initial_number,
                                        'final_number': final_number,
                                        'from_date': $('#from_date').val(),
                                        'to_date': $('#to_date').val(),
                                        'amount': data['bill']['amount'],
                                        'price_per_number': data['bill']['price_per_number'],
                                        'status': 0
                                    },
                                    success: function(data) {
                                        alert('Success')
                                    }
                                });
                            })
                        }
                    });
                }
            });
        });
    </script>
@endsection
