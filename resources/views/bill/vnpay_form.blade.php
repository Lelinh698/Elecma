<form class="form">
    <input type="hidden" name="order_type" value="billpayment"/>
    <div class="form-group">
        <label for="amount">Amount</label>
        <input class="form-control" id="amount"
                name="amount" type="number" value="10000"/>
    </div>
    <div class="form-group">
        <label for="order_desc">Description</label>
        <textarea class="form-control" cols="20" id="order_desc" name="order_desc" rows="2">Noi dung thanh toan</textarea>
    </div>
    <div class="form-group">
        <label for="bank_code">Bank</label>
        <select name="bank_code" id="bank_code" class="form-control">
            <option value="">Không chọn</option>
            <option value="NCB"> Ngan hang NCB</option>
            <option value="AGRIBANK"> Ngan hang Agribank</option>
            <option value="SCB"> Ngan hang SCB</option>
            <option value="SACOMBANK">Ngan hang SacomBank</option>
            <option value="EXIMBANK"> Ngan hang EximBank</option>
            <option value="MSBANK"> Ngan hang MSBANK</option>
            <option value="NAMABANK"> Ngan hang NamABank</option>
            <option value="VNMART"> Vi dien tu VnMart</option>
            <option value="VIETINBANK">Ngan hang Vietinbank</option>
            <option value="VIETCOMBANK"> Ngan hang VCB</option>
            <option value="HDBANK">Ngan hang HDBank</option>
            <option value="DONGABANK"> Ngan hang Dong A</option>
            <option value="TPBANK"> Ngân hàng TPBank</option>
            <option value="OJB"> Ngân hàng OceanBank</option>
            <option value="BIDV"> Ngân hàng BIDV</option>
            <option value="TECHCOMBANK"> Ngân hàng Techcombank</option>
            <option value="VPBANK"> Ngan hang VPBank</option>
            <option value="MBBANK"> Ngan hang MBBank</option>
            <option value="ACB"> Ngan hang ACB</option>
            <option value="OCB"> Ngan hang OCB</option>
            <option value="IVB"> Ngan hang IVB</option>
            <option value="VISA"> Thanh toan qua VISA/MASTER</option>
        </select>
    </div>
    <div class="form-group">
        <label for="language">Language</label>
        <select name="language" id="language" class="form-control">
            <option value="vn">Tiếng Việt</option>
            <option value="en">English</option>
        </select>
    </div>
</form>
