$(document).ready(function() {

    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000
    })

    var process_table = $('#process_mark').DataTable({
        searching: false,
        info: false,
        paging: false,
        lengthChange: false,
        columnDefs: [
            { targets: [1, 2],  width: "20%"},
        ],
    });

    var end_table = $('#end_mark').DataTable({
        searching: false,
        info: false,
        paging: false,
        lengthChange: false,
        columnDefs: [
            { targets: [1, 2],  width: "20%"},
        ]
    });

    $('#end_submit').click( function() {
        var data = end_table.$('input').serialize();
        alert(data)
        
        if ($("input[name='end_criteria[]']").val() == '' || $('input[name="end_weight[]"]').val() == '')
        {
            Toast.fire({
                type: 'error',
                title: 'Hãy nhập đầy đủ các trường!'
            })
        }
        else
        {   
            var x = $("input[name='end_weight[]']")
            // console.log(x[0].value)
            var sum = 0;
            for(i=0; i<x.length; i++) {
                sum += parseFloat(x[i].value)
                // console.log(sum)
            }
            if (sum != 1.0) {
                Toast.fire({
                    type: 'error',
                    title: 'Hãy nhập sao cho tổng trọng số bằng 1.0'
                })
            }
            else
            {
                $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "/ajax_criteria",
                    method: "POST",
                    dataType: "json",
                    data : {
                        'data': data,
                        'prid': $('#prid').val(),
                    },
                    success: function(data){
                        console.log(data)
                        // $("input[name='criteria_name[]']").val("");
                        // $("input[name='weight[]']").val("");
                        // $("#modal-lg").modal("hide");
                        Toast.fire({
                            type: 'success',
                            title: 'Đã cập nhật tiêu chí.'
                        })
                    },
                    error: function (request, textStatus, errorThrown) {
                        alert(request.responseText.message);
                        console.log("Loi vcl")
                    }
                });
            }
        }
        // alert(data)
        return false;
    } );

    $('#add_row').on( 'click', function () {
        end_table.row.add( [
            '<input class="form-control form-control-sm" type="text" name="end_criteria[]">',
            '<input class="form-control form-control-sm" type="number" min="0" max="1.0" step="0.1" name="end_weight[]">',
            '<input class="form-control form-control-sm" type="number" min ="0" max="10" name="end_mark[]">',
        ] ).draw( false );		
    } );
});