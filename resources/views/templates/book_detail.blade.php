@php
    /* @var \App\Facades\Util $util */

@endphp
@extends("front.master")
@section("content")
 @php $pcat = $common::getParentCatOfSubCat($book_obj->category);@endphp
                @php $pcat_name = Str::title($common::getCatName($pcat));@endphp
                @php $scat_name = Str::title($common::getCatName($book_obj->category));@endphp
                @php $publishers = $book_obj->publishers()->pluck("publishers.name")->toArray();@endphp
                @php $books_available = $util::countProperty($book_obj->sub_books->toArray(),"borrowed","0"); @endphp
                                @php $tags = $book_obj->tags()->pluck("tags.name")->toArray();
                                $trendbooks = \App\Facades\Common::getBooksDetailsForFrontEndPreffSoloCateg($book_obj->category);

                                @endphp
  <div class="single-product">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <div class="line-dec"></div>
              <h1>Book Information</h1>
            </div>
          </div>
          <div class="col-md-4">
            <div class="product-slider">
              <div id="slider" class="flexslider">

              <div class="flex-viewport" style="overflow: hidden; position: relative;"><ul class=" d-flex" style="justify-content: center;width: 100%!important; transition-duration: 0s; transform: translate3d(0px, 0px, 0px);">

                  <img style="width:200px; height:300px;" alt={{$book_obj->title}} src="{{$book_obj->cover_img()}}" draggable="false">

                  <!-- items mirrored twice, total of 12 -->
                </ul></div><ul class="flex-direction-nav"><li class="flex-nav-prev"><a class="flex-prev flex-disabled" href="#" tabindex="-1">Previous</a></li><li class="flex-nav-next"></li></ul></div>
              <div id="carousel" class="flexslider">

              <div class="flex-viewport" style="overflow: hidden; position: relative;"><ul class="slides" style="width: 800%; transition-duration: 0s; transform: translate3d(0px, 0px, 0px);">
                  <li class="flex-active-slide" style="width: 210px; margin-right: 5px; float: left; display: block;">

                  </li>



                  <!-- items mirrored twice, total of 12 -->
                </ul></div><ul class="flex-direction-nav"><li class="flex-nav-prev"><a class="flex-prev flex-disabled" href="#" tabindex="-1">Previous</a></li><li class="flex-nav-next"><a class="flex-next" href="#">Next</a></li></ul></div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="right-content">
              <h2>{{isset($book_obj) ? $book_obj->title : "N/A"}}</h2>
               @php $authors = $book_obj->authors()->pluck("authors.name")->toArray();@endphp
                        @if(count($authors))
                            <strong>{{__("common.by")}} - </strong><span class="">
                                @if(count($authors))
                                    @foreach($authors as $author)
                                        <a class="btn-link"
                                           href="{{url("/")."?search=".$author."#books"}}">{{$author}}</a>
                                        @if(!$loop->last) , @endif @endforeach
                                @else -- @endif
                        </span><br>
                        @endif
              @php $publishers = $book_obj->publishers()->pluck("publishers.name")->toArray();@endphp
                                @if(count($publishers))
                                        <strong>{{__("common.publisher")}}
                                            - </strong>
                                        @if(count($publishers))
                                            @foreach($publishers as $publisher)
                                                <a class="btn-link"
                                                   href="{{url("/")."?search=".$publisher."#books"}}">{{$publisher}}</a>
                                                @if(!$loop->last) , @endif @endforeach
                                        @else -- @endif

                                @endif


              <p>{!! $book_obj->desc !!}</p>
              @if($book_obj->isbn_10)

                                        <strong>{{__("common.isbn_10")}} - </strong><span>{{$book_obj->isbn_10}}</span>

                                @endif<br>
              @if($book_obj->isbn_13)

                                        <strong>{{__("common.isbn_13")}} - </strong><span>{{$book_obj->isbn_13}}</span>

                                @endif<br>
                                @php
                                   $available_books = App\Models\SubBook::where("book_id", $book_obj->id)->get();
                                @endphp

                                @foreach($available_books as $books)
                                @if($common::checkIfInBorrowedRequestsolo($books->sub_book_id))
                                    <span>Accession: {{$books->sub_book_id}} | Reserved on  {{implode(",",json_decode($common::checkIfInBorrowedRequestsoloData($books->sub_book_id)))}}</span><br>
                                    @else

                                    <span>
                                     Accession: {{$books->sub_book_id}} | Available for reservation





                                    </span><br>
                                    @endif


                                @endforeach
                                 <span class="m-0" style="color: #8B8000;font-size: x-small;">*Yellow mark on the calendar indicate weekdays</span><br>
                                  <span class="m-0" style="color:#699D4C;font-size: x-small;">*Green mark on the calendar indicate Holidays</span><br>
                                   <span class="m-0" style="color:Blue;font-size: x-small;">*Blue mark on the calendar indicate book is reserved or currently borrowed.</span>
             <br>
              <form action="" method="get" class="d-flex" style="justify-content: flex-end;">



              <div class="mt-2 d-flex col-12" style="justify-content: flex-end; flex-direction: column;">

                                <p class="d-inline">
                                    @livewire("partial.borrow-book",["user_id"=>Auth::id(),"book_id"=>$book_obj->id,"book_obj"=>$book_obj
                                    ,"books_available"=>$books_available])
                                </p></div>

                                <div id="viewer" class="row mt-2 preview_container">
                                    <div class="col">
                                        <div class="collapse multi-collapse" id="mcoll">
                                            <div class="card card-body">
                                                <div id="viewerCanvas" style="width: 100%; height: 1000px"></div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                @if($book_obj->category)
                                      <div class="down-content">
                <div class="categories">
                                        <h6>{{__("common.category")}}
                                            </h6><a class="btn-link"
                                                          href="{{url('/').'?pcat='.$pcat
