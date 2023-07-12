@php
    /* @var \App\Facades\Util $util */
    /* @var \App\Facades\Common $common */
@endphp
    <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{Str::title($common::getSiteSettings("admin_page_name"))}} | {{__("common.dashboard")}}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('css/adminlte.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <link href="{{asset('css/easy-autocomplete.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/backend.css')}}" rel="stylesheet">

    @livewireStyles
    @yield("css_loc")

</head>
<body class="hold-transition sidebar-mini">

<!-- Site wrapper -->
<div class="wrapper">
{{--@include("back.common.nav")--}}
{{--@include("livewire.backnav")--}}
@include("back.backnav")
@yield("upper")

<!-- Main Sidebar Container -->
<!--Original sidebar not touched coud be revert just remove include and yield side -->
{{--@include("back.common.sidebar")--}}
@include("back.nsidebar")
@yield("side")
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="min-height: 311px;">
        <!-- Content Header (Page header) -->
        <br class="hidebrtop">
        <section class="content">
            @yield("content")
        </section>
    </div>
    <!-- /.content-wrapper -->

@include("back.common.footer")

<!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('js/jquery-1.12.4.js')}}"></script>
<script src="{{asset('js/jquery-ui.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('plugins/sweetalert2/sweetalert2.min.css')}}">
<script type="text/javascript" src="{{asset('plugins/sweetalert2/sweetalert2.all.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/jquery-confirm.min.css')}}">
<script src="{{asset('js/jquery-confirm.min.js')}}"></script>
<script src="{{asset('js/vue.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->

<script src="{{asset('js/demo.js')}}"></script>
<script src="{{asset('js/default.js')}}"></script>

<script src="{{asset('front/js/slick.min.js')}}"></script>
<script src="{{asset('front/js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('front/js/imagesloaded.pkgd.min.js')}}"></script>
<script src="{{asset('front/js/isotope.pkgd.min.js')}}"></script>

<script src="{{asset('front/js/main.js')}}"></script>
@livewireScripts
@yield("js_loc")
</body>
</html>
