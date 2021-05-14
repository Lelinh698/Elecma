<!DOCTYPE html>
<html lang="en" style="height: auto">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}" type="text/css">
{{--    <link href="{{ asset('css/bootstrap.min.css') }}" type="text/css" rel="stylesheet" />--}}
	<link href="{{ asset('css/dataTables.bootstrap.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/Chart.min.css') }}" type="text/css" rel="stylesheet" />
	<link href="{{ asset('css/style.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/select2.min.css') }}" type="text/css" rel="stylesheet" />

</head>
<body class="layout-top-nav">
    <div class="wrapper">
        <div class="container">
            @include('templates.header')
        </div>
        @section('sidebar')
        <div class="content-wrapper">
            <div class="content-header">
                @section('content-header')
            </div>
            <div class="content">
                <div class="container">
                    @section('content')
                    @show
                </div>
            </div>
        </div>
        <footer class="main-footer">
            @include('templates.footer')
        </footer>
    </div>

	<script type="text/javascript" src="{!! url('js/jquery.min.js') !!}"></script>
	<script type="text/javascript" src="{!! url('js/bootstrap.min.js') !!}"></script>
	<script type="text/javascript" src="{!! url('js/jquery.dataTables.min.js') !!}"></script>
	<script type="text/javascript" src="{!! url('js/dataTables.bootstrap.min.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/Chart.min.js') !!}"></script>
    <script type="text/javascript" src="{!! url('js/main.js') !!}"></script>
    <script type="text/javascript">window.onload = date_time('date_time');</script>
    @section('js')
    @show
</body>
</html>