.'&scat='.$book_obj->category}}#books">
                                            <span>{{$scat_name}}</span></a>
                                    </div>
                                @endif


                <div class="share">

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


  <div class="featured-items">
      <div class="container">
        <div class="row">

         @if($trendbooks != "")
          <div class="col-md-12">
            <div class="section-heading">
              <div class="line-dec"></div>
              <h1>You may also like</h1>
            </div>
          </div>
          <div style="height:450px; overflow:hidden;">
          <div class="col-md-12">
            <div class="owl-carousel owl-theme">
            @foreach($trendbooks as $book)
              <a href="{{route("details", ['page_slug' => $common::utf8Slug($book["TITLE"])])}}
                                 ">
                <div class="featured-item">
                  <img style="width:250px;height:300px;" src="{{asset("uploads/".$util::fileChecker(public_path("uploads"),
                                       $book["CIMG"],config("app.BOOK_IMG_NOT_FOUND")))}}" alt="Item 1">
                  <h4>{{ str_limit($book["TITLE"], $limit = 35, $end = '...') }}</h4>

                </div>
              </a>
              @endforeach
              @endif
            </div>
          </div>
          </div>


        </div>
      </div>
    </div>
    <script src="{{asset('js/jquery-1.12.4.js')}}"></script>
<script src="{{asset('js/jquery-ui.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
    <script src="{{asset('front/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('front/js/flex-slider.js')}}"></script>
    <script src="{{asset('front/js/isotope.js')}}"></script>
   <script src="{{asset('front/js/custom.js')}}"></script>
    <script src="{{asset('front/js/owl.js')}}"></script>

