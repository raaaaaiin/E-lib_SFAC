@php
    /* @var \App\Facades\Util $util */
    /* @var \App\Facades\Common $common */
@endphp
@extends("front.master")
@section("content")
    <section class="common_holder">
        <div class="" style="background-image: url('{{asset('uploads/cover.png')}}',true);
            height: 164px;
            margin-bottom: 2%;"></div>
        <div class="container border">
            <div class="row mb-10">
                <nav aria-label="breadcrumb" class="w-100">
                    <ol class="breadcrumb" style="background-color: #eaeaea;">
                        <li class="breadcrumb-item"><a
                                href="{{config("app.APP_URL")}}">{{__("common.home")}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <a href="{{config("app.APP_URL")}}/{{$slug}}">{{htmlspecialchars_decode(strip_tags($title))}}</a>
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="row justify-content-center">
                <div>{!! $title!!}</div>
                <div class="p-5">{!! $desc !!}</div>
            </div>
        </div>
    </section>
@endsection
@section("css_loc")
    <link rel="stylesheet" href="{{asset('css/basic.css')}}">
@endsection
