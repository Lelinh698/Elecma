$(document).ready(function() {

    // (function (){
    //     var close = window.swal.close;
    //     var previousWindowKeyDown = window.onkeydown;
    //     window.swal.close = function() {
    //       close();
    //       window.onkeydown = previousWindowKeyDown;
    //     };
    // })();

    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000
    })

    var i = 1;
    $("#btn-add").click(function(event) {
        event.preventDefault();
        if (i<5){
            i++;
            $("#criteria").append('<div class="row" id="criteria-row-'+ i + '"><div class="col-sm-5"><div class="form-group"><label class="col-sm-3 control-label">Tiêu chí</label><div class="col-sm-9"><input type="text" class="form-control" name="criteria_name[]" id="criteria_name" autocomplete="off"></div></div></div><div class="col-sm-5"><div class="form-group"><label class="col-sm-3 control-label">Trọng số</label><div class="col-sm-9"><input type="number" class="form-control" name="weight[]" id="weight" autocomplete="off" step="0.1" min="0" max="1"></div></div></div><div class="col-sm-2" style="text-align: center;"><button id="' + i +'" class="btn btn-remove btn-danger" type="button"><i class="fa fa-trash"></i></button></div></div>')
        }
    })

    $(document).on("click", ".btn-remove", function() {
        var button_id = $(this).attr("id");
        $("#criteria-row-" + button_id).remove();
        i--;
    })

    $("#btn-save").click(function(event) {
        event.preventDefault();
        
        if ($("input[name='criteria_name[]']").val() == '' || $('input[name="weight[]"]').val() == '')
        {
            Toast.fire({
                type: 'error',
                title: 'Hãy nhập đầy đủ các trường!'
            })
        }
        else
        {   
            var x = $("input[name='weight[]']")
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
                    data : $("#criteria").serialize(),
                    success: function(data){
                        console.log(data)
                        $("input[name='criteria_name[]']").val("");
                        $("input[name='weight[]']").val("");
                        $("#modal-lg").modal("hide");
                        Toast.fire({
                            type: 'success',
                            title: 'Đã thêm tiêu chí.'
                        })
                    },
                    error: function (request, textStatus, errorThrown) {
                        alert(request.responseText.message);
                        console.log("Loi vcl")
                    }
                });
            }
        }
    })
});