@endsection
@section("css_loc")
    <link rel="stylesheet" href="{{asset('css/book_detail.css')}}">
    <style>
        p {
            margin-bottom: 4%;
        }
    </style>

    <style>
    .section-heading {
	margin-top: 80px;
	margin-bottom: 40px
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

.featured-items {
	margin-bottom: 70px
}

.featured-item {
	border-radius: 5px;
	border: 1px solid #eee;
	padding: 20px;
	transition: all .5s
}

.featured-item:hover {
	opacity: .9
}

.featured-item img {
	width: 100%
}

.featured-item h4 {
	font-size: 17px;
	font-weight: 700;
	color: #1e1e1e;
	margin-top: 15px;
	transition: all .5s
}

.featured-item:hover h4 {
	color: #3a8bcd
}

.featured-item h6 {
	color: #3a8bcd;
	font-size: 15px;
	font-weight: 700;
	margin-bottom: 0
}

.owl-theme .owl-dots {
	text-align: center;
	margin-top: 30px
}

.owl-theme .owl-dots .owl-dot {
	outline: 0
}

.owl-theme .owl-dots .active span {
	background-color: #3a8bcd!important
}

.owl-theme .owl-dots .owl-dot span {
	background-color: #aaa;
	width: 8px;
	height: 8px;
	display: inline-block;
	margin: 0 5px;
	outline: 0
}

.featured .featured-item {
	margin-bottom: 30px;
	text-decoration: none
}

.featured .featured-item h4 {
	transition: all .5s
}

.featured .featured-item:hover h4 {
	color: #3a8bcd
}

.single-product .product-slider {
	padding: 20px;
	border: 1px solid #eee!important;
	border-radius: 5px
}

.flexslider {
	border: none!important
}

#carousel {
	margin-top: 20px
}

#carousel .slides li {
	width: 150px!important
}

.single-product .right-content h4 {
	font-size: 17px;
	font-weight: 700;
	margin-top: 0
}

.single-product .right-content h6 {
	color: #3a8bcd;
	font-size: 17px;
	font-weight: 700;
	margin-top: 10px
}

.single-product .right-content p {
	margin-top: 20px;
	margin-bottom: 30px
}

.single-product .right-content span {
	font-size: 14px;
	color: #3a8bcd;
	font-weight: 500;
	display: inline-block;
	margin-bottom: 15px
}

.single-product .right-content label {
	font-size: 14px;
	color: #4a4a4a
}

.single-product .right-content .quantity-text {
	margin-left: 10px;
	width: 44px;
	height: 44px;
	line-height: 42px;
	font-size: 14px;
	font-weight: 700;
	color: #4a4a4a;
	display: inline-block;
	text-align: center;
	outline: 0;
	border: 1px solid #eee
}

.single-product .right-content .button {
	margin-right: 15px;
	cursor: pointer;
	background-color: #3a8bcd;
	outline: 0;
	border-radius: 5px;
	padding: 10px 15px;
	display: inline-block;
	color: #fff;
	font-size: 14px;
	text-transform: uppercase;
	font-weight: 300;
	letter-spacing: .4px;
	text-decoration: none;
	transition: all .5s;
	box-shadow: none;
	border: none
}

.single-product .right-content .down-content span {
	margin-bottom: 0;
	display: inline-block;
	margin-left: 8px;
	color: #aaa
}

.single-product .right-content .down-content span a {
	color: #aaa;
	font-weight: 400;
	margin-left: 4px;
	transition: all .5s
}

.single-product .right-content .down-content span a:hover {
	color: #3a8bcd
}

.single-product .right-content .down-content span a:hover i {
	background-color: #3a8bcd
}

.single-product .right-content .down-content span a i {
	transition: all .5s;
	background-color: #aaa;
	width: 26px;
	height: 26px;
	display: inline-block;
	text-align: center;
	line-height: 26px;
	border-radius: 50%;
	color: #fff;
	font-size: 12px;
	margin-right: 5px
}

.single-product .right-content .down-content .categories {
	border-top: 1px solid #eee;
	margin-top: 30px;
	padding: 10px 0
}

.single-product .right-content .down-content .share {
	border-top: 1px solid #eee;
	padding: 10px 0
}

.single-product .right-content .down-content h6 {
	font-size: 14px;
	color: #4a4a4a;
	font-weight: 400
}

@media (max-width:991px) {
	.single-product .right-content {
		margin-top: 30px
	}
}

.owl-carousel {
	display: none;
	width: 100%;
	-webkit-tap-highlight-color: transparent;
	position: relative;
	z-index: 1
}

