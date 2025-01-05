<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <title>{{ config('Dashboard', 'Dashboard') }}</title>

    <link rel="icon" href="{{ asset('assests/photos/BrandLogo.ico') }}" type="SSO ICON">

    <!-- Include AdminLTE CSS -->
    <link href="{{ asset('../dist/css/adminlte.min.css') }}" rel="stylesheet">
    <link href="{{ asset('../plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">


    <!-- Use Vite for JS and CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .custom-sidebar-bg {
            background-image: url();
            background-size: cover;
            background-position: center;
        }

        .content-wrapper {
            position: relative;
        }

        .content-wrapper::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url();
            background-size: cover;
            background-position: center;
            opacity: 0.2;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        @include('admin.layouts.navbar')

        <!-- Main Sidebar -->
        @include('admin.layouts.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Your page content will be yielded here -->
                    @yield('content')
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Footer -->


    </div>
    <!-- ./wrapper -->

    <!-- Include AdminLTE JS -->
    <script src="{{ asset('../dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('../plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('../dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('../plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Add extra scripts in specific views -->
</body>

</html>