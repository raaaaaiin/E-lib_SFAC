@php
    /* @var \App\Facades\Util $util */
    /* @var \App\Facades\Common $common */
@endphp
    <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{isset($common) ? $common::getOrgName() : config("app.APP_NAME")}} | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css')}}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('css/adminlte.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"/>
    <style>
        .callout {
            border-radius: .5rem;
            /* box-shadow: 0 1px 3px rgb(0 0 0 / 12%), 0 1px 2px rgb(0 0 0 / 24%); */
            background-color: #fff;
            border-left: 5px solid #e9ecef;
            margin-bottom: 1rem;
            padding: 0.5rem;
        }

        .closeCallout {
            outline: 0 !important;
        }
        .b-lr-1{
        border-left: 1px solid lightgray;
        border-right: 1px solid lightgray;}
    </style>
    <script src="{{asset('front/js/vendor/jquery-1.12.4.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('body').on('click', 'button.closeCallout', function () {
                $(this).parent().parent().remove();
            });
        });

    </script>
</head>
<body
    class="hold-transition @if(request()->is('login') or request()->is('password/reset'))login-page @endif @if(request()->is('register')) register-page @endif" style="background-color:rgb(113 2 2);height: 75vh;">
<div
    class="@if(request()->is('login') or request()->is('password/reset') )login-box @endif @if(request()->is('register')) register-box @endif">
    <div class="login-logo @if(request()->is('register')) register-logo @endif">
        <a class="navbar-brand" href="{{config("app.APP_URL")}}" style="padding:0px;width:300px;">
                        @if(!empty($common::getSiteSettings('org_logo')))
                            <img class="logo_img"
                                 src="{{asset("uploads/".$common::getSiteSettings('org_logo'))}}"
                                 alt="{{$common::getSiteSettings("org_name")}}"
                                 style="padding:0px;width:300px;">
                        @else
                            <img class="logo_img" href="{{config("app.APP_URL")}}"
                                 src="{{asset("uploads/".config("app.DEFAULT_LOGO"))}}"
                                 alt="{{$common::getSiteSettings("org_name",config("app.APP_NAME"))}}">
                        @endif
                    </a>
        <!--<a href="#">{{isset($common) ? $common::getOrgName() : config("app.APP_NAME")}}</a>-->
    </div>
    <!-- /.login-logo -->
    @yield("content")
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('js/adminlte.min.js')}}"></script>

</body>
</html>
