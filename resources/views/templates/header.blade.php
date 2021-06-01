<div class="header">
  <div class="row">
    <div class="col-sm-3">
        <img src="{{ asset('images/elecma.png') }}" alt="Elecma Logo" style="width: 150px; height: 150px;">
    </div>

    <div class="col-sm-7">
        <h3>HỆ THỐNG QUẢN LÝ KHÁCH HÀNG DÙNG ĐIỆN</h3>
        <div style="font-size: 15px;">
          TRƯỜNG ĐẠI HỌC BÁCH KHOA HÀ NỘI - VIỆN CÔNG NGHỆ THÔNG TIN VÀ TRUYỀN THÔNG
        </div>
        <span id="date_time"></span>
    </div>
    <div class="col-sm-2">
        <div class="text-muted">
        @auth('customer')
            <p class="text-md">Lien he: 0788399319</p>
            <p class="text-md">Xin chao: {{ auth('customer')->user()->username }}</p>
            <a href="/logout">Logout</a>
        @endauth
        @auth('employee')
            <p class="text-md">Lien he: 0788399319</p>
            <p class="text-md">Xin chao: {{ auth('employee')->user()->username }}</p>
            <a href="/logout">Logout</a>
        @endauth
        </div>
    </div>
  </div>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white">
        <div class="container">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                </li>
                @auth('customer')
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/customer" class="nav-link">Trang chủ</a>
                </li>
{{--                <li class="nav-item d-none d-sm-inline-block">--}}
{{--                    <a href="/bill/search" class="nav-link">Tra cứu hóa đơn</a>--}}
{{--                </li>--}}
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/customer/{{auth('customer')->id()}}/meter" class="nav-link">Tra cứu chỉ số điện</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('customer.edit',auth('customer')->id())}}" class="nav-link">Cập nhật thông tin khách hàng</a>
                </li>
                @endauth
                @auth('employee')
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/employee" class="nav-link">Trang chủ</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/update_electric_number" class="nav-link">Cập nhật số điện</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/abnormal/1" class="nav-link">Phát hiện bất thường</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="#" class="nav-link">Thống kê</a>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>
    <!-- /.navbar -->
</div>
