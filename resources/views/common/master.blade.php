@php
    /* @var \App\Facades\Util $util */
    /* @var \App\Facades\Common $common */
@endphp
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="{{ config('session.lifetime') * 60 }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield("title")</title>
    <link href="//fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <script src="{{asset('js/jquery_3_2.min.js')}}"></script>
    <script src="//kit.fontawesome.com/aba9065474.js" crossorigin="anonymous"></script>
    @yield("css_loc")
    <link href="{{asset('css/front_master.css')}}" rel="stylesheet">
    @yield("header")
</head>
<body>
@yield("content")
@yield("footer")
</body>
</html>
