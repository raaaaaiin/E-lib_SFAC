@php
    /* @var \App\Facades\Util $util */
    /* @var \App\Facades\Common $common */
@endphp
@extends("back.common.master")
@section("page_name") {{__("common.dashboard")}} @endsection
@section("content")

<script src="{{asset('js/jquery-1.12.4.js')}}"></script>

    @livewire("newsfeed")


    

@endsection
@section("js_loc")
<script src="{{asset('front/js/slick.min.js')}}"></script>
<script src="{{asset('front/js/jquery.magnific-popup.min.js')}}"></script>

<script src="{{asset('front/js/imagesloaded.pkgd.min.js')}}"></script>
<script src="{{asset('front/js/isotope.pkgd.min.js')}}"></script>
@endsection

@section("css_loc")
    <link rel="stylesheet" href="{{URL::asset('css/newsfeed.css') }}" />
@endsection

