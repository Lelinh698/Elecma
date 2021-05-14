 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-dark navbar-gray-dark">
    <div class="container">
      @auth('student')
      <a href="/student" class="navbar-brand">
      @endauth
      
      @auth('teacher')
      <a href="/teacher" class="navbar-brand">
      @endauth
        <img src="{{ asset('images/logo.jpg') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light"> Quản lý đồ án </span>
      </a>

      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          @auth('student')
          <a href="/student" class="nav-link">
          @endauth
          
          @auth('teacher')
          <a href="/teacher" class="nav-link">
          @endauth
          ĐỒ ÁN</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="/student/plan" class="nav-link">KẾ HOẠCH BỘ MÔN</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- User Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#"><i
              class="fas fa-user"></i></a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-header">@yield('username')</span>
            <div class="dropdown-divider"></div>
            <a href="/logout" class="dropdown-item">
              <i class="fas fa-sign-out-alt mr-2"></i> Đăng xuất
            </a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->