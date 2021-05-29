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
            From
            <address>
                <strong>${data['department']['name']}</strong><br>
                ${data['department']['address']}<br>
                Phone: (804) 123-5432<br>
                Email: info@almasaeedstudio.com
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            To
            <address>
                <strong>${data['customer']['name']}</strong><br>
                ${data['customer']['address']}<br>
                Phone: ${data['customer']['phone']}<br>
                Email: ${data['customer']['email']}
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <b>Bill ID #007612</b><br>
            <br>
            <b>Payment Due:</b> 2/22/2014<br>
            <b>Account:</b> ${data['customer']['username']}
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <div class="row">
{{--    @auth('customer')--}}
{{--        <div class="col-6" id="payment-method">--}}
{{--            <p class="lead">Payment Methods:</p>--}}
{{--            <img id="visa" src="{{ asset('images/credit/visa.png') }}" alt="Visa">--}}
{{--            <img src="{{ asset('images/credit/mastercard.png') }}" alt="Mastercard">--}}
{{--            <img src="{{ asset('images/credit/american-express.png') }}" alt="American Express">--}}
{{--            <img src="{{ asset('images/credit/paypal2.png') }}" alt="Paypal">--}}
{{--            <img id="vnpay" src="{{ asset('images/credit/vnpay2.jpg') }}" alt="Vnpay">--}}
{{--            <div id="payment" style="margin-top: 2px;">--}}

{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-6">--}}
{{--    @endauth--}}
{{--    @auth('employee')--}}
    <div class="col-12">
{{--    @endauth--}}
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr>
                        <th style="width:50%">Initial number:</th>
                        <td>${data['bill']['initial_number']}</td>
                    </tr>
                    <tr>
                        <th style="width:50%">Final number:</th>
                        <td>${data['bill']['final_number']}</td>
                    </tr>
                    <tr>
                        <th>Price per number:</th>
                        <td>${data['bill']['price_per_number']}</td>
                    </tr>
                    <tr>
                        <th>Total:</th>
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