.owl-carousel .owl-stage {
	position: relative;
	-ms-touch-action: pan-Y;
	touch-action: manipulation;
	-moz-backface-visibility: hidden
}

.owl-carousel .owl-stage:after {
	content: ".";
	display: block;
	clear: both;
	visibility: hidden;
	line-height: 0;
	height: 0
}

.owl-carousel .owl-stage-outer {
	position: relative;
	overflow: hidden;
	-webkit-transform: translate3d(0, 0, 0)
}

.owl-carousel .owl-item {
	-webkit-backface-visibility: hidden;
	-moz-backface-visibility: hidden;
	-ms-backface-visibility: hidden;
	-webkit-transform: translate3d(0, 0, 0);
	-moz-transform: translate3d(0, 0, 0);
	-ms-transform: translate3d(0, 0, 0)
}

.owl-carousel .owl-item {
	position: relative;
	min-height: 1px;
	float: left;
	-webkit-backface-visibility: hidden;
	-webkit-tap-highlight-color: transparent;
	-webkit-touch-callout: none
}

.owl-carousel .owl-item img {
	display: block;
	width: 100%
}

.owl-carousel .owl-dots.disabled,
.owl-carousel .owl-nav.disabled {
	display: none
}

.owl-carousel .owl-dot,
.owl-carousel .owl-nav .owl-next,
.owl-carousel .owl-nav .owl-prev {
	cursor: pointer;
	-webkit-user-select: none;
	-khtml-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none
}

.owl-carousel .owl-nav button.owl-next,
.owl-carousel .owl-nav button.owl-prev,
.owl-carousel button.owl-dot {
	background: 0 0;
	color: inherit;
	border: none;
	padding: 0!important;
	font: inherit
}

.owl-carousel.owl-loaded {
	display: block
}

.owl-carousel.owl-hidden {
	opacity: 0
}

.owl-carousel.owl-drag .owl-item {
	-ms-touch-action: pan-y;
	touch-action: pan-y;
	-webkit-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none
}

@keyframes fadeOut {
	0% {
		opacity: 1
	}
	100% {
		opacity: 0
	}
}

