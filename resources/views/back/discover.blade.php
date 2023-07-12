@php
    /* @var \App\Facades\Util $util */
    /* @var \App\Facades\Common $common */
@endphp
@extends("back.common.master")
@section("page_name") {{__("common.dashboard")}} @endsection
@section("content")


    @livewire("discover")


    

@endsection
@section("js_loc")
<script src="{{asset('front/js/slick.min.js')}}"></script>
<script src="{{asset('front/js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('front/js/imagesloaded.pkgd.min.js')}}"></script>
<script src="{{asset('front/js/isotope.pkgd.min.js')}}"></script>
<script>


var $grid = $('.grid').isotope({
            // options
        });

        $grid.isotope({ sortBy : 'random' });
       $("#change").show();
</script>
@endsection
@section("css_loc")
    <style>
   @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
    .section-heading {
}

.section-heading .line-dec {
	width: 30px;
	height: 5px;
	background-color: #3a8bcd
}

.section-heading h1 {
	font-size: 22px;
	font-weight: 700;
	color: #1e1e1e;
	margin-top: 15px
}
   body {
   background-color: #f4f4f4
   }
   #header {
   width: 100%;
   height: 60px;
   box-shadow: 5px 5px 15px #e8e8e8
   }
   .col-lg-4,
   .col-md-6 {
   padding-right: 0
   }
   button.btn.btn-hide {
   height: inherit;
   background-color: #e5e4e4/* Old #f4d03f */;
   color: #fff;
   font-size: 0.82rem;
   padding-left: 40px;
   padding-right: 40px;
   border-top-right-radius: 0px;
   border-bottom-right-radius: 0px
   }
   .btn:focus {
   box-shadow: none
   }
   .box-label .btn {
   background-color: #fff;
   padding: 0;
   font-size: 0.8rem
   }
   .btn-red {
   background-color: #e00000ce
   }
   .btn-orange {
   background-color: #ffa500
   }
   .btn-pink {
   background-color: #e0009dce
   }
   .btn-green {
   background-color: #00811c
   }
   .btn-blue {
   background-color: #026bc2
   }
   .btn-brown {
   background-color: #994a00
   }
   select {
   outline: none;
   padding: 6px 12px;
   margin: 0px 4px;
   color: #999;
   font-size: 0.85rem;
   width: 140px
   }
   #select2 {
   border: 1px solid #777;
   color: #999
   }
   #pro {
   border: none;
   color: #333;
   font-weight: 700;
   padding-left: 0px;
   width: initial
   }
   #filterbar {
   width: 20%;
   background-color: #fff;
   border: 1px solid #ddd;
   float: left;
   }
   #filterbar input[type="radio"] {
   visibility: hidden
   }
   #filterbar input[type='radio']:checked {
   background-color: #16c79a;
   border: none
   }
   #filterbar .btn.btn-success {
   background-color: #e5e4e4/* Old #f4d03f */;
   color: #333;
   border: none;
   width: 115px
   }
   #filterbar .btn.btn-success:hover {
   background-color: #e5e4e4/* Old #f4d03f */;
   color: #444
   }
   #filterbar .btn-success:not(:disabled):not(.disabled).active,
   #filterbar .btn-success:not(:disabled):not(.disabled):active {
   background-color: rgb(113 2 2);
   color: #fff
   }
   label {
   cursor: pointer
   }
   .tick {
   display: block;
   position: relative;
   padding-left: 23px;
   cursor: pointer;
   font-size: 0.9rem;
   margin: 0
   }
   .tick input {
   position: absolute;
   opacity: 0;
   cursor: pointer;
   height: 0;
   width: 0
   }
   .check {
   position: absolute;
   top: 1px;
   left: 0;
   height: 18px;
   width: 18px;
   background-color: #fff;
   border: 1px solid #ddd;
   border-radius: 3px
   }
   .tick:hover input~.check {
   background-color: #f3f3f3
   }
   .tick input:checked~.check {
   background-color: #ffffff
   }
   .check:after {
   content: "";
   position: absolute;
   display: none
   }
   .tick input:checked~.check:after {
   display: block;
   transform: rotate(45deg) scale(1)
   }
   .tick .check:after {
   left: 6px;
   top: 2px;
   width: 5px;
   height: 10px;
   border: solid rgb(0, 0, 0);
   border-width: 0 3px 3px 0;
   transform: rotate(45deg) scale(2)
   }
   .box {
   padding: 10px
   }
   .box-label {
   color: #11698e;
   font-size: 0.9rem;
   font-weight: 800
   }
   #inner-box,
   #inner-box2 {
   height: 150px;
   overflow-y: scroll
   }
   #inner-box2 {
   height: 132px
   }
   #inner-box::-webkit-scrollbar,
   #inner-box2::-webkit-scrollbar {
   width: 6px
   }
   #inner-box::-webkit-scrollbar-track,
   #inner-box2::-webkit-scrollbar-track {
   background-color: #ddd;
   }
   #inner-box::-webkit-scrollbar-thumb,
   #inner-box2::-webkit-scrollbar-thumb {
   background-color: #333;
   }
   #price {
   height: 45px
   }
   #size input[type="checkbox"] {
   visibility: hidden
   }
   #size input[type='checkbox']:checked {
   background-color: #16c79a;
   border: none
   }
   #size .btn.btn-success {
   background-color: #ddd;
   color: #333;
   border: none;
   width: 40px;
   font-size: 0.8rem;
   }
   #size .btn.btn-success:hover {
   background-color: #aff1e1;
   color: #444
   }
   #size .btn-success:not(:disabled):not(.disabled).active,
   #size .btn-success:not(:disabled):not(.disabled):active {
   background-color: rgb(113 2 2);
   color: #fff
   }
   #size label {
   margin: 10px;
   margin-left: 0px
   }
   .card {
   padding: 10px;
   cursor: pointer;
   transition: .3s all ease-in-out;
   height: 300px
   }
   .card:hover {
   /* box-shadow: 2px 2px 15px #fd9a6ce5; */
   transform: scale(1.02)
   }
   .card .product-name {
   font-weight: 600
   }
   .card-body {
   padding-bottom: 0
   }
   .card .text-muted {
   font-size: 0.82rem
   }
   .card-img img {
   padding-top: 10px;
   width: inherit;
   height: 180px;
   object-fit: contain;
   display: block
   }
   .card-body .btn-group .btn {
   padding: 0;
   width: 20px;
   height: 20px;
   margin-right: 5px;
   border-radius: 50%;
   position: relative
   }
   .card-body .btn-group>.btn-group:not(:last-child)>.btn,
   .card-body .btn-group>.btn:not(:last-child):not(.dropdown-toggle) {
   border-radius: 50%;
   transition: ease-in all .4s
   }
   .card-body input[type="radio"] {
   visibility: hidden
   }
   .card-body .btn:not(:disabled):not(.disabled).active::after,
   .card-body .btn:not(:disabled):not(.disabled):active::after {
   content: "";
   width: 10px;
   height: 10px;
   border-radius: 50%;
   top: 4px;
   left: 4.2px;
   background-color: #fff;
   position: absolute;
   transition: ease-in all .4s
   }
   .card-body .btn.btn-light:not(:disabled):not(.disabled).active::after,
   .card-body .btn.btn-light:not(:disabled):not(.disabled):active::after {
   background-color: #000
   }
   #avail-size input[type="checkbox"] {
   visibility: hidden
   }
   #avail-size input[type='checkbox']:checked {
   background-color: #16c79a;
   border: none
   }
   #avail-size .btn.btn-success {
   background-color: #ddd;
   color: #333;
   border: none;
   width: 20px;
   font-size: 0.7rem;
   border-radius: 0;
   padding: 0
   }
   #avail-size .btn.btn-success:hover {
   background-color: #aff1e1;
   color: #444
   }
   #avail-size .btn-success:not(:disabled):not(.disabled).active,
   #avail-size .btn-success:not(:disabled):not(.disabled):active {
   background-color: #16c79a;
   color: #fff
   }
   #avail-size label {
   margin: 10px;
   margin-left: 0px
   }
   #shirt {
   height: 170px
   }
   .middle {
   position: relative;
   width: 100%;
   margin-top: 25px
   }
   .slider {
   position: relative;
   z-index: 1;
   height: 5px;
   margin: 0 15px
   }
   .slider>.track {
   position: absolute;
   z-index: 1;
   left: 0;
   right: 0;
   top: 0;
   bottom: 0;
   background-color: #ddd
   }
   .slider>.range {
   position: absolute;
   z-index: 2;
   left: 25%;
   right: 25%;
   top: 0;
   bottom: 0;
   background-color: #36a31b
   }
   .slider>.thumb {
   position: absolute;
   top: 2px;
   z-index: 3;
   width: 20px;
   height: 20px;
   background-color: #36a31b;
   border-radius: 50%;
   box-shadow: 0 0 0 0 rgba(63, 204, 75, 0.705);
   transition: box-shadow .3s ease-in-out
   }
   .slider>.thumb::after {
   position: absolute;
   width: 8px;
   height: 8px;
   left: 28%;
   top: 30%;
   border-radius: 50%;
   content: '';
   background-color: #fff
   }
   .slider>.thumb.left {
   left: 25%;
   transform: translate(-15px, -10px)
   }
   .slider>.thumb.right {
   right: 25%;
   transform: translate(15px, -10px)
   }
   .slider>.thumb.hover {
   box-shadow: 0 0 0 10px rgba(125, 230, 134, 0.507)
   }
   .slider>.thumb.active {
   box-shadow: 0 0 0 10px rgba(63, 204, 75, 0.623)
   }
   input[type=range] {
   position: absolute;
   pointer-events: none;
   -webkit-appearance: none;
   z-index: 2;
   height: 10px;
   width: 100%;
   opacity: 0
   }
   input[type=range]::-webkit-slider-thumb {
   pointer-events: all;
   width: 30px;
   height: 30px;
   border-radius: 0;
   border: 0 none;
   background-color: red;
   -webkit-appearance: none
   }
   .del {
   text-decoration: line-through;
   color: red
   }
   @media(min-width:1199.6px) {
   #filterbar {
   width: 20%
   }
   }
   @media(max-width:1199.5px) {
   #filterbar {
   width: 20%
   }
   .card {
   height: 300px;
   }
   .price {
   font-size: 0.9rem
   }
   .product-name {
   font-size: 0.8rem
   }
   }
   #filterbar {
   width: 25%
   }
   #sort {
   background-color: inherit;
   color: #fff;
   margin: 0;
   margin-bottom: 20px;
   width: 100%
   }
   #sort option,
   #pro option {
   color: #000
   }
   #pro,
   #select2,
   .result {
   background-color: inherit;
   color: #fff
   }
   .card {
   height: 300;
   }
   .price {
   font-size: 0.85rem
   }
   }
   @media(max-width: 767.5px) {
   #filterbar {
   width: 50%
   }
   }
   @media(max-width: 525.5px) {
   #filterbar {
   float: none;
   width: 100%;
   margin-bottom: 20px;
   }
   #content.my-5 {
   margin-top: 20px !important;
   margin-bottom: 20px !important
   }
   .col-lg-4,
   .col-md-6 {
   padding-left: 0
   }
   }
   @media(max-width: 500.5px) {
   }
</style>
@endsection

