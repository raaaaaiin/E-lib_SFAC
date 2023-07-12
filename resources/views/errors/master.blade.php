<html xmlns="http://www.w3.org/1999/xhtml">
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
        body {
    height: 100%;
    width: 100%;
    margin: 0px;
    background: white!important;
}
    </style>
    <link href="//fonts.googleapis.com/css?family=Righteous&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/error.css')}}">
</head>
<body>
@include("back.frontnav")
@yield("content")

@yield("content")



</body>
</html>

