<!DOCTYPE html>
<html lang="en">
<head>
    <title>$title ?? __("subscriber.thanks_subscribing")</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="{{asset('css/footer.css')}}">

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
    <link href="{{asset('css/front_master.css')}}" rel="stylesheet">

    <style>

        @php
            $primary_color  = $util::fallBack($common::getSiteSettings("front_primary"),"#de3b69");
            $secondary_color  = $util::fallBack($common::getSiteSettings("front_secondary"),"#FF9F16");
            $logo_css  = $util::fallBack($common::getSiteSettings("org_logo_css"),"width:140px;");
        @endphp
        /*===========================
      01.COMMON css
===========================*/

@import url("https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800");
body {
    font-family: "Poppins", sans-serif;
    font-weight: normal;
    font-style: normal;
    color: #121212;
}

* {
    margin: 0;
    padding: 0;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

img {
    max-width: 100%;
}

a:focus,
input:focus,
textarea:focus,
button:focus {
    text-decoration: none;
    outline: none;
}

a:focus,
a:hover {
    text-decoration: none;
}

i,
span,
a {
    display: inline-block;
}

h1,
h2,
h3,
h4,
h5,
h6 {
    font-family: "Poppins", sans-serif;
    font-weight: 600;
    color: #121212;
    margin: 0px;
}

h1 {
    font-size: 48px;
}

h2 {
    font-size: 36px;
}

h3 {
    font-size: 28px;
}

h4 {
    font-size: 22px;
}

h5 {
    font-size: 18px;
}

h6 {
    font-size: 16px;
}

ul,
ol {
    margin: 0px;
    padding: 0px;
    list-style-type: none;
}

p {
    font-size: 16px;
    font-weight: 400;
    line-height: 24px;
    color: #121212;
    margin: 0px;
}

.bg_cover {
    background-position: center center;
    background-size: cover;
    background-repeat: no-repeat;
    width: 100%;
    height: 100%;
}


/*===== All Slick Slide Outline Style =====*/

.slick-slide {
    outline: 0;
}


/*===== All Section Title Style =====*/

.section-title .title {
    font-size: 44px;
    font-weight: 600;
    color: #121212;
    line-height: 55px;
}

@media (max-width: 767px) {
    .section-title .title {
        font-size: 30px;
        line-height: 35px;
    }
}

.section-title .text {
    font-size: 16px;
    line-height: 24px;
    color: #6c6c6c;
    margin-top: 24px;
}


/*===== All Preloader Style =====*/

.preloader {
    /* Body Overlay */
    position: fixed;
    top: 0;
    left: 0;
    display: table;
    height: 100%;
    width: 100%;
    /* Change Background Color */
    background: #fff;
    z-index: 99999;
}

.preloader .loader {
    display: table-cell;
    vertical-align: middle;
    text-align: center;
}

.preloader .loader .ytp-spinner {
    position: absolute;
    left: 50%;
    top: 50%;
    width: 64px;
    margin-left: -32px;
    z-index: 18;
    pointer-events: none;
}

.preloader .loader .ytp-spinner .ytp-spinner-container {
    pointer-events: none;
    position: absolute;
    width: 100%;
    padding-bottom: 100%;
    top: 50%;
    left: 50%;
    margin-top: -50%;
    margin-left: -50%;
    -webkit-animation: ytp-spinner-linspin 1568.23529647ms linear infinite;
    -moz-animation: ytp-spinner-linspin 1568.23529647ms linear infinite;
    -o-animation: ytp-spinner-linspin 1568.23529647ms linear infinite;
    animation: ytp-spinner-linspin 1568.23529647ms linear infinite;
}

.preloader .loader .ytp-spinner .ytp-spinner-container .ytp-spinner-rotator {
    position: absolute;
    width: 100%;
    height: 100%;
    -webkit-animation: ytp-spinner-easespin 5332ms cubic-bezier(0.4, 0, 0.2, 1) infinite both;
    -moz-animation: ytp-spinner-easespin 5332ms cubic-bezier(0.4, 0, 0.2, 1) infinite both;
    -o-animation: ytp-spinner-easespin 5332ms cubic-bezier(0.4, 0, 0.2, 1) infinite both;
    animation: ytp-spinner-easespin 5332ms cubic-bezier(0.4, 0, 0.2, 1) infinite both;
}

.preloader .loader .ytp-spinner .ytp-spinner-container .ytp-spinner-rotator .ytp-spinner-left {
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    overflow: hidden;
    right: 50%;
}

.preloader .loader .ytp-spinner .ytp-spinner-container .ytp-spinner-rotator .ytp-spinner-right {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    overflow: hidden;
    left: 50%;
}

.preloader .loader .ytp-spinner-circle {
    box-sizing: border-box;
    position: absolute;
    width: 200%;
    height: 100%;
    border-style: solid;
    /* Spinner Color */
    border-color: #0067f4 #0067f4 #e9ecef;
    border-radius: 50%;
    border-width: 6px;
}

.preloader .loader .ytp-spinner-left .ytp-spinner-circle {
    left: 0;
    right: -100%;
    border-right-color: #e9ecef;
    -webkit-animation: ytp-spinner-left-spin 1333ms cubic-bezier(0.4, 0, 0.2, 1) infinite both;
    -moz-animation: ytp-spinner-left-spin 1333ms cubic-bezier(0.4, 0, 0.2, 1) infinite both;
    -o-animation: ytp-spinner-left-spin 1333ms cubic-bezier(0.4, 0, 0.2, 1) infinite both;
    animation: ytp-spinner-left-spin 1333ms cubic-bezier(0.4, 0, 0.2, 1) infinite both;
}

.preloader .loader .ytp-spinner-right .ytp-spinner-circle {
    left: -100%;
    right: 0;
    border-left-color: #e9ecef;
    -webkit-animation: ytp-right-spin 1333ms cubic-bezier(0.4, 0, 0.2, 1) infinite both;
    -moz-animation: ytp-right-spin 1333ms cubic-bezier(0.4, 0, 0.2, 1) infinite both;
    -o-animation: ytp-right-spin 1333ms cubic-bezier(0.4, 0, 0.2, 1) infinite both;
    animation: ytp-right-spin 1333ms cubic-bezier(0.4, 0, 0.2, 1) infinite both;
}


/* Preloader Animations */

@-webkit-keyframes ytp-spinner-linspin {
    to {
        -webkit-transform: rotate(360deg);
        -moz-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        -o-transform: rotate(360deg);
        transform: rotate(360deg);
    }
}

@keyframes ytp-spinner-linspin {
    to {
        -webkit-transform: rotate(360deg);
        -moz-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        -o-transform: rotate(360deg);
        transform: rotate(360deg);
    }
}

@-webkit-keyframes ytp-spinner-easespin {
    12.5% {
        -webkit-transform: rotate(135deg);
        -moz-transform: rotate(135deg);
        -ms-transform: rotate(135deg);
        -o-transform: rotate(135deg);
        transform: rotate(135deg);
    }
    25% {
        -webkit-transform: rotate(270deg);
        -moz-transform: rotate(270deg);
        -ms-transform: rotate(270deg);
        -o-transform: rotate(270deg);
        transform: rotate(270deg);
    }
    37.5% {
        -webkit-transform: rotate(405deg);
        -moz-transform: rotate(405deg);
        -ms-transform: rotate(405deg);
        -o-transform: rotate(405deg);
        transform: rotate(405deg);
    }
    50% {
        -webkit-transform: rotate(540deg);
        -moz-transform: rotate(540deg);
        -ms-transform: rotate(540deg);
        -o-transform: rotate(540deg);
        transform: rotate(540deg);
    }
    62.5% {
        -webkit-transform: rotate(675deg);
        -moz-transform: rotate(675deg);
        -ms-transform: rotate(675deg);
        -o-transform: rotate(675deg);
        transform: rotate(675deg);
    }
    75% {
        -webkit-transform: rotate(810deg);
        -moz-transform: rotate(810deg);
        -ms-transform: rotate(810deg);
        -o-transform: rotate(810deg);
        transform: rotate(810deg);
    }
    87.5% {
        -webkit-transform: rotate(945deg);
        -moz-transform: rotate(945deg);
        -ms-transform: rotate(945deg);
        -o-transform: rotate(945deg);
        transform: rotate(945deg);
    }
    to {
        -webkit-transform: rotate(1080deg);
        -moz-transform: rotate(1080deg);
        -ms-transform: rotate(1080deg);
        -o-transform: rotate(1080deg);
        transform: rotate(1080deg);
    }
}

@keyframes ytp-spinner-easespin {
    12.5% {
        -webkit-transform: rotate(135deg);
        -moz-transform: rotate(135deg);
        -ms-transform: rotate(135deg);
        -o-transform: rotate(135deg);
        transform: rotate(135deg);
    }
    25% {
        -webkit-transform: rotate(270deg);
        -moz-transform: rotate(270deg);
        -ms-transform: rotate(270deg);
        -o-transform: rotate(270deg);
        transform: rotate(270deg);
    }
    37.5% {
        -webkit-transform: rotate(405deg);
        -moz-transform: rotate(405deg);
        -ms-transform: rotate(405deg);
        -o-transform: rotate(405deg);
        transform: rotate(405deg);
    }
    50% {
        -webkit-transform: rotate(540deg);
        -moz-transform: rotate(540deg);
        -ms-transform: rotate(540deg);
        -o-transform: rotate(540deg);
        transform: rotate(540deg);
    }
    62.5% {
        -webkit-transform: rotate(675deg);
        -moz-transform: rotate(675deg);
        -ms-transform: rotate(675deg);
        -o-transform: rotate(675deg);
        transform: rotate(675deg);
    }
    75% {
        -webkit-transform: rotate(810deg);
        -moz-transform: rotate(810deg);
        -ms-transform: rotate(810deg);
        -o-transform: rotate(810deg);
        transform: rotate(810deg);
    }
    87.5% {
        -webkit-transform: rotate(945deg);
        -moz-transform: rotate(945deg);
        -ms-transform: rotate(945deg);
        -o-transform: rotate(945deg);
        transform: rotate(945deg);
    }
    to {
        -webkit-transform: rotate(1080deg);
        -moz-transform: rotate(1080deg);
        -ms-transform: rotate(1080deg);
        -o-transform: rotate(1080deg);
        transform: rotate(1080deg);
    }
}

@-webkit-keyframes ytp-spinner-left-spin {
    0% {
        -webkit-transform: rotate(130deg);
        -moz-transform: rotate(130deg);
        -ms-transform: rotate(130deg);
        -o-transform: rotate(130deg);
        transform: rotate(130deg);
    }
    50% {
        -webkit-transform: rotate(-5deg);
        -moz-transform: rotate(-5deg);
        -ms-transform: rotate(-5deg);
        -o-transform: rotate(-5deg);
        transform: rotate(-5deg);
    }
    to {
        -webkit-transform: rotate(130deg);
        -moz-transform: rotate(130deg);
        -ms-transform: rotate(130deg);
        -o-transform: rotate(130deg);
        transform: rotate(130deg);
    }
}

@keyframes ytp-spinner-left-spin {
    0% {
        -webkit-transform: rotate(130deg);
        -moz-transform: rotate(130deg);
        -ms-transform: rotate(130deg);
        -o-transform: rotate(130deg);
        transform: rotate(130deg);
    }
    50% {
        -webkit-transform: rotate(-5deg);
        -moz-transform: rotate(-5deg);
        -ms-transform: rotate(-5deg);
        -o-transform: rotate(-5deg);
        transform: rotate(-5deg);
    }
    to {
        -webkit-transform: rotate(130deg);
        -moz-transform: rotate(130deg);
        -ms-transform: rotate(130deg);
        -o-transform: rotate(130deg);
        transform: rotate(130deg);
    }
}

@-webkit-keyframes ytp-right-spin {
    0% {
        -webkit-transform: rotate(-130deg);
        -moz-transform: rotate(-130deg);
        -ms-transform: rotate(-130deg);
        -o-transform: rotate(-130deg);
        transform: rotate(-130deg);
    }
    50% {
        -webkit-transform: rotate(5deg);
        -moz-transform: rotate(5deg);
        -ms-transform: rotate(5deg);
        -o-transform: rotate(5deg);
        transform: rotate(5deg);
    }
    to {
        -webkit-transform: rotate(-130deg);
        -moz-transform: rotate(-130deg);
        -ms-transform: rotate(-130deg);
        -o-transform: rotate(-130deg);
        transform: rotate(-130deg);
    }
}

@keyframes ytp-right-spin {
    0% {
        -webkit-transform: rotate(-130deg);
        -moz-transform: rotate(-130deg);
        -ms-transform: rotate(-130deg);
        -o-transform: rotate(-130deg);
        transform: rotate(-130deg);
    }
    50% {
        -webkit-transform: rotate(5deg);
        -moz-transform: rotate(5deg);
        -ms-transform: rotate(5deg);
        -o-transform: rotate(5deg);
        transform: rotate(5deg);
    }
    to {
        -webkit-transform: rotate(-130deg);
        -moz-transform: rotate(-130deg);
        -ms-transform: rotate(-130deg);
        -o-transform: rotate(-130deg);
        transform: rotate(-130deg);
    }
}


/*===========================
    11.BUTTON css
===========================*/

.buttons-title .title {
    font-size: 36px;
    line-height: 45px;
    color: #6c6c6c;
}

@media (max-width: 767px) {
    .buttons-title .title {
        font-size: 24px;
        line-height: 35px;
    }
}

.main-btn {
    display: inline-block;
    font-weight: 700;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    border: 2px solid transparent;
    padding: 0 32px;
    font-size: 16px;
    line-height: 46px;
    color: #0067f4;
    cursor: pointer;
    z-index: 5;
    -webkit-transition: all 0.4s ease-out 0s;
    -moz-transition: all 0.4s ease-out 0s;
    -ms-transition: all 0.4s ease-out 0s;
    -o-transition: all 0.4s ease-out 0s;
    transition: all 0.4s ease-out 0s;
    position: relative;
    text-transform: uppercase;
}

@media (max-width: 767px) {
    .main-btn {
        font-size: 14px;
        padding: 0 20px;
        line-height: 40px;
    }
}


/*===== standard Buttons =====*/

.standard-buttons ul li {
    display: inline-block;
    margin-left: 18px;
    margin-top: 20px;
}

@media (max-width: 767px) {
    .standard-buttons ul li {
        margin-left: 0;
    }
}

.standard-buttons ul li:first-child {
    margin-left: 0;
}

.standard-buttons .standard-one {
    border-color: #0067f4;
}

.standard-buttons .standard-one:hover {
    color: #0067f4;
    background-color: rgba(0, 103, 244, 0.4);
}

.standard-buttons .standard-two {
    color: #fff;
    background-color: #0067f4;
    border-color: #0067f4;
}

.standard-buttons .standard-two:hover {
    color: #0067f4;
    background-color: transparent;
}

.standard-buttons .standard-three {
    overflow: hidden;
    line-height: 50px;
    color: #fff;
    background: -webkit-linear-gradient(left, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: -o-linear-gradient(left, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: linear-gradient(to right, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    border: 0;
    line-height: 52px;
    background-size: 200% auto;
}

@media only screen and (min-width: 768px) and (max-width: 991px) {
    .standard-buttons .standard-three {
        line-height: 44px;
    }
}

@media (max-width: 767px) {
    .standard-buttons .standard-three {
        line-height: 44px;
    }
}

.standard-buttons .standard-three:hover {
    background-position: right center;
}

.standard-buttons .standard-four {
    border-color: #0067f4;
    padding-left: 60px;
}

@media (max-width: 767px) {
    .standard-buttons .standard-four {
        padding-left: 40px;
    }
}

.standard-buttons .standard-four span {
    position: absolute;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
    overflow: hidden;
    left: 30px;
    line-height: normal;
}

@media (max-width: 767px) {
    .standard-buttons .standard-four span {
        left: 15px;
    }
}

.standard-buttons .standard-four:hover {
    color: #0067f4;
    background-color: rgba(0, 103, 244, 0.4);
}

.standard-buttons .standard-four:hover i {
    animation: iconTranslateY 0.5s forwards;
}

.standard-buttons .standard-five {
    color: #fff;
    background-color: #0067f4;
    border-color: #0067f4;
    padding-left: 60px;
}

@media (max-width: 767px) {
    .standard-buttons .standard-five {
        padding-left: 40px;
    }
}

.standard-buttons .standard-five span {
    position: absolute;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
    overflow: hidden;
    left: 30px;
    line-height: normal;
}

@media (max-width: 767px) {
    .standard-buttons .standard-five span {
        left: 15px;
    }
}

.standard-buttons .standard-five:hover {
    color: #0067f4;
    background-color: transparent;
}

.standard-buttons .standard-five:hover i {
    animation: iconTranslateY 0.5s forwards;
}

.standard-buttons .standard-six {
    padding-right: 60px;
    overflow: hidden;
    line-height: 50px;
    color: #fff;
    background: -webkit-linear-gradient(left, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: -o-linear-gradient(left, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: linear-gradient(to right, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    border: 0;
    line-height: 52px;
    background-size: 200% auto;
}

@media (max-width: 767px) {
    .standard-buttons .standard-six {
        padding-right: 40px;
        line-height: 44px;
    }
}

@media only screen and (min-width: 768px) and (max-width: 991px) {
    .standard-buttons .standard-six {
        line-height: 44px;
    }
}

.standard-buttons .standard-six span {
    position: absolute;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
    overflow: hidden;
    right: 30px;
    line-height: normal;
}

@media (max-width: 767px) {
    .standard-buttons .standard-six span {
        right: 15px;
    }
}

.standard-buttons .standard-six:hover {
    background-position: right center;
}

.standard-buttons .standard-six:hover i {
    -webkit-animation: iconTranslateY 0.5s forwards;
    -moz-animation: iconTranslateY 0.5s forwards;
    -o-animation: iconTranslateY 0.5s forwards;
    animation: iconTranslateY 0.5s forwards;
}


/*===== Light Rounded Buttons =====*/

.light-rounded-buttons ul li {
    display: inline-block;
    margin-left: 18px;
    margin-top: 20px;
}

@media (max-width: 767px) {
    .light-rounded-buttons ul li {
        margin-left: 0;
    }
}

.light-rounded-buttons ul li:first-child {
    margin-left: 0;
}

.light-rounded-buttons .main-btn {
    border-radius: 5px;
}

.light-rounded-buttons .light-rounded-one {
    border-color: #0067f4;
}

.light-rounded-buttons .light-rounded-one:hover {
    color: #0067f4;
    background-color: rgba(0, 103, 244, 0.4);
}

.light-rounded-buttons .light-rounded-two {
    color: #fff;
    background-color: #0067f4;
    border-color: #0067f4;
}

.light-rounded-buttons .light-rounded-three {
    overflow: hidden;
    line-height: 50px;
    color: #fff;
    background: -webkit-linear-gradient(left, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: -o-linear-gradient(left, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: linear-gradient(to right, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background-size: 200% auto;
    line-height: 52px;
    border: 0;
}

@media only screen and (min-width: 768px) and (max-width: 991px) {
    .light-rounded-buttons .light-rounded-three {
        line-height: 44px;
    }
}

@media (max-width: 767px) {
    .light-rounded-buttons .light-rounded-three {
        line-height: 44px;
    }
}

.light-rounded-buttons .light-rounded-three:hover {
    background-position: right center;
}

.light-rounded-buttons .light-rounded-four {
    border-color: #0067f4;
    padding-left: 60px;
}

@media (max-width: 767px) {
    .light-rounded-buttons .light-rounded-four {
        padding-left: 40px;
    }
}

.light-rounded-buttons .light-rounded-four span {
    position: absolute;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
    overflow: hidden;
    left: 30px;
    line-height: normal;
}

@media (max-width: 767px) {
    .light-rounded-buttons .light-rounded-four span {
        left: 15px;
    }
}

.light-rounded-buttons .light-rounded-four:hover {
    color: #0067f4;
    background-color: rgba(0, 103, 244, 0.4);
}

.light-rounded-buttons .light-rounded-four:hover i {
    -webkit-animation: iconTranslateY 0.5s forwards;
    -moz-animation: iconTranslateY 0.5s forwards;
    -o-animation: iconTranslateY 0.5s forwards;
    animation: iconTranslateY 0.5s forwards;
}

.light-rounded-buttons .light-rounded-five {
    color: #fff;
    background-color: #0067f4;
    border-color: #0067f4;
    padding-left: 60px;
}

@media (max-width: 767px) {
    .light-rounded-buttons .light-rounded-five {
        padding-left: 40px;
    }
}

.light-rounded-buttons .light-rounded-five span {
    position: absolute;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
    overflow: hidden;
    left: 30px;
    line-height: normal;
}

@media (max-width: 767px) {
    .light-rounded-buttons .light-rounded-five span {
        left: 15px;
    }
}

.light-rounded-buttons .light-rounded-five:hover {
    color: #0067f4;
    background-color: transparent;
}

.light-rounded-buttons .light-rounded-five:hover i {
    -webkit-animation: iconTranslateY 0.5s forwards;
    -moz-animation: iconTranslateY 0.5s forwards;
    -o-animation: iconTranslateY 0.5s forwards;
    animation: iconTranslateY 0.5s forwards;
}

.light-rounded-buttons .light-rounded-six {
    padding-right: 60px;
    overflow: hidden;
    line-height: 50px;
    color: #fff;
    background: -webkit-linear-gradient(left, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: -o-linear-gradient(left, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: linear-gradient(to right, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background-size: 200% auto;
    line-height: 52px;
    border: 0;
}

@media only screen and (min-width: 768px) and (max-width: 991px) {
    .light-rounded-buttons .light-rounded-six {
        line-height: 44px;
    }
}

@media (max-width: 767px) {
    .light-rounded-buttons .light-rounded-six {
        padding-right: 40px;
        line-height: 44px;
    }
}

.light-rounded-buttons .light-rounded-six span {
    position: absolute;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
    overflow: hidden;
    right: 30px;
    line-height: normal;
}

@media (max-width: 767px) {
    .light-rounded-buttons .light-rounded-six span {
        right: 15px;
    }
}

.light-rounded-buttons .light-rounded-six:hover {
    background-position: right center;
}

.light-rounded-buttons .light-rounded-six:hover i {
    -webkit-animation: iconTranslateY 0.5s forwards;
    -moz-animation: iconTranslateY 0.5s forwards;
    -o-animation: iconTranslateY 0.5s forwards;
    animation: iconTranslateY 0.5s forwards;
}


/*===== Semi Rounded Buttons =====*/

.semi-rounded-buttons ul li {
    display: inline-block;
    margin-left: 18px;
    margin-top: 20px;
}

@media (max-width: 767px) {
    .semi-rounded-buttons ul li {
        margin-left: 0;
    }
}

.semi-rounded-buttons ul li:first-child {
    margin-left: 0;
}

.semi-rounded-buttons .main-btn {
    border-radius: 10px;
}

.semi-rounded-buttons .semi-rounded-one {
    border-color: #0067f4;
}

.semi-rounded-buttons .semi-rounded-one:hover {
    color: #0067f4;
    background-color: rgba(0, 103, 244, 0.4);
}

.semi-rounded-buttons .semi-rounded-two {
    color: #fff;
    background-color: #0067f4;
    border-color: #0067f4;
}

.semi-rounded-buttons .semi-rounded-two:hover {
    color: #0067f4;
    background-color: transparent;
}

.semi-rounded-buttons .semi-rounded-three {
    overflow: hidden;
    line-height: 52px;
    background: -webkit-linear-gradient(left, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: -o-linear-gradient(left, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: linear-gradient(to right, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background-size: 200% auto;
    border: 0;
    color: #fff;
}

@media only screen and (min-width: 768px) and (max-width: 991px) {
    .semi-rounded-buttons .semi-rounded-three {
        line-height: 44px;
    }
}

@media (max-width: 767px) {
    .semi-rounded-buttons .semi-rounded-three {
        line-height: 44px;
    }
}

.semi-rounded-buttons .semi-rounded-three:hover {
    background-position: right center;
}

.semi-rounded-buttons .semi-rounded-four {
    border-color: #0067f4;
    padding-left: 60px;
}

@media (max-width: 767px) {
    .semi-rounded-buttons .semi-rounded-four {
        padding-left: 40px;
    }
}

.semi-rounded-buttons .semi-rounded-four span {
    position: absolute;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
    overflow: hidden;
    left: 30px;
    line-height: normal;
}

@media (max-width: 767px) {
    .semi-rounded-buttons .semi-rounded-four span {
        left: 15px;
    }
}

.semi-rounded-buttons .semi-rounded-four:hover {
    color: #0067f4;
    background-color: rgba(0, 103, 244, 0.4);
}

.semi-rounded-buttons .semi-rounded-four:hover i {
    -webkit-animation: iconTranslateY 0.5s forwards;
    -moz-animation: iconTranslateY 0.5s forwards;
    -o-animation: iconTranslateY 0.5s forwards;
    animation: iconTranslateY 0.5s forwards;
}

.semi-rounded-buttons .semi-rounded-five {
    color: #fff;
    background-color: #0067f4;
    border-color: #0067f4;
    padding-left: 60px;
}

@media (max-width: 767px) {
    .semi-rounded-buttons .semi-rounded-five {
        padding-left: 40px;
    }
}

.semi-rounded-buttons .semi-rounded-five span {
    position: absolute;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
    overflow: hidden;
    left: 30px;
    line-height: normal;
}

@media (max-width: 767px) {
    .semi-rounded-buttons .semi-rounded-five span {
        left: 15px;
    }
}

.semi-rounded-buttons .semi-rounded-five:hover {
    color: #0067f4;
    background-color: transparent;
}

.semi-rounded-buttons .semi-rounded-five:hover i {
    -webkit-animation: iconTranslateY 0.5s forwards;
    -moz-animation: iconTranslateY 0.5s forwards;
    -o-animation: iconTranslateY 0.5s forwards;
    animation: iconTranslateY 0.5s forwards;
}

.semi-rounded-buttons .semi-rounded-six {
    padding-right: 60px;
    overflow: hidden;
    line-height: 52px;
    background: -webkit-linear-gradient(left, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: -o-linear-gradient(left, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: linear-gradient(to right, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background-size: 200% auto;
    border: 0;
    color: #fff;
}

@media only screen and (min-width: 768px) and (max-width: 991px) {
    .semi-rounded-buttons .semi-rounded-six {
        line-height: 44px;
    }
}

@media (max-width: 767px) {
    .semi-rounded-buttons .semi-rounded-six {
        padding-right: 40px;
        line-height: 44px;
    }
}

.semi-rounded-buttons .semi-rounded-six span {
    position: absolute;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
    overflow: hidden;
    right: 30px;
    line-height: normal;
}

@media (max-width: 767px) {
    .semi-rounded-buttons .semi-rounded-six span {
        right: 15px;
    }
}

.semi-rounded-buttons .semi-rounded-six:hover {
    background-position: right center;
}

.semi-rounded-buttons .semi-rounded-six:hover i {
    -webkit-animation: iconTranslateY 0.5s forwards;
    -moz-animation: iconTranslateY 0.5s forwards;
    -o-animation: iconTranslateY 0.5s forwards;
    animation: iconTranslateY 0.5s forwards;
}


/*===== Rounded Buttons =====*/

.rounded-buttons ul li {
    display: inline-block;
    margin-left: 18px;
    margin-top: 20px;
}

@media (max-width: 767px) {
    .rounded-buttons ul li {
        margin-left: 0;
    }
}

.rounded-buttons ul li:first-child {
    margin-left: 0;
}

.rounded-buttons .main-btn {
    border-radius: 50px;
}

.rounded-buttons .rounded-one {
    border-color: #0067f4;
}

.rounded-buttons .rounded-one:hover {
    color: #0067f4;
    background-color: rgba(0, 103, 244, 0.4);
}

.rounded-buttons .rounded-two {
    color: #fff;
    background-color: #0067f4;
    border-color: #0067f4;
}

.rounded-buttons .rounded-two:hover {
    color: #0067f4;
    background-color: transparent;
}

.rounded-buttons .rounded-three {
    overflow: hidden;
    line-height: 52px;
    background: -webkit-linear-gradient(left, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: -o-linear-gradient(left, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: linear-gradient(to right, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background-size: 200% auto;
    color: #fff;
    border: 0;
}

@media only screen and (min-width: 768px) and (max-width: 991px) {
    .rounded-buttons .rounded-three {
        line-height: 44px;
    }
}

@media (max-width: 767px) {
    .rounded-buttons .rounded-three {
        line-height: 44px;
    }
}

.rounded-buttons .rounded-three:hover {
    background-position: right center;
}

.rounded-buttons .rounded-four {
    border-color: #0067f4;
    padding-left: 60px;
}

@media (max-width: 767px) {
    .rounded-buttons .rounded-four {
        padding-left: 40px;
    }
}

.rounded-buttons .rounded-four span {
    position: absolute;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
    overflow: hidden;
    left: 30px;
    line-height: normal;
}

@media (max-width: 767px) {
    .rounded-buttons .rounded-four span {
        left: 15px;
    }
}

.rounded-buttons .rounded-four:hover {
    color: #0067f4;
    background-color: rgba(0, 103, 244, 0.4);
}

.rounded-buttons .rounded-four:hover i {
    -webkit-animation: iconTranslateY 0.5s forwards;
    -moz-animation: iconTranslateY 0.5s forwards;
    -o-animation: iconTranslateY 0.5s forwards;
    animation: iconTranslateY 0.5s forwards;
}

.rounded-buttons .rounded-five {
    color: #fff;
    background-color: #0067f4;
    border-color: #0067f4;
    padding-left: 60px;
}

@media (max-width: 767px) {
    .rounded-buttons .rounded-five {
        padding-left: 40px;
    }
}

.rounded-buttons .rounded-five span {
    position: absolute;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
    overflow: hidden;
    left: 30px;
    line-height: normal;
}

@media (max-width: 767px) {
    .rounded-buttons .rounded-five span {
        left: 15px;
    }
}

.rounded-buttons .rounded-five:hover {
    color: #0067f4;
    background-color: transparent;
}

.rounded-buttons .rounded-five:hover i {
    -webkit-animation: iconTranslateY 0.5s forwards;
    -moz-animation: iconTranslateY 0.5s forwards;
    -o-animation: iconTranslateY 0.5s forwards;
    animation: iconTranslateY 0.5s forwards;
}

.rounded-buttons .rounded-six {
    padding-right: 60px;
    overflow: hidden;
    line-height: 52px;
    background: -webkit-linear-gradient(left, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: -o-linear-gradient(left, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: linear-gradient(to right, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background-size: 200% auto;
    color: #fff;
    border: 0;
}

@media only screen and (min-width: 768px) and (max-width: 991px) {
    .rounded-buttons .rounded-six {
        line-height: 44px;
    }
}

@media (max-width: 767px) {
    .rounded-buttons .rounded-six {
        padding-right: 40px;
        line-height: 44px;
    }
}

.rounded-buttons .rounded-six span {
    position: absolute;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
    overflow: hidden;
    right: 30px;
    line-height: normal;
}

@media (max-width: 767px) {
    .rounded-buttons .rounded-six span {
        right: 15px;
    }
}

.rounded-buttons .rounded-six:hover {
    background-position: right center;
}

.rounded-buttons .rounded-six:hover i {
    -webkit-animation: iconTranslateY 0.5s forwards;
    -moz-animation: iconTranslateY 0.5s forwards;
    -o-animation: iconTranslateY 0.5s forwards;
    animation: iconTranslateY 0.5s forwards;
}


/*===== Success Buttons =====*/

.success-buttons ul li {
    display: inline-block;
    margin-left: 18px;
    margin-top: 20px;
}

@media (max-width: 767px) {
    .success-buttons ul li {
        margin-left: 0;
    }
}

.success-buttons ul li:first-child {
    margin-left: 0;
}

.success-buttons .success-one {
    border-color: #4da422;
    color: #4da422;
}

.success-buttons .success-one:hover {
    color: #4da422;
    background-color: rgba(77, 164, 34, 0.4);
}

.success-buttons .success-two {
    color: #fff;
    background-color: #4da422;
    border-color: #4da422;
}

.success-buttons .success-two:hover {
    color: #4da422;
    background-color: transparent;
}

.success-buttons .success-three {
    overflow: hidden;
    line-height: 52px;
    color: #fff;
    border: 0;
    background: -webkit-linear-gradient(left, #4da422 0%, #69e02e 50%, #4da422 100%);
    background: -o-linear-gradient(left, #4da422 0%, #69e02e 50%, #4da422 100%);
    background: linear-gradient(to right, #4da422 0%, #69e02e 50%, #4da422 100%);
    background-size: 200% auto;
}

@media only screen and (min-width: 768px) and (max-width: 991px) {
    .success-buttons .success-three {
        line-height: 44px;
    }
}

@media (max-width: 767px) {
    .success-buttons .success-three {
        line-height: 44px;
    }
}

.success-buttons .success-three:hover {
    background-position: right center;
}

.success-buttons .success-four {
    padding-left: 60px;
    border-color: #4da422;
    color: #4da422;
}

@media (max-width: 767px) {
    .success-buttons .success-four {
        padding-left: 40px;
    }
}

.success-buttons .success-four span {
    position: absolute;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
    overflow: hidden;
    left: 30px;
    line-height: normal;
}

@media (max-width: 767px) {
    .success-buttons .success-four span {
        left: 15px;
    }
}

.success-buttons .success-four:hover {
    color: #4da422;
    background-color: rgba(77, 164, 34, 0.4);
}

.success-buttons .success-four:hover i {
    -webkit-animation: iconTranslateY 0.5s forwards;
    -moz-animation: iconTranslateY 0.5s forwards;
    -o-animation: iconTranslateY 0.5s forwards;
    animation: iconTranslateY 0.5s forwards;
}

.success-buttons .success-five {
    padding-left: 60px;
    color: #fff;
    background-color: #4da422;
    border-color: #4da422;
}

@media (max-width: 767px) {
    .success-buttons .success-five {
        padding-left: 40px;
    }
}

.success-buttons .success-five span {
    position: absolute;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
    overflow: hidden;
    left: 30px;
    line-height: normal;
}

@media (max-width: 767px) {
    .success-buttons .success-five span {
        left: 15px;
    }
}

.success-buttons .success-five:hover {
    color: #4da422;
    background-color: transparent;
}

.success-buttons .success-five:hover i {
    -webkit-animation: iconTranslateY 0.5s forwards;
    -moz-animation: iconTranslateY 0.5s forwards;
    -o-animation: iconTranslateY 0.5s forwards;
    animation: iconTranslateY 0.5s forwards;
}

.success-buttons .success-six {
    padding-right: 60px;
    overflow: hidden;
    line-height: 52px;
    color: #fff;
    border: 0;
    background: -webkit-linear-gradient(left, #4da422 0%, #69e02e 50%, #4da422 100%);
    background: -o-linear-gradient(left, #4da422 0%, #69e02e 50%, #4da422 100%);
    background: linear-gradient(to right, #4da422 0%, #69e02e 50%, #4da422 100%);
    background-size: 200% auto;
}

@media only screen and (min-width: 768px) and (max-width: 991px) {
    .success-buttons .success-six {
        line-height: 44px;
    }
}

@media (max-width: 767px) {
    .success-buttons .success-six {
        padding-right: 40px;
        line-height: 44px;
    }
}

.success-buttons .success-six span {
    position: absolute;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
    overflow: hidden;
    right: 30px;
    line-height: normal;
}

@media (max-width: 767px) {
    .success-buttons .success-six span {
        right: 15px;
    }
}

.success-buttons .success-six:hover {
    background-position: right center;
}

.success-buttons .success-six:hover i {
    -webkit-animation: iconTranslateY 0.5s forwards;
    -moz-animation: iconTranslateY 0.5s forwards;
    -o-animation: iconTranslateY 0.5s forwards;
    animation: iconTranslateY 0.5s forwards;
}


/*===== Warning Buttons =====*/

.warning-buttons ul li {
    display: inline-block;
    margin-left: 18px;
    margin-top: 20px;
}

@media (max-width: 767px) {
    .warning-buttons ul li {
        margin-left: 0;
    }
}

.warning-buttons ul li:first-child {
    margin-left: 0;
}

.warning-buttons .warning-one {
    border-color: #ffb400;
    color: #ffb400;
}

.warning-buttons .warning-one:hover {
    color: #ffb400;
    background-color: rgba(255, 180, 0, 0.4);
}

.warning-buttons .warning-two {
    color: #fff;
    background-color: #ffb400;
    border-color: #ffb400;
}

@media only screen and (min-width: 768px) and (max-width: 991px) {
    .warning-buttons .warning-two {
        line-height: 44px;
    }
}

@media (max-width: 767px) {
    .warning-buttons .warning-two {
        padding-right: 40px;
        line-height: 44px;
    }
}

.warning-buttons .warning-two:hover {
    color: #ffb400;
    background-color: transparent;
}

.warning-buttons .warning-three {
    overflow: hidden;
    line-height: 52px;
    color: #fff;
    border: 0;
    background: -webkit-linear-gradient(left, #ffb400 0%, #f7e500 50%, #ffb400 100%);
    background: -o-linear-gradient(left, #ffb400 0%, #f7e500 50%, #ffb400 100%);
    background: linear-gradient(to right, #ffb400 0%, #f7e500 50%, #ffb400 100%);
    background-size: 200% auto;
}

@media only screen and (min-width: 768px) and (max-width: 991px) {
    .warning-buttons .warning-three {
        line-height: 44px;
    }
}

@media (max-width: 767px) {
    .warning-buttons .warning-three {
        line-height: 44px;
    }
}

.warning-buttons .warning-three:hover {
    background-position: right center;
}

.warning-buttons .warning-four {
    padding-left: 60px;
    border-color: #ffb400;
    color: #ffb400;
}

@media (max-width: 767px) {
    .warning-buttons .warning-four {
        padding-left: 40px;
    }
}

.warning-buttons .warning-four span {
    position: absolute;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
    overflow: hidden;
    left: 30px;
    line-height: normal;
}

@media (max-width: 767px) {
    .warning-buttons .warning-four span {
        left: 15px;
    }
}

.warning-buttons .warning-four:hover {
    color: #ffb400;
    background-color: rgba(255, 180, 0, 0.4);
}

.warning-buttons .warning-four:hover i {
    -webkit-animation: iconTranslateY 0.5s forwards;
    -moz-animation: iconTranslateY 0.5s forwards;
    -o-animation: iconTranslateY 0.5s forwards;
    animation: iconTranslateY 0.5s forwards;
}

.warning-buttons .warning-five {
    padding-left: 60px;
    color: #fff;
    background-color: #ffb400;
    border-color: #ffb400;
}

@media (max-width: 767px) {
    .warning-buttons .warning-five {
        padding-left: 40px;
    }
}

.warning-buttons .warning-five span {
    position: absolute;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
    overflow: hidden;
    left: 30px;
    line-height: normal;
}

@media (max-width: 767px) {
    .warning-buttons .warning-five span {
        left: 15px;
    }
}

.warning-buttons .warning-five:hover {
    color: #ffb400;
    background-color: transparent;
}

.warning-buttons .warning-five:hover i {
    -webkit-animation: iconTranslateY 0.5s forwards;
    -moz-animation: iconTranslateY 0.5s forwards;
    -o-animation: iconTranslateY 0.5s forwards;
    animation: iconTranslateY 0.5s forwards;
}

.warning-buttons .warning-six {
    padding-right: 60px;
    overflow: hidden;
    line-height: 52px;
    color: #fff;
    border: 0;
    background: -webkit-linear-gradient(left, #ffb400 0%, #f7e500 50%, #ffb400 100%);
    background: -o-linear-gradient(left, #ffb400 0%, #f7e500 50%, #ffb400 100%);
    background: linear-gradient(to right, #ffb400 0%, #f7e500 50%, #ffb400 100%);
    background-size: 200% auto;
}

@media only screen and (min-width: 768px) and (max-width: 991px) {
    .warning-buttons .warning-six {
        line-height: 44px;
    }
}

@media (max-width: 767px) {
    .warning-buttons .warning-six {
        padding-right: 40px;
        line-height: 44px;
    }
}

.warning-buttons .warning-six span {
    position: absolute;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
    overflow: hidden;
    right: 30px;
    line-height: normal;
}

@media (max-width: 767px) {
    .warning-buttons .warning-six span {
        right: 15px;
    }
}

.warning-buttons .warning-six:hover {
    background-position: right center;
}

.warning-buttons .warning-six:hover i {
    -webkit-animation: iconTranslateY 0.5s forwards;
    -moz-animation: iconTranslateY 0.5s forwards;
    -o-animation: iconTranslateY 0.5s forwards;
    animation: iconTranslateY 0.5s forwards;
}


/*===== Info Buttons =====*/

.info-buttons ul li {
    display: inline-block;
    margin-left: 18px;
    margin-top: 20px;
}

@media (max-width: 767px) {
    .info-buttons ul li {
        margin-left: 0;
    }
}

.info-buttons ul li:first-child {
    margin-left: 0;
}

.info-buttons .info-one {
    border-color: #00b8d8;
    color: #00b8d8;
}

.info-buttons .info-one:hover {
    color: #00b8d8;
    background-color: rgba(0, 184, 216, 0.4);
}

.info-buttons .info-two {
    color: #fff;
    background-color: #00b8d8;
    border-color: #00b8d8;
}

.info-buttons .info-two:hover {
    color: #00b8d8;
    background-color: transparent;
}

.info-buttons .info-three {
    overflow: hidden;
    line-height: 52px;
    color: #fff;
    border: 0;
    background: -webkit-linear-gradient(left, #00b8d8 0%, #32fbfc 50%, #00b8d8 100%);
    background: -o-linear-gradient(left, #00b8d8 0%, #32fbfc 50%, #00b8d8 100%);
    background: linear-gradient(to right, #00b8d8 0%, #32fbfc 50%, #00b8d8 100%);
    background-size: 200% auto;
}

@media only screen and (min-width: 768px) and (max-width: 991px) {
    .info-buttons .info-three {
        line-height: 44px;
    }
}

@media (max-width: 767px) {
    .info-buttons .info-three {
        line-height: 44px;
    }
}

.info-buttons .info-three:hover {
    background-position: right center;
}

.info-buttons .info-four {
    padding-left: 60px;
    border-color: #00b8d8;
    color: #00b8d8;
}

@media (max-width: 767px) {
    .info-buttons .info-four {
        padding-left: 40px;
    }
}

.info-buttons .info-four span {
    position: absolute;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
    overflow: hidden;
    left: 30px;
    line-height: normal;
}

@media (max-width: 767px) {
    .info-buttons .info-four span {
        left: 15px;
    }
}

.info-buttons .info-four:hover {
    color: #00b8d8;
    background-color: rgba(0, 184, 216, 0.4);
}

.info-buttons .info-four:hover i {
    -webkit-animation: iconTranslateY 0.5s forwards;
    -moz-animation: iconTranslateY 0.5s forwards;
    -o-animation: iconTranslateY 0.5s forwards;
    animation: iconTranslateY 0.5s forwards;
}

.info-buttons .info-five {
    padding-left: 60px;
    color: #fff;
    background-color: #00b8d8;
    border-color: #00b8d8;
}

@media (max-width: 767px) {
    .info-buttons .info-five {
        padding-left: 40px;
    }
}

.info-buttons .info-five span {
    position: absolute;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
    overflow: hidden;
    left: 30px;
    line-height: normal;
}

@media (max-width: 767px) {
    .info-buttons .info-five span {
        left: 15px;
    }
}

.info-buttons .info-five:hover {
    color: #00b8d8;
    background-color: transparent;
}

.info-buttons .info-five:hover i {
    -webkit-animation: iconTranslateY 0.5s forwards;
    -moz-animation: iconTranslateY 0.5s forwards;
    -o-animation: iconTranslateY 0.5s forwards;
    animation: iconTranslateY 0.5s forwards;
}

.info-buttons .info-six {
    padding-right: 60px;
    overflow: hidden;
    line-height: 52px;
    color: #fff;
    border: 0;
    background: -webkit-linear-gradient(left, #00b8d8 0%, #32fbfc 50%, #00b8d8 100%);
    background: -o-linear-gradient(left, #00b8d8 0%, #32fbfc 50%, #00b8d8 100%);
    background: linear-gradient(to right, #00b8d8 0%, #32fbfc 50%, #00b8d8 100%);
    background-size: 200% auto;
}

@media only screen and (min-width: 768px) and (max-width: 991px) {
    .info-buttons .info-six {
        line-height: 44px;
    }
}

@media (max-width: 767px) {
    .info-buttons .info-six {
        padding-right: 40px;
        line-height: 44px;
    }
}

.info-buttons .info-six span {
    position: absolute;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
    overflow: hidden;
    right: 30px;
    line-height: normal;
}

@media (max-width: 767px) {
    .info-buttons .info-six span {
        right: 15px;
    }
}

.info-buttons .info-six:hover {
    background-position: right center;
}

.info-buttons .info-six:hover i {
    -webkit-animation: iconTranslateY 0.5s forwards;
    -moz-animation: iconTranslateY 0.5s forwards;
    -o-animation: iconTranslateY 0.5s forwards;
    animation: iconTranslateY 0.5s forwards;
}


/*===== Danger Buttons =====*/

.danger-buttons ul li {
    display: inline-block;
    margin-left: 18px;
    margin-top: 20px;
}

@media (max-width: 767px) {
    .danger-buttons ul li {
        margin-left: 0;
    }
}

.danger-buttons ul li:first-child {
    margin-left: 0;
}

.danger-buttons .danger-one {
    border-color: #fc3832;
    color: #fc3832;
}

.danger-buttons .danger-one:hover {
    color: #fc3832;
    background-color: rgba(252, 56, 50, 0.4);
}

.danger-buttons .danger-two {
    color: #fff;
    background-color: #fc3832;
    border-color: #fc3832;
}

.danger-buttons .danger-two:hover {
    color: #fc3832;
    background-color: transparent;
}

.danger-buttons .danger-three {
    overflow: hidden;
    line-height: 52px;
    color: #fff;
    border: 0;
    background: -webkit-linear-gradient(left, #fc3832 0%, #dc312b 50%, #fc3832 100%);
    background: -o-linear-gradient(left, #fc3832 0%, #dc312b 50%, #fc3832 100%);
    background: linear-gradient(to right, #fc3832 0%, #dc312b 50%, #fc3832 100%);
    background-size: 200% auto;
}

@media only screen and (min-width: 768px) and (max-width: 991px) {
    .danger-buttons .danger-three {
        line-height: 44px;
    }
}

@media (max-width: 767px) {
    .danger-buttons .danger-three {
        line-height: 44px;
    }
}

.danger-buttons .danger-three:hover {
    background-position: right center;
}

.danger-buttons .danger-four {
    padding-left: 60px;
    border-color: #fc3832;
    color: #fc3832;
}

@media (max-width: 767px) {
    .danger-buttons .danger-four {
        padding-left: 40px;
    }
}

.danger-buttons .danger-four span {
    position: absolute;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
    overflow: hidden;
    left: 30px;
    line-height: normal;
}

@media (max-width: 767px) {
    .danger-buttons .danger-four span {
        left: 15px;
    }
}

.danger-buttons .danger-four:hover {
    color: #fc3832;
    background-color: rgba(252, 56, 50, 0.4);
}

.danger-buttons .danger-four:hover i {
    -webkit-animation: iconTranslateY 0.5s forwards;
    -moz-animation: iconTranslateY 0.5s forwards;
    -o-animation: iconTranslateY 0.5s forwards;
    animation: iconTranslateY 0.5s forwards;
}

.danger-buttons .danger-five {
    padding-left: 60px;
    color: #fff;
    background-color: #fc3832;
    border-color: #fc3832;
}

@media (max-width: 767px) {
    .danger-buttons .danger-five {
        padding-left: 40px;
    }
}

.danger-buttons .danger-five span {
    position: absolute;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
    overflow: hidden;
    left: 30px;
    line-height: normal;
}

@media (max-width: 767px) {
    .danger-buttons .danger-five span {
        left: 15px;
    }
}

.danger-buttons .danger-five:hover {
    color: #fc3832;
    background-color: transparent;
}

.danger-buttons .danger-five:hover i {
    -webkit-animation: iconTranslateY 0.5s forwards;
    -moz-animation: iconTranslateY 0.5s forwards;
    -o-animation: iconTranslateY 0.5s forwards;
    animation: iconTranslateY 0.5s forwards;
}

.danger-buttons .danger-six {
    padding-right: 60px;
    overflow: hidden;
    line-height: 52px;
    color: #fff;
    border: 0;
    background: -webkit-linear-gradient(left, #fc3832 0%, #dc312b 50%, #fc3832 100%);
    background: -o-linear-gradient(left, #fc3832 0%, #dc312b 50%, #fc3832 100%);
    background: linear-gradient(to right, #fc3832 0%, #dc312b 50%, #fc3832 100%);
    background-size: 200% auto;
}

@media only screen and (min-width: 768px) and (max-width: 991px) {
    .danger-buttons .danger-six {
        line-height: 44px;
    }
}

@media (max-width: 767px) {
    .danger-buttons .danger-six {
        padding-right: 40px;
        line-height: 44px;
    }
}

.danger-buttons .danger-six span {
    position: absolute;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
    overflow: hidden;
    right: 30px;
    line-height: normal;
}

@media (max-width: 767px) {
    .danger-buttons .danger-six span {
        right: 15px;
    }
}

.danger-buttons .danger-six:hover {
    background-position: right center;
}

.danger-buttons .danger-six:hover i {
    -webkit-animation: iconTranslateY 0.5s forwards;
    -moz-animation: iconTranslateY 0.5s forwards;
    -o-animation: iconTranslateY 0.5s forwards;
    animation: iconTranslateY 0.5s forwards;
}

@-webkit-keyframes iconTranslateY {
    49% {
        -webkit-transform: translateY(100%);
    }
    50% {
        opacity: 0;
        -webkit-transform: translateY(-100%);
    }
    51% {
        opacity: 1;
    }
}

@-moz-keyframes iconTranslateY {
    49% {
        -webkit-transform: translateY(100%);
    }
    50% {
        opacity: 0;
        -webkit-transform: translateY(-100%);
    }
    51% {
        opacity: 1;
    }
}

@keyframes iconTranslateY {
    49% {
        -webkit-transform: translateY(100%);
    }
    50% {
        opacity: 0;
        -webkit-transform: translateY(-100%);
    }
    51% {
        opacity: 1;
    }
}

.lg-btn {
    line-height: 64px !important;
    font-size: 18px;
}

@media (max-width: 767px) {
    .lg-btn {
        font-size: 16px;
        ine-height: 52px;
    }
}

.el-btn {
    line-height: 80px !important;
    font-size: 20px;
}

@media (max-width: 767px) {
    .el-btn {
        font-size: 18px;
        line-height: 74px;
    }
}

.sm-btn {
    line-height: 40px !important;
    font-size: 12px;
}


/*===== Regular Icon Buttons =====*/

.regular-icon-buttons ul li {
    display: inline-block;
    margin-left: 10px;
    margin-top: 20px;
}

.regular-icon-buttons ul li:first-child {
    margin-left: 0;
}

.regular-icon-buttons ul li .regular-icon-light-one {
    width: 40px;
    height: 40px;
    line-height: 36px;
    border: 2px solid #0067f4;
    text-align: center;
    font-size: 24px;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
    overflow: hidden;
    color: #0067f4;
}

.regular-icon-buttons ul li .regular-icon-light-one:hover {
    color: #fff;
    background-color: #0067f4;
}

.regular-icon-buttons ul li .regular-icon-light-two {
    width: 40px;
    height: 40px;
    line-height: 36px;
    border: 2px solid #0067f4;
    text-align: center;
    font-size: 24px;
    border-radius: 5px;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
    overflow: hidden;
    color: #0067f4;
}

.regular-icon-buttons ul li .regular-icon-light-two:hover {
    color: #fff;
    background-color: #0067f4;
}

.regular-icon-buttons ul li .regular-icon-light-three {
    width: 40px;
    height: 40px;
    line-height: 36px;
    border: 2px solid #0067f4;
    text-align: center;
    font-size: 24px;
    border-radius: 10px;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
    overflow: hidden;
    color: #0067f4;
}

.regular-icon-buttons ul li .regular-icon-light-three:hover {
    color: #fff;
    background-color: #0067f4;
}

.regular-icon-buttons ul li .regular-icon-light-four {
    width: 40px;
    height: 40px;
    line-height: 36px;
    border: 2px solid #0067f4;
    text-align: center;
    font-size: 24px;
    border-radius: 50%;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
    overflow: hidden;
}

.regular-icon-buttons ul li .regular-icon-light-four:hover {
    color: #fff;
    background-color: #0067f4;
}

.regular-icon-buttons ul li .regular-icon-light-five {
    width: 40px;
    height: 40px;
    line-height: 40px;
    border: 0;
    text-align: center;
    font-size: 24px;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
    position: relative;
    z-index: 5;
    overflow: hidden;
    color: #fff;
    background: -webkit-linear-gradient(left, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: -o-linear-gradient(left, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: linear-gradient(to right, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background-size: 200% auto;
}

.regular-icon-buttons ul li .regular-icon-light-five:hover {
    background-position: right center;
}

.regular-icon-buttons ul li .regular-icon-light-six {
    width: 40px;
    height: 40px;
    line-height: 40px;
    border: 0;
    text-align: center;
    font-size: 24px;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
    position: relative;
    z-index: 5;
    overflow: hidden;
    color: #fff;
    background: -webkit-linear-gradient(left, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: -o-linear-gradient(left, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: linear-gradient(to right, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background-size: 200% auto;
    border-radius: 5px;
}

.regular-icon-buttons ul li .regular-icon-light-six:hover {
    background-position: right center;
}

.regular-icon-buttons ul li .regular-icon-light-seven {
    width: 40px;
    height: 40px;
    line-height: 40px;
    border: 0;
    text-align: center;
    font-size: 24px;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
    position: relative;
    z-index: 5;
    overflow: hidden;
    color: #fff;
    background: -webkit-linear-gradient(left, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: -o-linear-gradient(left, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: linear-gradient(to right, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background-size: 200% auto;
    border-radius: 10px;
}

.regular-icon-buttons ul li .regular-icon-light-seven:hover {
    background-position: right center;
}

.regular-icon-buttons ul li .regular-icon-light-eight {
    width: 40px;
    height: 40px;
    line-height: 40px;
    border: 0;
    text-align: center;
    font-size: 24px;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
    position: relative;
    z-index: 5;
    overflow: hidden;
    color: #fff;
    background: -webkit-linear-gradient(left, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: -o-linear-gradient(left, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: linear-gradient(to right, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background-size: 200% auto;
    border-radius: 50%;
}

.regular-icon-buttons ul li .regular-icon-light-eight:hover {
    background-position: right center;
}

.regular-icon-buttons ul li .regular-icon-light-nine {
    width: 40px;
    height: 40px;
    line-height: 36px;
    border: 2px solid #0067f4;
    text-align: center;
    font-size: 24px;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
    overflow: hidden;
    color: #fff;
    background-color: #0067f4;
}

.regular-icon-buttons ul li .regular-icon-light-nine:hover {
    color: #0067f4;
    background-color: transparent;
}

.regular-icon-buttons ul li .regular-icon-light-ten {
    width: 40px;
    height: 40px;
    line-height: 36px;
    border: 2px solid #0067f4;
    text-align: center;
    font-size: 24px;
    border-radius: 5px;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
    overflow: hidden;
    color: #fff;
    background-color: #0067f4;
}

.regular-icon-buttons ul li .regular-icon-light-ten:hover {
    color: #0067f4;
    background-color: transparent;
}

.regular-icon-buttons ul li .regular-icon-light-eleven {
    width: 40px;
    height: 40px;
    line-height: 36px;
    border: 2px solid #0067f4;
    text-align: center;
    font-size: 24px;
    border-radius: 10px;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
    overflow: hidden;
    color: #fff;
    background-color: #0067f4;
}

.regular-icon-buttons ul li .regular-icon-light-eleven:hover {
    color: #0067f4;
    background-color: transparent;
}

.regular-icon-buttons ul li .regular-icon-light-twelve {
    width: 40px;
    height: 40px;
    line-height: 36px;
    border: 2px solid #0067f4;
    text-align: center;
    font-size: 24px;
    border-radius: 50%;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
    overflow: hidden;
    color: #fff;
    background-color: #0067f4;
}

.regular-icon-buttons ul li .regular-icon-light-twelve:hover {
    color: #0067f4;
    background-color: transparent;
}


/*===== Group Buttons =====*/

.group-buttons .btn-group {
    margin-left: 30px;
}

.group-buttons .group-one {
    margin-left: 0;
}

.group-buttons .group-one .main-btn {
    background: none;
    border: 2px solid #0067f4;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
}

.group-buttons .group-one .main-btn:first-child {
    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;
    border-right: 0;
}

.group-buttons .group-one .main-btn:last-child {
    border-top-right-radius: 5px;
    border-bottom-right-radius: 5px;
    border-left: 0;
}

.group-buttons .group-one .main-btn:hover {
    background-color: #0067f4;
    color: #fff;
}

.group-buttons .group-two .main-btn {
    background: none;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
    overflow: hidden;
    color: #fff;
    line-height: 52px;
    background: -webkit-linear-gradient(#0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: -o-linear-gradient(#0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: linear-gradient(#0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background-size: auto 200%;
    border-top: 0;
    border-bottom: 0;
    border-color: rgba(244, 246, 247, 0.2);
}

.group-buttons .group-two .main-btn:first-child {
    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;
    border-right: 0;
}

.group-buttons .group-two .main-btn:last-child {
    border-top-right-radius: 5px;
    border-bottom-right-radius: 5px;
    border-left: 0;
}

.group-buttons .group-two .main-btn:hover {
    background-position: bottom center;
}

.group-buttons .group-three .main-btn {
    background: none;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
    overflow: hidden;
    color: #fff;
    line-height: 52px;
    background: -webkit-linear-gradient(left, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: -o-linear-gradient(left, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: linear-gradient(to right, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background-size: 200% auto;
    border: 0;
}

.group-buttons .group-three .main-btn:first-child {
    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;
    border-right: 0;
}

.group-buttons .group-three .main-btn:last-child {
    border-top-right-radius: 5px;
    border-bottom-right-radius: 5px;
    border-left: 0;
}

.group-buttons .group-three .main-btn:hover {
    background-position: right center;
}

.group-buttons .group-four {
    margin-left: 0;
}

.group-buttons .group-four .main-btn {
    background: none;
    border: 2px solid #0067f4;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
    padding: 0 12px;
}

.group-buttons .group-four .main-btn i {
    font-size: 24px;
}

.group-buttons .group-four .main-btn:first-child {
    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;
    border-right: 0;
}

.group-buttons .group-four .main-btn:last-child {
    border-top-right-radius: 5px;
    border-bottom-right-radius: 5px;
    border-left: 0;
}

.group-buttons .group-four .main-btn:hover {
    background-color: #0067f4;
    color: #fff;
}

.group-buttons .group-five .main-btn {
    background: none;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
    overflow: hidden;
    color: #fff;
    line-height: 52px;
    background: -webkit-linear-gradient(#0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: -o-linear-gradient(#0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: linear-gradient(#0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background-size: auto 200%;
    border-top: 0;
    border-bottom: 0;
    border-color: rgba(244, 246, 247, 0.2);
    padding: 0 16px;
}

.group-buttons .group-five .main-btn:first-child {
    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;
    border-right: 0;
}

.group-buttons .group-five .main-btn:last-child {
    border-top-right-radius: 5px;
    border-bottom-right-radius: 5px;
    border-left: 0;
}

.group-buttons .group-five .main-btn:hover {
    background-position: bottom center;
}

.group-buttons .group-six .main-btn {
    background: none;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
    overflow: hidden;
    color: #fff;
    line-height: 52px;
    background: -webkit-linear-gradient(left, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: -o-linear-gradient(left, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background: linear-gradient(to right, #0067f4 0%, #2bdbdc 50%, #0067f4 100%);
    background-size: 200% auto;
    border: 0;
    padding: 0 16px;
}

.group-buttons .group-six .main-btn:first-child {
    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;
    border-right: 0;
}

.group-buttons .group-six .main-btn:last-child {
    border-top-right-radius: 5px;
    border-bottom-right-radius: 5px;
    border-left: 0;
}

.group-buttons .group-six .main-btn:hover {
    background-position: right center;
}


/*===========================
    06.FORM ELEMENTS css
===========================*/

.form-elements-title {
    font-size: 36px;
    font-weight: 600;
    line-height: 45px;
    color: #6c6c6c;
}

@media (max-width: 767px) {
    .form-elements-title {
        font-size: 24px;
        line-height: 35px;
    }
}

.form-group {
    margin-bottom: 0;
}

.form-input .help-block {
    margin-top: 2px;
}

.form-input .help-block .list-unstyled li {
    font-size: 12px;
    line-height: 16px;
    color: #fc3832;
}

.form-input label {
    font-size: 12px;
    line-height: 18px;
    color: #6c6c6c;
    margin-bottom: 8px;
    display: inline-block;
}

.form-input .input-items {
    position: relative;
}

.form-input .input-items input,
.form-input .input-items textarea {
    width: 100%;
    height: 44px;
    border: 2px solid;
    padding-left: 44px;
    padding-right: 12px;
    position: relative;
    font-size: 16px;
}

.form-input .input-items textarea {
    padding-top: 8px;
    height: 130px;
    resize: none;
}

.form-input .input-items i {
    position: absolute;
    top: 11px;
    left: 13px;
    font-size: 20px;
    z-index: 9;
}

.form-input .input-items.default input,
.form-input .input-items.default textarea {
    border-color: #a4a4a4;
    color: #6c6c6c;
}

.form-input .input-items.default input:focus,
.form-input .input-items.default textarea:focus {
    border-color: #0067f4;
}

.form-input .input-items.default input::placeholder,
.form-input .input-items.default textarea::placeholder {
    color: #6c6c6c;
    opacity: 1;
}

.form-input .input-items.default input::-moz-placeholder,
.form-input .input-items.default textarea::-moz-placeholder {
    color: #6c6c6c;
    opacity: 1;
}

.form-input .input-items.default input::-moz-placeholder,
.form-input .input-items.default textarea::-moz-placeholder {
    color: #6c6c6c;
    opacity: 1;
}

.form-input .input-items.default input::-webkit-input-placeholder,
.form-input .input-items.default textarea::-webkit-input-placeholder {
    color: #6c6c6c;
    opacity: 1;
}

.form-input .input-items.default i {
    color: #6c6c6c;
}

.form-input .input-items.active input,
.form-input .input-items.active textarea {
    border-color: #0067f4;
    color: #121212;
}

.form-input .input-items.active input::placeholder,
.form-input .input-items.active textarea::placeholder {
    color: #121212;
    opacity: 1;
}

.form-input .input-items.active input::-moz-placeholder,
.form-input .input-items.active textarea::-moz-placeholder {
    color: #121212;
    opacity: 1;
}

.form-input .input-items.active input::-moz-placeholder,
.form-input .input-items.active textarea::-moz-placeholder {
    color: #121212;
    opacity: 1;
}

.form-input .input-items.active input::-webkit-input-placeholder,
.form-input .input-items.active textarea::-webkit-input-placeholder {
    color: #121212;
    opacity: 1;
}

.form-input .input-items.active i {
    color: #0067f4;
}

.form-input .input-items.error input,
.form-input .input-items.error textarea {
    border-color: #fc3832;
    color: #fc3832;
}

.form-input .input-items.error input::placeholder,
.form-input .input-items.error textarea::placeholder {
    color: #fc3832;
    opacity: 1;
}

.form-input .input-items.error input::-moz-placeholder,
.form-input .input-items.error textarea::-moz-placeholder {
    color: #fc3832;
    opacity: 1;
}

.form-input .input-items.error input::-moz-placeholder,
.form-input .input-items.error textarea::-moz-placeholder {
    color: #fc3832;
    opacity: 1;
}

.form-input .input-items.error input::-webkit-input-placeholder,
.form-input .input-items.error textarea::-webkit-input-placeholder {
    color: #fc3832;
    opacity: 1;
}

.form-input .input-items.error i {
    color: #fc3832;
}

.form-input .input-items.success input,
.form-input .input-items.success textarea {
    border-color: #4da422;
    color: #4da422;
}

.form-input .input-items.success input::placeholder,
.form-input .input-items.success textarea::placeholder {
    color: #4da422;
    opacity: 1;
}

.form-input .input-items.success input::-moz-placeholder,
.form-input .input-items.success textarea::-moz-placeholder {
    color: #4da422;
    opacity: 1;
}

.form-input .input-items.success input::-moz-placeholder,
.form-input .input-items.success textarea::-moz-placeholder {
    color: #4da422;
    opacity: 1;
}

.form-input .input-items.success input::-webkit-input-placeholder,
.form-input .input-items.success textarea::-webkit-input-placeholder {
    color: #4da422;
    opacity: 1;
}

.form-input .input-items.success i {
    color: #4da422;
}

.form-input .input-items.disabled input,
.form-input .input-items.disabled textarea {
    border-color: #a4a4a4;
    color: #6c6c6c;
    background: none;
}

.form-input .input-items.disabled input::placeholder,
.form-input .input-items.disabled textarea::placeholder {
    color: #6c6c6c;
    opacity: 1;
}

.form-input .input-items.disabled input::-moz-placeholder,
.form-input .input-items.disabled textarea::-moz-placeholder {
    color: #6c6c6c;
    opacity: 1;
}

.form-input .input-items.disabled input::-moz-placeholder,
.form-input .input-items.disabled textarea::-moz-placeholder {
    color: #6c6c6c;
    opacity: 1;
}

.form-input .input-items.disabled input::-webkit-input-placeholder,
.form-input .input-items.disabled textarea::-webkit-input-placeholder {
    color: #6c6c6c;
    opacity: 1;
}

.form-input .input-items.disabled i {
    color: #6c6c6c;
}

.form-style-two .form-input .input-items input,
.form-style-two .form-input .input-items textarea {
    border-radius: 5px;
    padding-left: 12px;
    padding-right: 44px;
}

.form-style-two .form-input .input-items i {
    left: auto;
    right: 13px;
}

.form-style-three .form-input {
    text-align: center;
}

.form-style-three .form-input .input-items input,
.form-style-three .form-input .input-items textarea {
    border-radius: 50px;
    text-align: center;
}

.form-style-four .form-input label {
    padding-left: 44px;
    margin-bottom: 0;
}

.form-style-four .form-input .input-items input,
.form-style-four .form-input .input-items textarea {
    border-top: 0;
    border-left: 0;
    border-right: 0;
}

.form-style-five .form-input {
    position: relative;
}

.form-style-five .form-input label {
    position: absolute;
    top: -10px;
    left: 10px;
    background-color: #fff;
    z-index: 5;
    padding: 0 5px;
}

.form-style-five .form-input .input-items input,
.form-style-five .form-input .input-items textarea {
    border-radius: 5px;
}


/*===========================
        09.NAVBAR css
===========================*/

.navbar-area {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    padding: 10px 0;
    z-index: 99;
}

.navbar-area .navbar {
    position: relative;
    padding: 0;
}

.navbar-area .navbar .navbar-toggler .toggler-icon {
    width: 30px;
    height: 2px;
    background-color: #fff;
    margin: 5px 0;
    display: block;
    position: relative;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
}

.navbar-area .navbar .navbar-toggler.active .toggler-icon:nth-of-type(1) {
    -webkit-transform: rotate(45deg);
    -moz-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    -o-transform: rotate(45deg);
    transform: rotate(45deg);
    top: 7px;
}

.navbar-area .navbar .navbar-toggler.active .toggler-icon:nth-of-type(2) {
    opacity: 0;
}

.navbar-area .navbar .navbar-toggler.active .toggler-icon:nth-of-type(3) {
    -webkit-transform: rotate(135deg);
    -moz-transform: rotate(135deg);
    -ms-transform: rotate(135deg);
    -o-transform: rotate(135deg);
    transform: rotate(135deg);
    top: -7px;
}

@media only screen and (min-width: 768px) and (max-width: 991px) {
    .navbar-area .navbar .navbar-collapse {
        position: absolute;
        top: 115%;
        left: 0;
        width: 100%;
        background-color: #f4f6f7;
        z-index: 8;
        padding: 10px 0;
        -webkit-box-shadow: 0px 10px 25px 0px rgba(18, 18, 18, 0.05);
        -moz-box-shadow: 0px 10px 25px 0px rgba(18, 18, 18, 0.05);
        box-shadow: 0px 10px 25px 0px rgba(18, 18, 18, 0.05);
    }
}

@media (max-width: 767px) {
    .navbar-area .navbar .navbar-collapse {
        position: absolute;
        top: 115%;
        left: 0;
        width: 100%;
        background-color: rgb(113 2 2);
        z-index: 8;
        padding: 10px 0;
        -webkit-box-shadow: 0px 10px 25px 0px rgba(18, 18, 18, 0.05);
        -moz-box-shadow: 0px 10px 25px 0px rgba(18, 18, 18, 0.05);
        box-shadow: 0px 10px 25px 0px rgba(18, 18, 18, 0.05);
    }
}

.navbar-area .navbar .navbar-nav .nav-item {
    margin: 0 16px;
    position: relative;
}

.navbar-area .navbar .navbar-nav .nav-item a {
    font-size: 16px;
    line-height: 24px;
    font-weight: 700;
    padding: 10px 0;
    color: #fff;
    text-transform: uppercase;
    position: relative;
    opacity: 0.8;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
}

@media only screen and (min-width: 768px) and (max-width: 991px) {
    .navbar-area .navbar .navbar-nav .nav-item a {
        padding: 10px 0;
        display: block;
        color: #121212;
    }
}

@media (max-width: 767px) {
    .navbar-area .navbar .navbar-nav .nav-item a {
        padding: 10px 0;
        display: block;
        color: #121212;
    }
}

.navbar-area .navbar .navbar-nav .nav-item a::before {
    position: absolute;
    content: '';
    width: 32px;
    height: 4px;
    background: -webkit-linear-gradient(left, rgba(255, 255, 255, 0.1) 0%, white 100%);
    background: -o-linear-gradient(left, rgba(255, 255, 255, 0.1) 0%, white 100%);
    background: linear-gradient(to right, rgba(255, 255, 255, 0.1) 0%, white 100%);
    left: 50%;
    margin: 0 2px;
    bottom: 14px;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
    -webkit-transform: translate(-50%) scaleX(0);
    -moz-transform: translate(-50%) scaleX(0);
    -ms-transform: translate(-50%) scaleX(0);
    -o-transform: translate(-50%) scaleX(0);
    transform: translate(-50%) scaleX(0);
}

@media only screen and (min-width: 768px) and (max-width: 991px) {
    .navbar-area .navbar .navbar-nav .nav-item a::before {
        display: none;
    }
}

@media (max-width: 767px) {
    .navbar-area .navbar .navbar-nav .nav-item a::before {
        display: none;
    }
}

.navbar-area .navbar .navbar-nav .nav-item.active>a,
.navbar-area .navbar .navbar-nav .nav-item:hover>a {
    opacity: 1;
    color: #fff;
}

@media only screen and (min-width: 768px) and (max-width: 991px) {
    .navbar-area .navbar .navbar-nav .nav-item.active>a,
    .navbar-area .navbar .navbar-nav .nav-item:hover>a {
        color: #121212;
    }
}

@media (max-width: 767px) {
    .navbar-area .navbar .navbar-nav .nav-item.active>a,
    .navbar-area .navbar .navbar-nav .nav-item:hover>a {
        color: #121212;
    }
}



@media only screen and (min-width: 768px) and (max-width: 991px) {
    .navbar-area .navbar .navbar-btn {
        position: absolute;
        right: 70px;
        top: 7px;
    }
}

@media (max-width: 767px) {
    .navbar-area .navbar .navbar-btn {
        position: absolute;
        right: 60px;
        top: 7px;
    }
}

.navbar-area .navbar .navbar-btn li {
    display: inline-block;
    margin-right: 5px;
}

.navbar-area .navbar .navbar-btn li a {
    padding: 10px 16px;
    font-size: 16px;
    text-transform: uppercase;
    font-weight: 700;
    color: #fff;
    border: 2px solid;
    border-radius: 4px;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
}

.navbar-area .navbar .navbar-btn li a.light {
    border-color: #fff;
}

.navbar-area .navbar .navbar-btn li a.light:hover {
    background-color: rgba(255, 255, 255, 0.4);
}

.navbar-area .navbar .navbar-btn li a.solid {
    background-color: #fff;
    border-color: #fff;
    color: #0067f4;
}

.navbar-area .navbar .navbar-btn li a.solid:hover {
    background-color: transparent;
    color: #fff;
}

.navbar-area.sticky {
    background-color: rgb(113 2 2);
    z-index: 999;
    position: fixed;
    -webkit-box-shadow: 0px 10px 25px 0px rgba(18, 18, 18, 0.05);
    -moz-box-shadow: 0px 10px 25px 0px rgba(18, 18, 18, 0.05);
    box-shadow: 0px 19px 50px 0px rgb(21 18 18 / 25%);
}

.navbar-area.sticky .navbar .navbar-toggler .toggler-icon {
    background-color: #FFFFFF;
}

.navbar-area.sticky .navbar .navbar-nav .nav-item a {
    color: #ffffff;
}

.navbar-area.sticky .navbar .navbar-nav .nav-item a::before {
    background: -webkit-linear-gradient(left, rgba(18, 18, 18, 0) 0%, #121212 100%);
    background: -o-linear-gradient(left, rgba(18, 18, 18, 0) 0%, #121212 100%);
    background: linear-gradient(to right, rgba(18, 18, 18, 0) 0%, #121212 100%);
}

.navbar-area.sticky .navbar .navbar-nav .nav-item.active,
.navbar-area.sticky .navbar .navbar-nav .nav-item:hover {
    color: #121212;
    opacity: 1;
}

.navbar-area.sticky .navbar .navbar-btn li a.light {
    border-color: #0067f4;
    color: #0067f4;
}

.navbar-area.sticky .navbar .navbar-btn li a.solid {
    border-color: #0067f4;
    background-color: #0067f4;
    color: #fff;
}


/*===========================
       10.SLIDER css
===========================*/

.carousel-item {
    background-color: #0067f4;
    position: relative;
}


/*.carousel-item::before {*/


/*    position: absolute;*/


/*    content: '';*/


/*    width: 33%;*/


/*    height: 100%;*/


/*    background: -webkit-linear-gradient(rgba(0, 103, 244, 0.3) 0%, rgba(43, 219, 220, 0.3) 100%);*/


/*    background: -o-linear-gradient(rgba(0, 103, 244, 0.3) 0%, rgba(43, 219, 220, 0.3) 100%);*/


/*    background: linear-gradient(rgba(0, 103, 244, 0.3) 0%, rgba(43, 219, 220, 0.3) 100%);*/


/*    top: 0;*/


/*    right: 15%;*/


/*    -webkit-transform: skewX(20deg);*/


/*    -moz-transform: skewX(20deg);*/


/*    -ms-transform: skewX(20deg);*/


/*    -o-transform: skewX(20deg);*/


/*    transform: skewX(20deg);*/


/*}*/

@media only screen and (min-width: 992px) and (max-width: 1199px) {
    /*.carousel-item::before {*/
    /*    width: 40%;*/
    /*}*/
}

@media only screen and (min-width: 768px) and (max-width: 991px) {
    /*.carousel-item::before {*/
    /*    width: 60%;*/
    /*}*/
}

@media (max-width: 767px) {
    /*.carousel-item::before {*/
    /*    width: 50%;*/
    /*    right: 45%;*/
    /*}*/
}

@media only screen and (min-width: 576px) and (max-width: 767px) {
    /*.carousel-item::before {*/
    /*    right: 25%;*/
    /*}*/
}

.carousel-item .slider-image-box {
    position: absolute;
    top: 0;
    right: 0;
    width: 50%;
    height: 100%;
    z-index: 9;
}

.carousel-item .slider-image-box .slider-image {
    max-width: 680px;
    width: 100%;
}

.slider-content {
    position: relative;
    z-index: 9;
    padding-top: 240px;
    padding-bottom: 200px;
}

@media (max-width: 767px) {
    .slider-content {
        padding-top: 190px;
        padding-bottom: 150px;
    }
}

.slider-content .title {
    font-size: 88px;
    line-height: 96px;
    color: #fff;
    font-weight: 700;
}

@media only screen and (min-width: 992px) and (max-width: 1199px) {
    .slider-content .title {
        font-size: 58px;
        line-height: 80px;
    }
}

@media only screen and (min-width: 768px) and (max-width: 991px) {
    .slider-content .title {
        font-size: 72px;
        line-height: 90px;
    }
}

@media (max-width: 767px) {
    .slider-content .title {
        font-size: 34px;
        line-height: 45px;
    }
}

.slider-content .text {
    color: #fff;
    font-size: 16px;
    line-height: 24px;
    margin-top: 16px;
}

.slider-content .slider-btn {
    padding-top: 16px;
}

.slider-content .slider-btn li {
    display: inline-block;
    margin: 16px 8px 0;
}

@media (max-width: 767px) {
    .slider-content .slider-btn li {
        margin: 16px 3px 0;
    }
}

.slider-content .slider-btn li a.rounded-one {
    background-color: #fff;
    border-color: #fff;
}

.slider-content .slider-btn li a.rounded-one:hover {
    background-color: transparent;
    color: #fff;
}

.slider-content .slider-btn li a.rounded-two {
    border-color: #fff;
}

.slider-content .slider-btn li a.rounded-two:hover {
    background-color: #fff;
    color: #0067f4;
}

.carousel-indicators {
    margin-bottom: 50px;
}

.carousel-indicators li {
    display: block;
    width: 8px;
    height: 8px;
    background-color: rgba(255, 255, 255, 0.5);
    border-radius: 50px;
    border: 0;
    margin: 0px 2px;
}

@media only screen and (min-width: 768px) and (max-width: 991px) {
    .carousel-indicators li {
        width: 13px;
        height: 13px;
    }
}

@media (max-width: 767px) {
    .carousel-indicators li {
        width: 13px;
        height: 13px;
    }
}

.carousel-indicators li.active {
    background-color: #fff;
    width: 16px;
    border-radius: 50px;
}

@media only screen and (min-width: 768px) and (max-width: 991px) {
    .carousel-indicators li.active {
        width: 23px;
    }
}

@media (max-width: 767px) {
    .carousel-indicators li.active {
        width: 23px;
    }
}

.carousel .carousel-control-prev,
.carousel .carousel-control-next {
    top: 50%;
    font-size: 32px;
    color: #fff;
    bottom: auto;
    left: 60px;
    right: auto;
    opacity: 1;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
    z-index: 99;
    width: 48px;
    height: 48px;
    line-height: 48px;
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 5px;
}

@media only screen and (min-width: 992px) and (max-width: 1199px) {
    .carousel .carousel-control-prev,
    .carousel .carousel-control-next {
        left: 30px;
    }
}

@media only screen and (min-width: 768px) and (max-width: 991px) {
    .carousel .carousel-control-prev,
    .carousel .carousel-control-next {
        display: none;
    }
}

@media (max-width: 767px) {
    .carousel .carousel-control-prev,
    .carousel .carousel-control-next {
        display: none;
    }
}

.carousel .carousel-control-next {
    right: 60px;
    left: auto;
}

@media only screen and (min-width: 992px) and (max-width: 1199px) {
    .carousel .carousel-control-next {
        right: 30px;
    }
}

@media only screen and (min-width: 768px) and (max-width: 991px) {
    .carousel .carousel-control-next {
        right: 30px;
    }
}

@media (max-width: 767px) {
    .carousel .carousel-control-next {
        right: 30px;
    }
}


/*===========================
      17.FEATURES css
===========================*/


/*===== features TWO =====*/

.features-area {
    background-color: #f4f6f7;
    padding-top: 120px;
    padding-bottom: 130px;
}

.single-features {
    padding: 40px 20px 52px;
    background-color: #fff;
}

.single-features .features-title-icon .features-title a {
    font-size: 36px;
    line-height: 45px;
    color: #121212;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
    font-weight: 400;
}

@media only screen and (min-width: 992px) and (max-width: 1199px) {
    .single-features .features-title-icon .features-title a {
        font-size: 24px;
        line-height: 35px;
    }
}

@media (max-width: 767px) {
    .single-features .features-title-icon .features-title a {
        font-size: 24px;
        line-height: 35px;
    }
}

@media only screen and (min-width: 576px) and (max-width: 767px) {
    .single-features .features-title-icon .features-title a {
        font-size: 36px;
        line-height: 45px;
    }
}

.single-features .features-title-icon .features-title a:hover {
    color: #0067f4;
}

.single-features .features-title-icon .features-icon {
    position: relative;
    display: inline-block;
}

.single-features .features-title-icon .features-icon i {
    font-size: 88px;
    line-height: 70px;
    color: #0067f4;
    position: relative;
    z-index: 5;
}

.single-features .features-title-icon .features-icon .shape {
    position: absolute;
    top: 0;
    left: 0;
}

.single-features .features-content .text {
    font-size: 14px;
    line-height: 20px;
    color: #121212;
    margin-top: 16px;
}

.single-features .features-content .features-btn {
    color: #0067f4;
    font-size: 16px;
    font-weight: 700;
    margin-top: 29px;
}


/*===========================
      18.PORTFOLIO css
===========================*/

.portfolio-area {
    padding-top: 5%;
}

.portfolio-menu ul li {
    font-size: 16px;
    font-weight: 700;
    color: #6c6c6c;
    line-height: 48px;
    padding: 0 30px;
    position: relative;
    z-index: 5;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
    cursor: pointer;
    width: 100%;
    border-radius: 50px;
    overflow: hidden;
    margin-top: 4px;
    text-transform: uppercase;
}

.portfolio-menu ul li:last-child {
    margin-right: 0;
}

@media only screen and (min-width: 768px) and (max-width: 991px) {
    .portfolio-menu ul li {
        font-size: 14px;
        padding: 0 26px;
    }
}

@media (max-width: 767px) {
    .portfolio-menu ul li {
        font-size: 14px;
        padding: 0 22px;
        line-height: 42px;
    }
}

.portfolio-menu ul li::before {
    position: absolute;
    content: '';
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    /*background: -webkit-linear-gradient(left, #0067f4 0%, #2bdbdc 100%);*/
    /*background: -o-linear-gradient(left, #0067f4 0%, #2bdbdc 100%);*/
    /*background: linear-gradient(to right, #0067f4 0%, #2bdbdc 100%);*/
    z-index: -1;
    opacity: 0;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
}

.portfolio-menu ul li:hover,
.portfolio-menu ul li.active {
    color: #fff;
}

.portfolio-menu ul li:hover::before,
.portfolio-menu ul li.active::before {
    opacity: 1;
}

.single-portfolio .portfolio-image {
    position: relative;
    overflow: hidden;
    padding: 2%;
    /* border: 1px dashed; */
    box-shadow: rgb(0 0 0 / 41%) 4px 2px 23px 0px;
}

.single-portfolio .portfolio-image img {
    width: 100%;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
}

.single-portfolio .portfolio-image .portfolio-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    visibility: hidden;
    -webkit-transition: all 0.5s ease-out 0s;
    -moz-transition: all 0.5s ease-out 0s;
    -ms-transition: all 0.5s ease-out 0s;
    -o-transition: all 0.5s ease-out 0s;
    transition: all 0.5s ease-out 0s;
    background-color: rgba(255, 255, 255, 0.8);
    -webkit-transform: scale(0.9);
    -moz-transform: scale(0.9);
    -ms-transform: scale(0.9);
    -o-transform: scale(0.9);
    transform: scale(0.9);
    border-radius: 8px;
}

.single-portfolio .portfolio-image .portfolio-overlay .portfolio-content {
    padding: 16px;
}

.single-portfolio .portfolio-image .portfolio-overlay .portfolio-content .portfolio-icon {
    position: relative;
    display: inline-block;
    margin: 0 20px;
}

.single-portfolio .portfolio-image .portfolio-overlay .portfolio-content .portfolio-icon a {
    font-size: 48px;
    color: #0067f4;
    position: relative;
    z-index: 5;
    line-height: 50px;
}

.single-portfolio .portfolio-image .portfolio-overlay .portfolio-content .portfolio-icon .shape {
    position: absolute;
    top: 7px;
    left: 0;
}

.single-portfolio:hover .portfolio-overlay {
    opacity: 1;
    visibility: visible;
}


/*===========================
      16.PRICING css
===========================*/

.pricing-area {
    background-color: #f4f6f7;
    padding-top: 120px;
    padding-bottom: 130px;
}


/*===== PRICING STYLE NINE =====*/

.pricing-style {
    -webkit-box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.16);
    -moz-box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.16);
    box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.16);
    padding: 24px 20px 38px;
    border-radius: 8px;
    position: relative;
    overflow: hidden;
    background: -webkit-linear-gradient(#2bdbdc 0%, #0067f4 100%);
    background: -o-linear-gradient(#2bdbdc 0%, #0067f4 100%);
    background: linear-gradient(#2bdbdc 0%, #0067f4 100%);
}

.pricing-style .pricing-icon img {
    width: 190px;
}

.pricing-style .pricing-header .sub-title {
    font-size: 20px;
    font-weight: 600;
    line-height: 25px;
    color: #fff;
    position: relative;
    margin-top: 24px;
}

.pricing-style .pricing-header .month {
    font-size: 20px;
    font-weight: 300;
    line-height: 25px;
    color: #fff;
    margin-top: 3px;
}

.pricing-style .pricing-header .month .price {
    font-size: 36px;
    font-weight: 600;
    line-height: 45px;
    color: #fff;
    margin-top: 8px;
}

@media only screen and (min-width: 576px) and (max-width: 767px) {
    .pricing-style .pricing-header .month .price {
        font-size: 24px;
        margin-top: 32px;
        line-height: 30px;
    }
}

.pricing-style .pricing-list {
    margin-top: 24px;
}

.pricing-style .pricing-list ul li {
    font-size: 16px;
    line-height: 24px;
    color: #fff;
    margin-top: 16px;
}

@media only screen and (min-width: 992px) and (max-width: 1199px) {
    .pricing-style .pricing-list ul li {
        font-size: 14px;
        margin-top: 12px;
    }
}

@media (max-width: 767px) {
    .pricing-style .pricing-list ul li {
        font-size: 14px;
        margin-top: 12px;
    }
}

@media only screen and (min-width: 576px) and (max-width: 767px) {
    .pricing-style .pricing-list ul li {
        font-size: 16px;
        margin-top: 16px;
    }
}

.pricing-style .pricing-list ul li i {
    color: #fff;
    margin-right: 8px;
}

.pricing-style .pricing-btn {
    margin-top: 31px;
}

.pricing-style .pricing-btn .main-btn {
    background-color: #fff;
    border-color: #fff;
}

.pricing-style .pricing-btn .main-btn:hover {
    color: #0067f4;
    -webkit-box-shadow: 0 3px 16px 0 rgba(0, 0, 0, 0.16);
    -moz-box-shadow: 0 3px 16px 0 rgba(0, 0, 0, 0.16);
    box-shadow: 0 3px 16px 0 rgba(0, 0, 0, 0.16);
}


/*===========================
       15.ABOUT css
===========================*/

.about-area {
    padding-top: 2%;
    position: relative;
}

.about-area .about-title .sub-title {
    font-size: 18px;
    font-weight: 400;
    color: #0067f4;
    text-transform: uppercase;
}

@media (max-width: 767px) {
    .about-area .about-title .sub-title {
        font-size: 16px;
    }
}

.about-area .about-title .title {
    font-size: 30px;
    padding-top: 10px;
}

@media only screen and (min-width: 992px) and (max-width: 1199px) {
    .about-area .about-title .title {
        font-size: 26px;
    }
}

@media (max-width: 767px) {
    .about-area .about-title .title {
        font-size: 22px;
    }
}

.about-area .about-accordion .accordion .card {
    border: 0;
    background: none;
}

.about-area .about-accordion .accordion .card .card-header {
    padding: 0;
    border: 0;
    background: none;
    margin-top: 40px;
}

.about-area .about-accordion .accordion .card .card-header a {
    font-size: 18px;
    font-weight: 500;
    color: #000;
    display: block;
    position: relative;
    padding-right: 20px;
}

@media only screen and (min-width: 992px) and (max-width: 1199px) {
    .about-area .about-accordion .accordion .card .card-header a {
        font-size: 16px;
    }
}

@media (max-width: 767px) {
    .about-area .about-accordion .accordion .card .card-header a {
        font-size: 16px;
    }
}



.about-area .about-accordion .accordion .card .card-body {
    padding: 20px 20px 0;
}

.about-area .about-image img {
    width: 100%;
}


/*===========================
      26.TESTIMONIAL css
===========================*/


/*===== TESTIMONIAL STYLE THREE =====*/

.testimonial-area {
    padding-top: 2%;
    background-color: #f4f6f7;
}

.testimonial-area .testimonial-left-content .sub-title {
    font-size: 18px;
    font-weight: 400;
    color: #0067f4;
    text-transform: uppercase;
}

@media (max-width: 767px) {
    .testimonial-area .testimonial-left-content .sub-title {
        font-size: 16px;
    }
}

.testimonial-area .testimonial-left-content .title {
    font-size: 32px;
    padding-top: 10px;
    color: #121212;
}

@media only screen and (min-width: 992px) and (max-width: 1199px) {
    .testimonial-area .testimonial-left-content .title {
        font-size: 30px;
    }
}

@media (max-width: 767px) {
    .testimonial-area .testimonial-left-content .title {
        font-size: 24px;
    }
}

.testimonial-area .testimonial-left-content .testimonial-line {
    padding-top: 10px;
}

.testimonial-area .testimonial-left-content .testimonial-line li {
    height: 5px;
    background-color: #0067f4;
    opacity: 0.2;
    display: inline-block;
    border-radius: 50px;
    margin-right: 3px;
}

.testimonial-area .testimonial-left-content .testimonial-line li:nth-of-type(1) {
    width: 40px;
}

.testimonial-area .testimonial-left-content .testimonial-line li:nth-of-type(2) {
    width: 15px;
}

.testimonial-area .testimonial-left-content .testimonial-line li:nth-of-type(3) {
    width: 10px;
}

.testimonial-area .testimonial-left-content .testimonial-line li:nth-of-type(4) {
    width: 5px;
}

.testimonial-area .testimonial-left-content .text {
    padding-top: 15px;
}

.testimonial-area .testimonial-right-content {
    position: relative;
    background-color: #e9ecef;
    -webkit-box-shadow: 0px 30px 70px 0px rgba(0, 0, 0, 0.07);
    -moz-box-shadow: 0px 30px 70px 0px rgba(0, 0, 0, 0.07);
    box-shadow: 0px 30px 70px 0px rgba(0, 0, 0, 0.07);
    border-radius: 50px;
    max-width: 500px;
    padding-top: 50px;
}

.testimonial-area .testimonial-right-content .quota {
    position: absolute;
    top: 10px;
    left: 15px;
    -webkit-transform: rotate(180deg);
    -moz-transform: rotate(180deg);
    -ms-transform: rotate(180deg);
    -o-transform: rotate(180deg);
    transform: rotate(180deg);
    opacity: 0.1;
}

.testimonial-area .testimonial-right-content .quota i {
    font-size: 130px;
    line-height: 95px;
    color: #0067f4;
}

.testimonial-area .testimonial-content-wrapper {
    position: relative;
    left: 70px;
}

@media only screen and (min-width: 992px) and (max-width: 1199px) {
    .testimonial-area .testimonial-content-wrapper {
        left: 0;
    }
}

@media (max-width: 767px) {
    .testimonial-area .testimonial-content-wrapper {
        left: 0;
    }
}

.single-testimonial {
    background-color: #fff;
    padding: 40px 30px 50px;
    border-radius: 50px;
}

.single-testimonial .testimonial-text .text {
    font-size: 24px;
    font-weight: 400;
    line-height: 36px;
    color: #121212;
    padding-bottom: 25px;
}

@media (max-width: 767px) {
    .single-testimonial .testimonial-text .text {
        font-size: 18px;
        line-height: 32px;
    }
}

.single-testimonial .testimonial-author {
    border-top: 1px solid #e9ecef;
    padding-top: 50px;
}

.single-testimonial .testimonial-author .author-info .author-image img {
    border-radius: 50%;
    width: 70px;
}

.single-testimonial .testimonial-author .author-info .author-name {
    padding-left: 30px;
}

.single-testimonial .testimonial-author .author-info .author-name .name {
    font-size: 16px;
    font-weight: 700;
    color: #121212;
}

.single-testimonial .testimonial-author .author-info .author-name .sub-title {
    font-size: 14px;
    color: #a4a4a4;
    margin-top: 5px;
}

@media (max-width: 767px) {
    .single-testimonial .testimonial-author .author-review {
        padding-left: 100px;
        padding-top: 15px;
    }
}

@media only screen and (min-width: 576px) and (max-width: 767px) {
    .single-testimonial .testimonial-author .author-review {
        padding-left: 0;
        padding-top: 15px;
    }
}

.single-testimonial .testimonial-author .author-review .star li {
    display: inline-block;
    font-size: 14px;
    color: #ffb400;
}

.single-testimonial .testimonial-author .author-review .review {
    font-size: 14px;
    color: #000;
    margin-top: 5px;
}

.testimonial-active .slick-arrow {
    position: absolute;
    bottom: 0;
    left: -635px;
    font-size: 22px;
    cursor: pointer;
    color: #a4a4a4;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
}

@media only screen and (min-width: 992px) and (max-width: 1199px) {
    .testimonial-active .slick-arrow {
        left: -480px;
    }
}

.testimonial-active .slick-arrow:hover {
    color: #000;
}

.testimonial-active .slick-arrow.next {
    left: -600px;
}

@media only screen and (min-width: 992px) and (max-width: 1199px) {
    .testimonial-active .slick-arrow.next {
        left: -445px;
    }
}


/*===========================
        13.TEAM css
===========================*/


/*===== TEAM STYLE ELEVEN =====*/

.team-style-eleven {
    position: relative;
    -webkit-box-shadow: 0px 8px 16px 0px rgba(72, 127, 255, 0.1);
    -moz-box-shadow: 0px 8px 16px 0px rgba(72, 127, 255, 0.1);
    box-shadow: 0px 8px 16px 0px rgba(72, 127, 255, 0.1);
}

.team-style-eleven .team-image img {
    width: 100%;
}

.team-style-eleven .team-content {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    background-color: #fff;
    padding-top: 25px;
    padding-bottom: 25px;
    z-index: 5;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
}

@media (max-width: 767px) {
    .team-style-eleven .team-content {
        padding-top: 15px;
        padding-bottom: 15px;
    }
}

.team-style-eleven .team-content::before {
    position: absolute;
    content: '';
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: -webkit-linear-gradient(left, #0067f4 0%, #2bdbdc 100%);
    background: -o-linear-gradient(left, #0067f4 0%, #2bdbdc 100%);
    background: linear-gradient(to right, #0067f4 0%, #2bdbdc 100%);
    z-index: -1;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
    opacity: 0;
}

.team-style-eleven .team-content .team-social {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
    visibility: hidden;
    opacity: 0;
}

.team-style-eleven .team-content .team-social .social {
    background-color: #fff;
    display: inline-block;
    padding: 10px 20px 6px;
    border-radius: 50px;
}

.team-style-eleven .team-content .team-social .social li {
    display: inline-block;
    margin: 0 8px;
}

.team-style-eleven .team-content .team-social .social li a {
    font-size: 16px;
    color: #a4a4a4;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
}

.team-style-eleven .team-content .team-social .social li a:hover {
    color: #0067f4;
}

.team-style-eleven .team-content .team-name a {
    color: #121212;
    font-size: 24px;
    font-weight: 600;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
}

@media (max-width: 767px) {
    .team-style-eleven .team-content .team-name a {
        font-size: 18px;
    }
}

.team-style-eleven .team-content .sub-title {
    font-size: 16px;
    color: #0067f4;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
}

@media (max-width: 767px) {
    .team-style-eleven .team-content .sub-title {
        font-size: 14px;
    }
}

.team-style-eleven:hover .team-content {
    padding-top: 50px;
}

@media (max-width: 767px) {
    .team-style-eleven:hover .team-content {
        padding-top: 35px;
    }
}

.team-style-eleven:hover .team-content::before {
    opacity: 1;
}

.team-style-eleven:hover .team-content .team-social {
    top: -20px;
    visibility: visible;
    opacity: 1;
}

.team-style-eleven:hover .team-content .team-name a {
    color: #fff;
}

.team-style-eleven:hover .team-content .sub-title {
    color: #fff;
}


/*===========================
      19.CONTACT css
===========================*/

.contact-area {
    padding-top: 120px;
    background-color: #f4f6f7;
}

p.form-message.success,
p.form-message.error {
    font-size: 16px;
    color: #333;
    background: #ddd;
    padding: 10px 15px;
    margin-top: 15px;
    margin-left: 15px;
}

p.form-message.success.form-message.error,
p.form-message.error.form-message.error {
    color: #f00;
}

.contact-map iframe {
    width: 100%;
    height: 750px;
}

@media (max-width: 767px) {
    .contact-map iframe {
        height: 800px;
    }
}

.contact-info .single-contact-info .contact-info-icon i {
    width: 50px;
    height: 50px;
    line-height: 50px;
    text-align: center;
    font-size: 24px;
    color: #fff;
    border-radius: 50%;
}

.contact-info .single-contact-info .contact-info-content {
    padding-left: 20px;
}

.contact-info .single-contact-info .contact-info-content .text {
    color: #121212;
}

.contact-info .single-contact-info.contact-color-1 .contact-info-icon i {
    background-color: #121212;
}

.contact-info .single-contact-info.contact-color-2 .contact-info-icon i {
    background-color: #fc3832;
}

.contact-info .single-contact-info.contact-color-3 .contact-info-icon i {
    background-color: #005ad5;
}

.contact-wrapper .contact-title {
    font-size: 32px;
    font-weight: 700;
    color: #000;
}

@media (max-width: 767px) {
    .contact-wrapper .contact-title {
        font-size: 26px;
    }
}

.contact-wrapper .contact-title i {
    color: #121212;
    margin-right: 8px;
}

.contact-wrapper .contact-title span {
    font-weight: 400;
}


/*===========================
    21.FOOTER css
===========================*/


/*===== FOOTER FIVE =====*/

.footer-area {
    background-color: #f4f6f7;
    padding-top: 90px;
    padding-bottom: 120px;
}

.footer-area .social li {
    display: inline-block;
    margin: 0 5px;
}

.footer-area .social li a {
    font-size: 24px;
    color: #6c6c6c;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
}

.footer-area .social li a:hover {
    color: #0067f4;
}

.footer-area .footer-support {
    padding-top: 21px;
}

.footer-area .footer-support span {
    font-size: 16px;
    line-height: 24px;
    color: #121212;
    font-weight: 600;
    margin-top: 9px;
    display: block;
}

@media (max-width: 767px) {
    .footer-area .footer-support span {
        display: block;
    }
}

.footer-area .footer-app-store {
    padding-top: 27px;
}

.footer-area .footer-app-store ul li {
    display: inline-block;
    margin-right: 8px;
}

@media only screen and (min-width: 992px) and (max-width: 1199px) {
    .footer-area .footer-app-store ul li {
        margin-right: 6px;
    }
}

.footer-area .footer-app-store ul li:last-child {
    margin-right: 0;
}

@media (max-width: 767px) {
    .footer-area .footer-app-store ul li {
        width: 120px;
    }
}

@media only screen and (min-width: 576px) and (max-width: 767px) {
    .footer-area .footer-app-store ul li {
        width: auto;
    }
}

.footer-area .copyright .text {
    color: #121212;
}

.footer-area.footer-dark {
    background-color: #121212;
}

.footer-area.footer-dark .social li a {
    color: #fff;
}

.footer-area.footer-dark .footer-support {
    padding-top: 21px;
}

.footer-area.footer-dark .footer-support span {
    color: #fff;
}

.footer-area.footer-dark .footer-app-store {
    padding-top: 27px;
}

.footer-area.footer-dark .footer-app-store ul li {
    color: #fff;
}

.footer-area.footer-dark .copyright .text {
    color: #fff;
}


/*===== BACK TO TOP =====*/

.back-to-top {
    font-size: 20px;
    color: #fff;
    position: fixed;
    right: 20px;
    bottom: 20px;
    width: 45px;
    height: 45px;
    line-height: 45px;
    border-radius: 5px;
    background-color: #0067f4;
    text-align: center;
    z-index: 99;
    -webkit-transition: all 0.3s ease-out 0s;
    -moz-transition: all 0.3s ease-out 0s;
    -ms-transition: all 0.3s ease-out 0s;
    -o-transition: all 0.3s ease-out 0s;
    transition: all 0.3s ease-out 0s;
    display: none;
}

.mt-20 {
    margin-top: 20px;
}

.pl-5p {
    padding-left: 5%;
}

.ribbon {
    margin: 0;
    padding: 0;
    background: #4caf50;
    color: white;
    /* padding: 1em 0; */
    position: absolute;
    bottom: 0;
    right: 0;
    transform-origin: top left;
    font-size: 14px;
}

.ribbon:before,
.ribbon:after {
    content: '';
    position: absolute;
    top: 0;
    margin: 0 -1px;
    /* tweak */
    width: 100%;
    height: 100%;
    background: rebeccapurple;
}

.ribbon:before {
    right: 100%;
}

.ribbon:after {
    left: 100%;
}

.fig_cap_holder {
    background-color: black;
    color: white;
    text-align: center;
}

.back-to-top:hover {
    color: white;
}

.portfolio-menu ul li {
    color: #000000;
    font-size: 13px;
    line-height: 18px;
    border: 1px solid lightgray;
    /*font-family: initial;*/
    padding: 10px;
}

.portfolio-menu ul li:hover,
.portfolio-menu ul li.active {
    color: #fff;
    font-size: 13px;
    line-height: 18px;
    /*font-family: initial;*/
    padding: 10px;
}

.slider_h1 {}

.slider_h1_holder {
    position: absolute;
    margin-top: -22%;
    background-color: rgb(113 2 2);

}

.slider_h3 {
    font-size: 2em !important;
}

.slider_h3_holder {
    position: absolute;
    margin-top: -11%;
    background-color: rgb(113 2 2);

}

.slider_img {
    height: 100%;
}

.slider-content .title {
    font-size: 59px;
}

@media screen and (max-width: 1024px) {}

@media screen and (max-width: 768px) {}

@media screen and (max-width: 480px) {
    .email_text_holder {
        width: 100% !important;
    }
    .fax_text_holder {
        padding-left: 0px;
    }
    .slider_h3_holder {
        margin-top: -29%;
        width: 64%;
    }
    .slider_h1_holder {
        margin-top: -42%;
    }
    .slider_h3 {
        font-size: 1em !important;
    }
    #carouselThree {
        margin-top: 19%;
    }
    .slider-content .title {
        font-size: 25px;
    }
    .slider_img {
        height: auto;
    }
}

@media screen and (max-width: 378px) {}

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

    <style>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Abel');

        .titles {
          font-size: 18px;
        }

        .span {
          font-size: 12px;
        }

        .dashcardshad {
          box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);
          margin-bottom: 1rem;
        }
        }

        .center {
          position: absolute;
          top: 50%;
          left: 50%;
          -webkit-transform: translate(-50%, -50%);
        }

        .card {
          width: 100%;
          height: 200px;
          background-color: #004578;
          box-shadow: 0 8px 16px -8px rgba(0, 0, 0, 0.4);
          border-radius: 6px;
          overflow: hidden;
          position: relative;
        }

        .card h1 {
          text-align: center;
        }

        .card .additional {
          position: absolute;
          width: 100%;
          height: 100%;
          background: linear-gradient(#002746, rgb(113 2 2));
          transition: width 0.03s;
          overflow: hidden;
          z-index: 2;
        }

        .card.green .additional {
          background: linear-gradient(#d0d0d0, #d0d0d0);
        }

        .card:hover .additional {
          width: 150px;
          border-radius: 0 5px 5px 0;
        }

        .card .additional .user-card {
          width: 150px;
          height: 100%;
          position: relative;
          float: left;
        }

        .card .additional .user-card::after {
          content: "";
          display: block;
          position: absolute;
          top: 10%;
          right: -2px;
          height: 80%;
          border-left: 2px solid rgba(0, 0, 0, 0.025);
          */
        }

        .card .additional .user-card .level,
        .card .additional .user-card .points {
          top: 15%;
          color: #fff;
          text-transform: uppercase;
          font-size: 0.75em;
          font-weight: bold;
          background: rgba(0, 0, 0, 0.15);
          padding: 0.125rem 0.75rem;
          border-radius: 100px;
          white-space: nowrap;
        }

        .card .additional .user-card .points {
          top: 85%;
        }

        .card .additional .user-card svg {
          top: 50%;
        }

        .card .additional .more-info {
          width: 55%;
          float: left;
          position: absolute;
          left: 150px;
          height: 100%;
        }

        .card .additional .more-info h1 {
          color: #fff;
          margin-bottom: 0;
        }

        .card.green .additional .more-info h1 {
          color: #224C36;
        }

        .card .additional .coords {
          margin: 0 1rem;
          color: #fff;
          font-size: 1rem;
        }

        .card.green .additional .coords {
          color: #325C46;
        }

        .card .additional .coords span+span {
          float: right;
        }

        .card .additional .stats {
          font-size: 2rem;
          display: flex;
          position: absolute;
          bottom: 1rem;
          left: 1rem;
          right: 1rem;
          top: auto;
          color: #fff;
        }

        .card.green .additional .stats {
          color: #325C46;
        }

        .card .additional .stats>div {
          flex: 1;
          text-align: center;
        }

        .card .additional .stats i {
          display: block;
        }

        .card .additional .stats div.title {
          font-size: 0.75rem;
          font-weight: bold;
          text-transform: uppercase;
        }

        .card .additional .stats div.value {
          font-size: 1.5rem;
          font-weight: bold;
          line-height: 1.5rem;
        }

        .card .additional .stats div.value.infinity {
          font-size: 2.5rem;
        }

        .card .general {
          width: calc(100% - 150px);
          height: 100%;
          position: absolute;
          top: 0;
          right: 0;
          z-index: 1;
          box-sizing: border-box;
          /* padding: 1rem; */
          /* padding-top: 0; */
        }

        .card .general .more {
          position: absolute;
          font-size: 0.9em;
        }

        .main-body {
          padding: 15px;
        }

        .dashcard {}

        .dashcard {
          position: relative;
          display: flex;
          flex-direction: column;
          min-width: 0;
          word-wrap: break-word;
          background-color: #fff;
          background-clip: border-box;
          border: 0 solid rgba(0, 0, 0, .125);
          border-radius: .25rem;
        }

        .dashcard-body {
          flex: 1 1 auto;
          min-height: 1px;
          padding: 1rem;
        }

        .gutters-sm {
          margin-right: -8px;
          margin-left: -8px;
        }

        .gutters-sm>.col,
        .gutters-sm>[class*=col-] {
          padding-right: 8px;
          padding-left: 8px;
        }

        .mb-3,
        .my-3 {
          margin-bottom: 1rem !important;
        }

        .bg-gray-300 {
          background-color: #e2e8f0;
        }

        .h-100 {
          height: 100% !important;
        }

        .shadow-none {
          box-shadow: none !important;
        }
      </style>
    </style>
</head>

<body>

<section class="navbar-area sticky" style="width:100vw">
@php $loading_target ="activeUser";@endphp
    <div class="container-fluid" >
        <div class="row">
            <div class="col-lg-12" style="display:flex; background-color:rgb(113 2 2);;justify-content: space-between!important;padding: 20px!important;margin-bottom:50px;">
                <nav class="navbar navbar-expand-lg">

                    <a class="navbar-brand" href="{{config("app.APP_URL")}}" style="padding:0px;height:30px;width:100px;">
                        @if(!empty($common::getSiteSettings('org_logo')))
                            <img class="logo_img"
                                 src="{{asset("uploads/".$common::getSiteSettings('org_logo'))}}"
                                 alt="{{$common::getSiteSettings("org_name")}}">
                        @else
                            <img class="logo_img" href="{{config("app.APP_URL")}}"
                                 src="{{asset("uploads/".config("app.DEFAULT_LOGO"))}}"
                                 alt="{{$common::getSiteSettings("org_name",config("app.APP_NAME"))}}">
                        @endif
                    </a>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTwo"
                            aria-controls="navbarTwo" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="toggler-icon"></span>
                        <span class="toggler-icon"></span>
                        <span class="toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse sub-menu-bar" id="navbarTwo">

                    </div>

                </nav> <!-- navbar -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</section>


<h1> {{$info}}</h1>
<br>
<br>
<!--[if IE]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade
    your browser to google/firefox </a> to improve your experience and security.</p>
<![endif]-->


<!--====== NAVBAR TWO PART START ======-->


@php
$common =new \App\Facades\Common ;
 $current_user;
     $sel_issue_date;
     $sel_return_date;
     $name;
     $email;
     $address;
     $phone;
     $education;
     $about_me;
     $tab = '1';
     $user_id = null;
     $sel_books_info = [];
     $photo;
     $cover;
     $remark = "";
     $proof = "";
     $fine;
     $proof_link = "";
     $photo_link;
     $check = "";
     $password_confirmation;
     $password;
     $current_password;

     $roles;
     $section;
     $sel_remark;
     $gender;
     $isOwner = 0;
     $isEdit = 0;
     $cover_link;
     $privacysearch;
     $privacyborrow;
     $privacyprofile;
     $privacyleaderboard;
     $privacyfuture;
     $generalprivacy;
     $awards;
     $systempermission;
     $globrequest = [];
     $tmp_barcode_book_id = "";
     $ownAccess=false;
     $selectedtypes;
     $currentlyBorrowed = [];
     $currentlyRemarks = [];
 function mounte($v_id)
    {
    if($v_id == Auth::id()){
         $user_id = Auth::id();
         $isOwner = 1;
    }elseif($v_id == "check"){
       $user_id = Auth::id();
    }else{
    $user_id = $v_id;
          $isOwner = 0;
    };
    $roles = App\Models\User::get_current_user_roles($v_id);
    $section = App\Facades\Common::getStandardDivisionAssignedToLoggedInUser($v_id);
        $user_obj = App\Models\User::find($user_id);
        if(!isset($user_obj)){
        abort(404, __("common.page_not_found"));
        }
        $current_user = $user_obj;
        $email = $user_obj->email;
        $name = $user_obj->name;
        $user_meta_obj = App\Models\UserMeta::where("user_id", $user_obj->id)->first();
        if ($user_meta_obj) {
            $address = $user_meta_obj->get_address();
            $education = $user_meta_obj->get_education();
            $phone = $user_meta_obj->get_phone();
             $gender = $user_meta_obj->get_gender();
            $about_me = $user_meta_obj->get_about_me();
            $photo_link = asset("uploads/".$user_meta_obj->get_user_photo(),false);
            $cover_link = asset("uploads/".$user_meta_obj->get_user_coverphoto(),false);
            $privacysearch = $user_meta_obj->getprivacysearch($user_id);
            $privacyborrow = $user_meta_obj->getprivacyborrow($user_id);
            $privacyprofile = $user_meta_obj->getprivacyprofile($user_id);
            $privacyleaderboard = $user_meta_obj->getprivacyleaderboard($user_id);
            $privacyfuture = $user_meta_obj->getprivacyfuture($user_id);
            $generalprivacy = $user_meta_obj->getgeneralprivacy($user_id);
            $systempermission = $user_meta_obj->systempermission($user_id);

            $tmp = $user_obj->get_proof();
            $proof_link = !empty($tmp) ? $tmp : '';
            if($v_id == "check"){

            $ownAccess = false;
            }else{
            $ownAccess = true;
            }


        }
    }
    function loadRequest($user_id){
    $request = App\Models\borrowed::where("user_id",$user_id)->whereNull('date_returned')->get();
    $globrequest = [];
    if(!$request->isEmpty()){

        foreach ($request as $data) {
            //#$user_img = Util::searchCollections($user->user_meta, "meta_key", "photo", "meta_value");
            $user =  App\Models\User::where("id", $data->user_id)->get();
            $book =  App\Models\Book::where("id", $data->book_id)->get();
            $sub_book =  App\Models\SubBook::where("id",$data->sub_book_id)->first();
            $user["Accession"] =  $sub_book->sub_book_id;
            $user["sub_book_origid"] =  $sub_book->id;
            $user["Borrowed"] =  $data->date_borrowed;
            $user["Returned"] =  $data->date_to_return;
            $user["Return"] =  $data->date_returned;
            $user["origid"] =  $data->id;

            $user["Delay"] =  $data->delayed_day;

            $user["issue"] =  $data->issued_by;
            $user["id"] = $data->id;
            $user["Valid"] =  $data->validtill;
            $user["book_id"] = $data->book_id;
            foreach($book as $book_data){
            $user["title"]= $book_data->title;
            $user["desc"]=  $book_data->desc;






            }
            $user["created_at"] = Carbon\Carbon::parse($data->date_borrowed);
            $user_img =  App\Models\User::get_user_photo($data->user_id);
            $user["image"] = $user_img ? asset('uploads/' . $user_img) : asset('uploads/' . config('app.DEFAULT_USR_IMG'),false);
            $user["user_id"] = $data->user_id;
           $user["name"] =  App\Models\User::get_user_name($data->user_id);
           $user["category"] = \App\Models\DeweyDecimal::where("id", $data->category)->get()->pluck("cat_name");
           $book_img = \App\Models\Book::where("id", $data->book_id)->get()->pluck("cover_img");
           if($book_img == "[null]" || $book_img =="[\"uploads\"]"){

            $user["book_img"] = asset('uploads/' . config('app.DEFAULT_BOOK_IMG'),false);
           }else{

           $user["book_img"] = $book_img ? asset('uploads/' . $book_img) : asset('uploads/' . config('app.DEFAULT_BOOK_IMG'),false);

           }
           $user["isReturned"] = $data->date_returned;
           if( $data->date_returned == ""){
           $user["isReturned"] = "<strong><span style='color:rgb(113 2 2)'>[Borrowed]</span></strong>";
           }else{
           $user["isReturned"] = "<strong><span style='color:#00AA00'>[Returned]</span></strong>";
           }
            array_push($globrequest, $user);
        }
       return $globrequest;
     }else{

     }
    }

    mounte($body);
    $globrequest = loadRequest($body);
@endphp








@php $today = date("Y-m-d"); $notfullyrendered = 0; $counter =1; @endphp @foreach($globrequest as $key => $data) @php $borrowing = date($data["Borrowed"]); @endphp @if($borrowing > $today) <div class="col p-0">
                  <div class="alert alert-light" role="alert">
                    <h4 class="alert-heading m-0" style="font-size:16px">Book below is scheduled on: {{$data["Borrowed"]}} </h4>
                  </div> @else @endif @php
                  if($notfullyrendered == 0){ $selectedtypes = $data["Accession"]; } @endphp
                  <div class="card">
                    <div class="additional">
                      <div class="user-card">
                        <img style="    width: 150px;
                        height: 100%;" src="{{asset(str_replace (array('[', ']',chr(34)), '' , $data["book_img"]))}}"></img>
                      </div>
                      <div class="more-info">
                        <div class="coords p-2 m-0">
                        <br>
                          <br>
                          <span class="titles">Title: <span class="span">{{$data["title"]}}</span>
                          </span>
                          <br>
                          <span class="titles">Accession: <span class="span">{{$data["Accession"]}}</span>
                          </span>
                          <br>
                          <span class="titles" style="@if($borrowing > $today)
                               color:Red

                                  @endif">Borrow Date: <span class="span">{{$data["Borrowed"]}}</span>
                          </span>
                          <br>
                          <span class="titles">Return Date: <span class="span">{{$data["Returned"]}}</span>
                          </span>
                          <br>
                          <span class="titles">Borrower: <span class="span">{{$data["name"]}}</span>
                          </span>
                          <br>
                          <span class="titles">Issuer: <span class="span"> {{$data["issue"]}}</span>
                          </span>
                          <br>
                          <br>

                          </span>
                          <br>
                        </div>
                      </div>
                    </div>
                    <div class="general p-2 m-0 d-flex" style="flex-direction: column;    justify-content: space-between;">
                      <div>

                         @php
                                        $date_to_return = Illuminate\Support\Carbon::parse($data["Returned"]);
                                        $now = Illuminate\Support\Carbon::now();
                                        $lv_delayed_days = 0;
                                        $lv_fine = 0;
                                        if(!isset($data["Return"]))
                                        {

                                            if($now>$date_to_return){ // we are late
                                                $lv_delayed_days = $date_to_return->diffInDays($now);;
                                                $lv_fine = $lv_delayed_days*$common::getSiteSettings("fine_per_day",1);
                                            }
                                         }
                                    @endphp


                        <span class="titles">Late: <span class="span">{{is_null($data["Return"]) ? strval($lv_delayed_days)." Days" : ($data["delayed_day"] ?? strval(0)." Days")}}</span>
                        </span>
                        <br>
                        <span class="titles">Expiration: <span class="span">{!! is_null($data["Return"]) ? $now>$date_to_return ? "MUST RETURN NOW" : strval($now->diffInDays($date_to_return) + 1) . " Days left" : "Returned" !!}
</span>
                        </span>
                        <br>
                        <span class="titles">Penalty: <span class="span">{{$lv_fine}} PHP</span>
                        </span>
                        <br>
                        <span class="titles">Comment: <span class="span"><textarea id='remark_".$data["id"]."' rows=3 wire:ignore class='form-control remark_obj text-sm'></textarea></span>
                        </span>
                      </div>
                      <div class="d-flex ml-auto">
                                            <button type="button"
                                                    onclick="lv_confirm_then_submit(this,'{{__("Confirm to renew this loan for another 5 days")}}','renewloan','{\'id\':{{$data["origid"]}}}');"
                                                    class="btn btn-xs btn-dark mb-1 m-1">{{__("Loan Renew")}}
                                            </button>
											<button type="button"
                                                    onclick="lv_confirm_then_submit(this,'{{__("common.cnf_mark_lost")}}','markLostBook','{\'id\':{{$data["sub_book_origid"]}},\'uid\':{{$data["user_id"]}}}')"
                                                    class="btn btn-xs btn-dark mb-1 m-1">{{__("common.mark_lost")}}
                                            </button>

                                            <button type="button"
                                                    onclick="lv_confirm_then_submit(this,'{{__("commonv2.cnf_mark_damage")}}','markDamageBook',
                                                        '{\'id\':{{$data["sub_book_origid"]}},\'uid\':{{$data["user_id"]}}}')"
                                                    class="btn btn-xs btn-dark mb-1 m-1">{{__("commonv2.cnf_damage")}}
                                            </button>
											<button type="button"
                                                    onclick="flush_data({{$data["id"]}});lv_confirm_then_submit(this,'{{__("common.cnf_receive_of_book")}}','receiveBook','{\'id\':{{$data["origid"]}}}');"
                                                    class="btn btn-xs btn-dark mb-1 m-1">{{__("common.receive_book")}}
                                            </button>

                      </div>
                    </div>
                  </div> @php $counter += 1; $notfullyrendered = 1; @endphp @endforeach



</body>


<footer id="footer" class="footer-1">
<br>
<br>
<hr>
    <div class="main-footer widgets-dark typo-light">
        <div class="container">
            <div class="row">

                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="widget subscribe no-box">
                        <h5 class="widget-title">{{$util::getIfNotEmpty($common::getOrgName())??config("app.APP_NAME")}}
                            <span></span></h5>
                        <p>{{$common::getSiteSettings("org_desc")}}</p>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="widget no-box">
                        <h5 class="widget-title">{{__("common.follow_up")}}<span></span></h5>
                        @if($common::getSiteSettings("fb_link"))
                            <a href="{{$common::getSiteSettings("fb_link","#")}}"><i class="fa fa-facebook"></i></a>
                        @endif
                        @if($common::getSiteSettings("tw_link"))
                            <a href="{{$common::getSiteSettings("tw_link","#")}}"><i class="fa fa-twitter"></i></a>
                        @endif
                        @if($common::getSiteSettings("gp_link"))
                            <a href="{{$common::getSiteSettings("gp_link","#")}}"><i class="fa fa-google"></i></a>
                        @endif
                        @if($common::getSiteSettings("ln_link"))
                            <a href="{{$common::getSiteSettings("ln_link","#")}}"><i class="fa fa-linkedin"></i></a>
                        @endif
                    </div>
                </div>
                <br>
                <br>


                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="widget no-box">
                        <h5 class="widget-title">{{__("common.contact_us")}}<span></span></h5>
                        <p>{{__("common.footer_contact_desc")}}</p>



                    </div>

                </div>
            </div>
        </div>

        <div class="footer-copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 no-gutters text-center">
                        <div class="row">
                            <div class="col-md-8 col-12 mb-1 text-right">
                                <p>{{$common::getSiteSettings("footer_note")}}</p>
                            </div>
                            <div class="col-md-4 col-12 mb-1">
                        <span class="d-inline float-right">  @if(trim(strip_tags($common::getSiteSettings("toi_heading"))))
                                <a
                                    class="text-white"
                                    href="/terms-and-conditions">{{htmlspecialchars_decode(trim(strip_tags($common::getSiteSettings("toi_heading"))))}}</a>
                                | @endif
                            @if(trim(strip_tags($common::getSiteSettings("pp_heading")))) <a
                                class="text-white"
                                href="/privacy-policy">{{htmlspecialchars_decode(trim(strip_tags($common::getSiteSettings("pp_heading"))))}}</a>@endif</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>


</html>
