<div class="invoice p-3 mb-3">
    <!-- title row -->
    <div class="row">
        <div class="col-12">
            <h4>
                <i class="fas fa-globe"></i> ${data['department']['name']}
                <small class="float-right">Date: ${date}</small>
            </h4>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            Từ
            <address>
                <strong>${data['department']['name']}</strong><br>
                <b>Địa chỉ:</b> ${data['department']['address']}<br>
{{--                Phone: (804) 123-5432<br>--}}
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            Tới
            <address>
                <strong>${data['customer']['name']}</strong><br>
                ${data['customer']['address']}<br>
                <b>Số điện thoại:</b> ${data['customer']['phone']}<br>
                <b>Email:</b> ${data['customer']['email']}
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <!-- <b>Bill ID ${data['bill']['id']}</b><br> -->
            <br>
{{--            <b>Payment Due:</b> 2/22/2014<br>--}}
            <b>Account:</b> ${data['customer']['username']}
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr>
                        <th style="width:50%">Chỉ số đầu:</th>
                        <td>${data['bill']['initial_number']}</td>
                    </tr>
                    <tr>
                        <th style="width:50%">Chỉ số cuối:</th>
                        <td>${data['bill']['final_number']}</td>
                    </tr>
                    <tr>
                        <th style="width:50%">Từ ngày:</th>
                        <td>${data['bill']['from_date']}</td>
                    </tr>
                    <tr>
                        <th style="width:50%">Đến ngày:</th>
                        <td>${data['bill']['to_date']}</td>
                    </tr>
                    <tr>
                        <th>Giá tiền mỗi số:</th>
                        <td>${data['bill']['price_per_number']}₫</td>
                    </tr>
                    <tr>
                        <th>Tổng tiền:</th>
                        <td>${data['bill']['amount']}₫</td>
                    </tr>
                    </tbody></table>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- this row will not appear when printing -->
    <div class="row no-print">
        <div class="col-12">
            <button type="button" class="btn btn-primary float-right" id="confirm">
                @auth('employee')
                <i class="fas fa-check"></i> Confirm
                @endauth
                @auth('customer')
                <i class="fas fa-receipt"></i> Pay
                @endauth
            </button>
        </div>
    </div>
</div>
