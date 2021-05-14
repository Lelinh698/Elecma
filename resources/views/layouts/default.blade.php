<!doctype html>
<html>
<head>
    @include('includes.head')
    @yield('css')
</head>
<body class="hold-transition layout-top-nav layout-navbar-fixed">
<div class="wrapper">

    @include('includes.header')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
        <h1 class="m-0 text-dark">@yield('content_header')</h1>
        </div>
        <!-- /.content-header -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-9">
                        @yield ('content')
                    </div>
                    <div class="col-lg-3">
                        @yield ('sidebar')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="main-footer bg-black color-palette">
        @include('includes.footer')
    </footer>

</div>

<!-- jQuery -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
<!-- SweetAlert -->
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>

<script type="text/javascript" src="{!! url('js/moment-with-locales.js') !!}"></script>
<script type="text/javascript" src="{!! url('js/jquery.dataTables.min.js') !!}"></script>
<script type="text/javascript" src="{!! url('js/dataTables.buttons.min.js') !!}"></script>
@yield('js')
</body>
</html>