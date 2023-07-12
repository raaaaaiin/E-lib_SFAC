@php
    /* @var \App\Facades\Util $util */
    /* @var \App\Facades\Common $common */
@endphp
    <!doctype html>
<html class="no-js" lang="en">

@php
    $meta_title = $common::getSiteSettings("index_meta_title",config("app.APP_URL"));
    $meta_desc = $common::getSiteSettings("index_meta_desc");
    $fav_icon = $common::getSiteSettings("web_ico_file");
    $google_analytics = $common::getSiteSettings("google_analytics");
    $google_verification = $common::getSiteSettings("google_site_verification");
@endphp
<head>
    <meta charset="utf-8">
    <title>Elib STI</title>
    @if(isset($cust_title) && !blank($cust_title))
        <title>{{$cust_title}}</title>
    @endif
    @if(!empty($google_verification))
        <meta name="google-site-verification" content="{{$google_verification}}"/>
    @endif
    @if(!empty($google_analytics))
        {!! $google_analytics !!}
    @endif

    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!--====== Magnific Popup CSS ======-->

    <!--====== Slick CSS ======-->
    <link rel="stylesheet" href="{{asset('front/css/slick.css')}}">

    <!--====== Line Icons CSS ======-->
    <!--====== Bootstrap CSS ======-->
    <link rel="stylesheet" href="{{asset('front/css/bootstrap.min.css')}}">

    <!--====== Default CSS ======-->

    <!--====== Style CSS ======-->
    <link rel="stylesheet" href="{{asset('front/css/style.css')}}">
    @yield("css_loc")
    <link href="{{asset('css/front_master.css')}}" rel="stylesheet">
    @yield("header")
    @yield("css_loc")
    <style>

        @php
            $primary_color  = $util::fallBack($common::getSiteSettings("front_primary"),"#de3b69");
            $secondary_color  = $util::fallBack($common::getSiteSettings("front_secondary"),"#FF9F16");
            $logo_css  = $util::fallBack($common::getSiteSettings("org_logo_css"),"width:140px;");
        @endphp

        .carousel-item {
            background-color: #000000;
        }

        .back-to-top, .team-content::before, .portfolio-menu ul li::before {
            background-color: {{$secondary_color}};
        }

        .single-features .features-title-icon .features-icon i {
            color: {{$secondary_color}};
        }

        .pricing-style, .team-style-eleven {
            background: linear-gradient({{$primary_color}} 0%, {{$secondary_color}} 100%);
        }

        .btn {
            outline: 0 !important;
        }

        .light-rounded-buttons .light-rounded-two, .navbar-area.sticky .navbar .navbar-btn li a.solid,
        .btn_preview, .btn_open_link, .btn_subscribe, .btn_preview:hover, .btn_open_link:hover, .btn_subscribe:hover {
            background-color: {{$secondary_color}};
            border-color: {{$secondary_color}};
        }

        .form-input .input-items.default input:focus, .form-input .input-items.default textarea:focus {
            border-color: {{$secondary_color}}




        }

        .logo_img {
        {{$logo_css}}

        }

    </style>
</head>

<body>
<!--[if IE]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade
    your browser to google/firefox </a> to improve your experience and security.</p>
<![endif]-->


<!--====== NAVBAR TWO PART START ======-->

{{--@include("front.nav")--}}
@include("back.frontnav")
@yield("content")
<!--====== BACK TOP TOP PART START ======-->

<a href="#" class="back-to-top"><i class="lni lni-chevron-up"></i></a>

<!--====== BACK TOP TOP PART ENDS ======-->


<!--====== Jquery js ======-->
@include("front.footer")


    <script src="{{asset('front/js/isotope.js')}}"></script>
<script src="{{asset('front/js/jquery.min.js')}}"></script>
<script src="{{asset('js/jquery-ui.js')}}"></script>
<script src="{{asset('front/js/jquery.magnific-popup.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/jquery-confirm.min.css')}}">
<script src="{{asset('js/jquery-confirm.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">



<!--====== Bootstrap js ======-->
<script src="{{asset('front/js/bootstrap.min.js')}}"></script>



<!--====== Scrolling Nav js ======-->

<script src="{{asset('js/vue.js')}}"></script>
<script src="{{asset('front/js/slick.min.js')}}"></script>
<script src="{{asset('front/js/imagesloaded.pkgd.min.js')}}"></script>
<script src="{{asset('front/js/isotope.pkgd.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('plugins/sweetalert2/sweetalert2.min.css')}}">
<script type="text/javascript" src="{{asset('plugins/sweetalert2/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('js/default.js')}}"></script>
<script src="{{asset('front/js/main.js')}}"></script>
<script src="{{asset('front/js/html2canvas.min.js')}}"></script>

   <script src="{{asset('front/js/custom.js')}}"></script>
    <script src="{{asset('front/js/owl.js')}}"></script>

@livewireScripts

@include("back.common.spinner")
@yield("js_loc")
</body>
</html>