@font-face {
	font-family: flexslider-icon;
	src: url(../fonts/flexslider-icon.eot);
	src: url(../fonts/flexslider-icon.eot?#iefix) format('embedded-opentype'), url(../fonts/flexslider-icon.woff) format('woff'), url(../fonts/flexslider-icon.ttf) format('truetype'), url(../fonts/flexslider-icon.svg#flexslider-icon) format('svg');
	font-weight: 400;
	font-style: normal
}

.flex-container a:hover,
.flex-slider a:hover {
	outline: 0
}

.flex-direction-nav,
.slides,
.slides>li {
	margin: 0;
	padding: 0;
	list-style: none
}

.flexslider {
	margin: 0;
	padding: 0
}

.flexslider .slides>li {
	display: none;
	-webkit-backface-visibility: hidden
}

.flexslider .slides img {
	width: 100%;
	display: block
}

.flexslider .slides:after {
	content: "\0020";
	display: block;
	clear: both;
	visibility: hidden;
	line-height: 0;
	height: 0
}

html[xmlns] .flexslider .slides {
	display: block
}

* html .flexslider .slides {
	height: 1%
}

.flexslider {
	margin: 0;
	background: #fff;
	border: 4px solid #fff;
	position: relative;
	zoom: 1;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	-webkit-box-shadow: '' 0 1px 4px rgba(0, 0, 0, .2);
	-moz-box-shadow: '' 0 1px 4px rgba(0, 0, 0, .2);
	-o-box-shadow: '' 0 1px 4px rgba(0, 0, 0, .2);
	box-shadow: '' 0 1px 4px rgba(0, 0, 0, .2)
}

.flexslider .slides {
	zoom: 1
}

.flexslider .slides img {
	height: auto;
	-moz-user-select: none
}

.flex-viewport {
	max-height: 2000px;
	-webkit-transition: all 1s ease;
	-moz-transition: all 1s ease;
	-ms-transition: all 1s ease;
	-o-transition: all 1s ease;
	transition: all 1s ease
}

@-moz-document url-prefix() {
	.loading .flex-viewport {
		max-height: none
	}
}

.carousel li {
	margin-right: 5px
}

.flex-direction-nav a {
	text-decoration: none;
	display: block;
	width: 40px;
	height: 40px;
	line-height: 40px;
	margin: -20px 0 0;
	position: absolute;
	top: 50%;
	z-index: 10;
	overflow: hidden;
	opacity: 0;
	cursor: pointer;
	color: rgba(0, 0, 0, .8);
	text-shadow: 1px 1px 0 rgba(255, 255, 255, .3);
	-webkit-transition: all .3s ease-in-out;
	-moz-transition: all .3s ease-in-out;
	-ms-transition: all .3s ease-in-out;
	-o-transition: all .3s ease-in-out;
	transition: all .3s ease-in-out
}

.flex-direction-nav a:before {
	font-family: flexslider-icon;
	font-size: 26px;
	display: inline-block;
	content: '\f001';
	color: rgba(0, 0, 0, .8);
	text-shadow: 1px 1px 0 rgba(255, 255, 255, .3)
}

.flex-direction-nav a.flex-next:before {
	content: '\f002'
}

.flex-direction-nav .flex-prev {
	left: -50px
}

.flex-direction-nav .flex-next {
	right: -50px;
	text-align: right
}

.flexslider:hover .flex-direction-nav .flex-prev {
	opacity: .7;
	left: 10px
}

.flexslider:hover .flex-direction-nav .flex-prev:hover {
	opacity: 1
}

.flexslider:hover .flex-direction-nav .flex-next {
	opacity: .7;
	right: 10px
}

.flexslider:hover .flex-direction-nav .flex-next:hover {
	opacity: 1
}

.flex-direction-nav .flex-disabled {
	opacity: 0!important;
	cursor: default;
	z-index: -1
}

@media screen and (max-width:860px) {
	.flex-direction-nav .flex-prev {
		opacity: 1;
		left: 10px
	}
	.flex-direction-nav .flex-next {
		opacity: 1;
		right: 10px
	}
}
    </style>
@endsection
@section("js_loc")
    <script type="text/javascript" src="https://www.google.com/books/jsapi.js"></script>




    <script>


function open_preview(){
newWindow_method_1();
}


function newWindow_method_1() {
  var wi = window.open("about:blank", "hello", "width=700,height=1000");
  var html = $('#viewer').html();
  $(wi.document.body).html(html);
}


        $(document).ready(function () {
            @if(!$book_obj->custom_file)
            google.books.load();

            function initialize() {
                var viewer = new google.books.DefaultViewer(document.getElementById('viewerCanvas'));
                viewer.load('ISBN:{{$book_obj->isbn_10??$book_obj->isbn_13}}');

            }

            google.books.setOnLoadCallback(initialize);
            show_preview = function () {



                $(".preview_container .collapse").toggle("show");
                initialize();


            };
            @else
            alert("hueeeh");
                show_preview = function () {
                $(".cust_overlay").fadeIn(300);
                $(".preview_container .collapse").toggle("show");
                @php $file_link = asset("uploads/".$book_obj->custom_file,false);@endphp
                @if(\Illuminate\Support\Str::endsWith($book_obj->custom_file,".pdf"))
                $("#viewerCanvas").html("<iframe width='100%' height='500px' src='{{$file_link}}'></iframe>");
                @elseif(\Illuminate\Support\Str::endsWith($book_obj->custom_file,[".doc",".docx"]))
                $("#viewerCanvas").html("<iframe src=\"https://docs.google.com/gview?url={{$file_link}}&embedded=true\"></iframe>");

                @else
                $("#viewerCanvas").html("<img src='{{$file_link}}' class='w-100'/>");

                @endif
                $(".cust_overlay").fadeOut(300);
            };
            @endif
        });

    </script>
@endsection
