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
                            <label for="customer" class="col-sm-2 control-label">Customer</label>
                            <select id="customer" name="customer" class="select2 col-sm-10">
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="initial-number" class="col-sm-2 control-label">Initial number</label>
                            <input id="initial-number" name="initial-number" type="number" min="0" required class="col-sm-4">
                            <label for="final-number" class="col-sm-2 control-label">Final number</label>
                            <input id="final-number" name="final-number" type="number" min="0" required class="col-sm-4">
                        </div>
                        <button id="submit" type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="bill">

    </div>

{{--    <div class="modal fade" id="bill-modal" style="display: none;" aria-hidden="true">--}}
{{--        <div class="modal-dialog modal-lg">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <h4 class="modal-title" id="title"></h4>--}}
{{--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                        <span aria-hidden="true">×</span>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    --}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection

@section('js')
    <script src="{{ asset('js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({

            });

            $.ajax({
                url: '/get_customer_list',
                dataType: 'json',
                success: function(data) {
                    $( "select[name='customer']").empty();
                    $.each(data, function(key, value) {
                        $("select[name='customer']").append('<option value="'+ key +'">'+ value +'</option>');
                    });
                }
            });

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
                            'final_number': final_number
                        },
                        success: function(data) {
                            date = new Date().toJSON().slice(0,10).replace(/-/g,'/');
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
