{{-- @include("back.common.spinner") --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@php
$books = $common::getBooksDetailsForFrontEnd();

if(empty($books)){

}else{
$newbooks = $common::getBooksDetailsForFrontEndNew();
$prefbooks = $common::getBooksDetailsForFrontEndPersonalPreff();
$trendbooks = $common::getBooksDetailsForFrontEndPreff();
$unq_cat = array_column($books,"PARENT_CAT");
$unq_cat = array_unique($unq_cat);
$unq_pref = array_column($books,"Pref");
$unq_aut = call_user_func_array('array_merge',array_column($books,"AUTHOR"));
$unq_pub = call_user_func_array('array_merge',array_column($books,"PUBLISHER"));
$unq_qty = array_column($books,"QTY");
$unq_tag = call_user_func_array('array_merge',array_column($books,"TAG"));
$unq_aut = array_unique($unq_aut);
$unq_pub = array_unique($unq_pub);
$unq_qty = array_unique($unq_qty);
$unq_tag = array_unique($unq_tag);
$unq_pref =  array_unique($unq_tag);
}



@endphp
<style>@
   @media (min-width: 1200px){
   .container{
   max-width: 1400px
   }}
</style>
<script type="text/javascript"></script>
@if(!empty($books))
<div class=" d-flex">
   <div class="d-flex container" style="width: 100vw;">
      <div class="wrapper" style="width:100vw;">
         <div class="wrapper">
            <main>
               <div class="main-section d-flex justify-content-center">
                  <div class="container-fluid">
                     <div id="content" class="">
                        <div id="products">
                        <div id="alternewbook">
                           <div class="col-md-12">
                           

                                       <div style="height:60vh;overflow: hidden">
                                       <input type="radio" id="s-1" name="slider-control" checked="checked">
                                       @for($i=2; $i<=10; $i++)
                                       <input type="radio" id="s-{{$i}}" name="slider-control">
                                       @endfor
                                       <div class="js-slider">
                                          @php $counter =1; @endphp
                                          @foreach($trendbooks as $book)
                                          <figure class="js-slider_item img-{{$counter}}">
                                             <div class="js-slider_img">
                                                <img class="c-img-w-full" src="{{asset("uploads/".$util::fileChecker(public_path("uploads"),
                                                $book["CIMG"],config("app.BOOK_IMG_NOT_FOUND")))}}" alt="">
                                                <div class="c-img-w-black h-100" alt="">
                                                </div>
                                                <img class="c-img-w-cent c-img-h-cent" src="{{asset("uploads/".$util::fileChecker(public_path("uploads"),
                                                $book["CIMG"],config("app.BOOK_IMG_NOT_FOUND")))}}" alt="">
                                             </div>
                                             <div class="js-slider_nav_bot">
                                                <div class="wo-caption">
                                                   <h3 class="wo-h3">
                                                      <div class="c-label">{{$book["Frm"]}}</div>
                                                      <br class="view-sm mb-s"><span class="s-label">{{ str_limit($book["TITLE"], $limit = 35, $end = '...') }}</span>
                                                   </h3>
                                                   <ul class="wo-credit">
                                                      <li class="s-label">{{implode(",",array_map(function ($data) use($common){return ucfirst($common::getAuthorName($data));},$book["AUTHOR"]))}}</li>
                                                      <li class="s-label">{{Str::lower($common::getCatName($book["CATEGORY"]))}}</li>
                                                      <li class="s-label">{{implode(",",array_map(function ($data) use($common){return ucfirst($common::getPublisherName($data));},$book["PUBLISHER"]))}}
                                                         <span class="c-txt-s"> {{implode(",",array_map(function ($data) use($common){return ucfirst($common::getTagName($data));},$book["TAG"]))}}</span>
                                                      </li>
                                                   </ul>
                                                </div>
                                             </div>
                                          </figure>
                                          @php $counter = $counter +1;@endphp
                                          @endforeach
                                          <div class="js-slider_nav">
                                             @for($i=1; $i<=10; $i++)
                                             <label class="js-slider_nav_item s-nav-{{$i}} prev" for="s-{{$i-1}}"></label>
                                             <label class="js-slider_nav_item s-nav-{{$i}} next" for="s-{{$i+1 }}"></label>
                                             @endfor
                                          </div>
                                          <div class="js-slider_indicator">
                                             @for($i=1; $i<=10; $i++)
                                             <div class="js-slider-indi indi-{{$i}}"></div>
                                             @endfor
                                          </div>
                                       </div>
                                    </div>
                                    <style>
                                       input[type="radio"] {
                                       display: none;
                                       }
                                       .js-slider {
                                       position: relative;
                                       width: 100%;
                                       height: 100vh;
                                       margin: 0 auto;
                                       }
                                       .js-slider_item {
                                       position: absolute;
                                       left: 0;
                                       top: 0;
                                       width: 100%;
                                       height: 100%;
                                       opacity: 0;
                                       visibility: hidden;
                                       transform-origin: right center;
                                       transform: translate3d(0%, 0%, 0) rotateY(30deg) scaleX(0.95);
                                       transition: all 1s ease,transform 1s cubic-bezier(0.43, 0.28, 0.51, 1);
                                       }
                                       #s-1:checked ~ .js-slider .js-slider_item.img-1,
                                       #s-2:checked ~ .js-slider .js-slider_item.img-2,
                                       #s-3:checked ~ .js-slider .js-slider_item.img-3,
                                       #s-4:checked ~ .js-slider .js-slider_item.img-4,
                                       #s-5:checked ~ .js-slider .js-slider_item.img-5,
                                       #s-6:checked ~ .js-slider .js-slider_item.img-6,
                                       #s-7:checked ~ .js-slider .js-slider_item.img-7,
                                       #s-8:checked ~ .js-slider .js-slider_item.img-8,
                                       #s-9:checked ~ .js-slider .js-slider_item.img-9,
                                       #s-10:checked ~ .js-slider .js-slider_item.img-10{
                                       opacity: 1;
                                       visibility: visible;
                                       transform-origin: left center;
                                       transform: translate3d(0, 0, 0) rotateY(0deg) scaleX(1);
                                       }
                                       .js-slider_img {
                                       width: 100%;
                                       height: 60%;
                                       position: relative;
                                       overflow: hidden;
                                       }
                                       .c-img-w-full {
                                       background: linear-gradient(0deg, rgba(0,0,0,0.7763480392156863) 0%, rgba(0,0,0,0) 99%);
                                       position: absolute;
                                       top: 50%;
                                       left: 50%;
                                       width: 1100px;
                                       height: auto;
                                       filter: blur(15px);
                                       -webkit-filter: blur(15px);
                                       transform: translate3d(-50%, -50%, 0);
                                       }.c-img-w-black {
                                       position: absolute;
                                       top: 50%;
                                       left: 50%;
                                       width: 1100px;
                                       height: auto;
                                       background: linear-gradient(0deg, rgba(0,0,0,1) 0%, rgba(0,0,0,1) 0%, rgba(0,0,0,0) 100%);
                                       transform: translate3d(-50%, -50%, 0);
                                       }
                                       .c-img-h-full {
                                       position: absolute;
                                       top: 50%;
                                       left: 50%;
                                       width: auto;
                                       height: 1100px;
                                       transform: translate3d(-50%, -50%, 0);
                                       }.c-img-w-cent {
                                       position: absolute;
                                       top: 50%;
                                       left: 50%;
                                       width: 250px;
                                       height: auto;
                                       box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
                                       transform: translate3d(-50%, -50%, 0);
                                       }
                                       .c-img-h-cent {
                                       position: absolute;
                                       top: 50%;
                                       left: 50%;
                                       height: 350px;
                                       transform: translate3d(-50%, -50%, 0);
                                       }
                                       figcaption {
                                       display: block;
                                       }
                                       .wo-h3 {
                                       margin-top: 6rem;
                                       margin-bottom: 2rem;
                                       padding-bottom: 2rem;
                                       border-bottom: 1px solid #e5e4e4/* Old #f4d03f */;
                                       }
                                       .s-label {
                                       color: #ffffff;
                                       }
                                       .c-label {
                                       display: inline-block;
                                       color: #ffffff;
                                       background-color: #e5e4e4/* Old #f4d03f */;
                                       line-height: 1;
                                       padding: 0.5em 0.9em;
                                       margin-right: 0.5em;
                                       font-size: 1.4rem;
                                       font-weight: bold;
                                       }
                                       .view-sm {
                                       display: none;
                                       }
                                       .js-slider_nav {
                                       position: absolute;
                                       left: 0;
                                       top: 25%;
                                       width: 100%;
                                       transform: translate3d(0, -50%, 0);
                                       }.js-slider_nav_bot {
                                       position: absolute;
                                       left: 0;
                                       top: 46%;
                                       width: 100%;
                                       transform: translate3d(0, -50%, 0);
                                       }
                                       .js-slider_nav_item.prev {
                                       left: 0;
                                       }
                                       .js-slider_nav_item.next {
                                       right: 0;
                                       transform: rotateY(180deg);
                                       }
                                       .js-slider_nav_item {
                                       position: absolute;
                                       display: none;
                                       width: 3rem;
                                       margin:2rem;
                                       height: 3rem;
                                       border: 1px solid #e5e4e4/* Old #f4d03f */;
                                       border-radius: 50%;
                                       cursor: pointer;
                                       transition: 1s all cubic-bezier(0.075, 0.82, 0.165, 1);
                                       }
                                       .js-slider_nav_item:before {
                                       content: "";
                                       display: block;
                                       position: absolute;
                                       left: 1rem;
                                       top: 55%;
                                       width: 1rem;
                                       height: 1px;
                                       background-color: #e5e4e4/* Old #f4d03f */;
                                       transform-origin: left bottom;
                                       transform: translate3d(0, -50%, 0) rotate(-45deg);
                                       transition: 1s all cubic-bezier(0.075, 0.82, 0.165, 1);
                                       }
                                       .js-slider_nav_item:hover {
                                       transform: translate3d(-30%, 0, 0);
                                       }
                                       .js-slider_nav_item.next:hover {
                                       transform: rotateY(180deg) translate3d(-30%, 0, 0);
                                       }
                                       .js-slider_nav_item:hover:before {
                                       transform: translate3d(0, -50%, 0) rotate(-30deg);
                                       }
                                       .js-slider_nav_item:after {
                                       content: "";
                                       display: block;
                                       position: absolute;
                                       left: 1rem;
                                       top: 55%;
                                       width: 1rem;
                                       height: 1px;
                                       background-color: #e5e4e4/* Old #f4d03f */;
                                       transform-origin: left bottom;
                                       transform: translate3d(0, -50%, 0) rotate(45deg);
                                       transition: 1s all cubic-bezier(0.075, 0.82, 0.165, 1);
                                       }
                                       #s-1:checked ~ .js-slider .js-slider_nav .s-nav-1,
                                       #s-2:checked ~ .js-slider .js-slider_nav .s-nav-2,
                                       #s-3:checked ~ .js-slider .js-slider_nav .s-nav-3,
                                       #s-4:checked ~ .js-slider .js-slider_nav .s-nav-4,
                                       #s-5:checked ~ .js-slider .js-slider_nav .s-nav-5,
                                       #s-6:checked ~ .js-slider .js-slider_nav .s-nav-6,
                                       #s-7:checked ~ .js-slider .js-slider_nav .s-nav-7,
                                       #s-8:checked ~ .js-slider .js-slider_nav .s-nav-8,
                                       #s-9:checked ~ .js-slider .js-slider_nav .s-nav-9,
                                       #s-10:checked ~ .js-slider .js-slider_nav .s-nav-10 {
                                       display: block;
                                       }
                                       .js-slider_indicator {
                                       position: absolute;
                                       left: 0;
                                       top: 50%;
                                       width: 100%;
                                       text-align: center;
                                       }
                                       .js-slider-indi {
                                       position: relative;
                                       display: inline-block;
                                       padding: 1rem;
                                       cursor: pointer;
                                       }
                                       .js-slider-indi:after {
                                       content: "";
                                       position: absolute;
                                       top: 50%;
                                       left: 50%;
                                       width: 0.5rem;
                                       height: 0.5rem;
                                       border-radius: 1rem;
                                       background: #e5e4e4/* Old #f4d03f */;
                                       transform: translate3d(-50%, -50%, 0);
                                       }
                                       .js-slider-indi:hover:after {
                                       transform: translate3d(-50%, -50%, 0) scale(1.5);
                                       transition: 1s all cubic-bezier(0.075, 0.82, 0.165, 1);
                                       }
                                       #s-1:checked ~ .js-slider .js-slider_indicator .indi-1:after,
                                       #s-2:checked ~ .js-slider .js-slider_indicator .indi-2:after,
                                       #s-3:checked ~ .js-slider .js-slider_indicator .indi-3:after,
                                       #s-4:checked ~ .js-slider .js-slider_indicator .indi-4:after,
                                       #s-5:checked ~ .js-slider .js-slider_indicator .indi-5:after,
                                       #s-6:checked ~ .js-slider .js-slider_indicator .indi-6:after,
                                       #s-7:checked ~ .js-slider .js-slider_indicator .indi-7:after,
                                       #s-8:checked ~ .js-slider .js-slider_indicator .indi-8:after,
                                       #s-9:checked ~ .js-slider .js-slider_indicator .indi-9:after,
                                       #s-10:checked ~ .js-slider .js-slider_indicator .indi-10:after {
                                       transform: translate3d(-50%, -50%, 0) scale(2.5);
                                       }
                                    </style>
                                    <script>
                                       $('.slide-nav').on('click', function(e) {
                                         e.preventDefault();
                                         // get current slide
                                         var current = $('.flex--active').data('slide'),
                                           // get button data-slide
                                           next = $(this).data('slide');
                                       
                                         $('.slide-nav').removeClass('active');
                                         $(this).addClass('active');
                                       
                                         if (current === next) {
                                           return false;
                                         } else {
                                           $('.slider__warpper').find('.flex__container[data-slide=' + next + ']').addClass('flex--preStart');
                                           $('.flex--active').addClass('animate--end');
                                           setTimeout(function() {
                                             $('.flex--preStart').removeClass('animate--start flex--preStart').addClass('flex--active');
                                             $('.animate--end').addClass('animate--start').removeClass('animate--end flex--active');
                                           }, 800);
                                         }
                                       });
                                    </script>


                                    <div class="col-md-12">
                                       <br>
                                       <div class="section-heading">
                                          <div class="line-dec"></div>
                                          <h1>New Arrival! </h1>
                                       </div>
                                    </div>




                                    
                                    
                                    <div id="newbooks" class="row">
                                       @foreach($newbooks as $book)
                                       <div  class="col-lg-2 col-6 {{$common::utf8Slug(isset($book["PARENT_CAT"])?"mkr-".$common::getCatName($book["PARENT_CAT"]):"everyone")}}">
                                       <a data-toggle="tooltip" title="{{$book["TITLE"]}}" style=" padding:0" href="{{route("details", ['page_slug' => $common::utf8Slug($book["TITLE"])])}}
                                       ">
                                       <div class="yellow card pt-3 d-flex flex-column align-items-left overflow-hidden">
                                          <div class="d-flex w-100 align-items-center justify-content-center">
                                             <div class="d-flex "> <img style="width:120px; height:165px" src="{{asset("uploads/".$util::fileChecker(public_path("uploads"),
                                                $book["CIMG"],config("app.BOOK_IMG_NOT_FOUND")))}}" alt="hatdog to"> 
                                             </div>
                                          </div>
                                          <div class="d-flex pt-2 product-name align-items-left" style="height:68px"><span>{{ str_limit($book["TITLE"], $limit = 35, $end = '...') }}</span></div>
                                          <div class="">
                                             <figcaption class="fig_cap_holder @if(intval($book["TBOOKS"])-intval($book["BORROWED"])==0) all_issued @endif">
                                             <div class="text-muted text-center mt-auto">-{{str_limit(ucfirst(implode(",",array_map(function ($data) use($common){return Str::lower($common::getAuthorName($data));},$book["AUTHOR"]))), $limit = 17, $end = '...') }} </div>
                                             </figcaption>
                                             <figcaption
                                             class="fig_cap_holder @if(intval($book["TBOOKS"])-intval($book["BORROWED"])==0) all_issued @endif">
                                             
                                              @if($book["QTY"] - ($book["Request"] + $book["BORROWED"])==0)
                                             <div class="text-muted text-center mt-auto" style="color:red!important">Reserved</div>
                                             @else
                                             <div class="text-muted text-center mt-auto">{{$book["QTY"] - ($book["Request"] + $book["BORROWED"])}} Book Available</div>
                                             @endif


                                             

                                            
                                             </figcaption>
                                             <div class="d-flex align-items-center justify-content-center colors my-2">
                                             </div>
                                          </div>
                                       </div>
                                       </a>
                                       <div class="d-none title">
                                          {{Str::lower($book["TITLE"])}},
                                          {{Str::lower($common::getCatName($book["CATEGORY"]))}}
                                          {{implode(",",array_map(function ($data) use($common){return Str::lower($common::getAuthorName($data));},$book["AUTHOR"]))}}
                                          {{implode(",",array_map(function ($data) use($common){return Str::lower($common::getPublisherName($data));},$book["PUBLISHER"]))}}
                                          {{implode(",",array_map(function ($data) use($common){return Str::lower($common::getTagName($data));},$book["TAG"]))}}
                                       </div>
                                    </div>
                                    @endforeach
                                 </div>


                                 

                                 

                                 <div class="col-md-12">
                                    <div class="section-heading">
                                       <div class="line-dec"></div>
                                       <h1>Just For You </h1>
                                    </div>
                                 </div>






                                 
                                 
                                 <div id="prefbook" class="row">
                                    @foreach($prefbooks as $book)
                                    <div  class="col-lg-2 col-6 {{$common::utf8Slug(isset($book["PARENT_CAT"])?"mkr-".$common::getCatName($book["PARENT_CAT"]):"everyone")}}">
                                    <a data-toggle="tooltip" title="{{$book["TITLE"]}}" style=" padding:0" href="{{route("details", ['page_slug' => $common::utf8Slug($book["TITLE"])])}}
                                    ">
                                    <div class="yellow card pt-3 d-flex flex-column align-items-left overflow-hidden">
                                       <div class="d-flex w-100 align-items-center justify-content-center">
                                          <div class="d-flex "> <img style="width:120px; height:165px" src="{{asset("uploads/".$util::fileChecker(public_path("uploads"),
                                             $book["CIMG"],config("app.BOOK_IMG_NOT_FOUND")))}}" alt="hatdog to"> 
                                          </div>
                                       </div>
                                       <div class="d-flex pt-2 product-name align-items-left" style="height:68px"><span>{{ str_limit($book["TITLE"], $limit = 35, $end = '...') }}</span></div>
                                       <div class="">
                                          <figcaption
                                          class="fig_cap_holder @if(intval($book["TBOOKS"])-intval($book["BORROWED"])==0) all_issued @endif">
                                          <div class="text-muted text-center mt-auto">-{{str_limit(ucfirst(implode(",",array_map(function ($data) use($common){return Str::lower($common::getAuthorName($data));},$book["AUTHOR"]))), $limit = 17, $end = '...') }}</div>
                                          </figcaption>
                                          <figcaption
                                          class="fig_cap_holder @if(intval($book["TBOOKS"])-intval($book["BORROWED"])==0) all_issued @endif">
                                          @if(intval($book["TBOOKS"])-intval($book["BORROWED"])==0)
                                          <div class="text-muted text-center mt-auto" style="color:red!important">Not Available</div>
                                          @else
                                          <div class="text-muted text-center mt-auto">{{$book["QTY"] - $book["BORROWED"]}} Book Available</div>
                                          @endif
                                          </figcaption>
                                          <div class="d-flex align-items-center justify-content-center colors my-2">
                                          </div>
                                       </div>
                                    </div>
                                    </a>
                                    <div class="d-none title">
                                       {{Str::lower($book["TITLE"])}},
                                       {{Str::lower($common::getCatName($book["CATEGORY"]))}}
                                       {{implode(",",array_map(function ($data) use($common){return Str::lower($common::getAuthorName($data));},$book["AUTHOR"]))}}
                                       {{implode(",",array_map(function ($data) use($common){return Str::lower($common::getPublisherName($data));},$book["PUBLISHER"]))}}
                                       {{implode(",",array_map(function ($data) use($common){return Str::lower($common::getTagName($data));},$book["TAG"]))}}
                                    </div>
                                 </div>
                                 @endforeach
                                 </div>





                              </div>
                           </div>




                           <div class="col-md-12">
                              <div class="section-heading">
                                 <div class="line-dec"></div>
                                 <h1 id="search" >You May Also Like </h1>
                              </div>
                           </div>
                        </div>
                        <div id="change" class="row mx-0 grid ">
                           <script>
                              $("#change").hide();
                           </script>
                           @foreach($books as $book)
                           <div  class="col-lg-2 col-6 {{$common::utf8Slug(isset($book["PARENT_CAT"])?"mkr-".$common::getCatName($book["PARENT_CAT"]):"everyone")}}">
                           <a data-toggle="tooltip" title="{{$book["TITLE"]}}" style=" padding:0" href="{{route("details", ['page_slug' => $common::utf8Slug($book["TITLE"])])}}
                           ">
                           <div class="yellow card pt-3 d-flex flex-column align-items-left overflow-hidden">
                              <div class="d-flex w-100 align-items-center justify-content-center">
                                 <div class="d-flex "> <img style="width:120px; height:165px" src="{{asset("uploads/".$util::fileChecker(public_path("uploads"),
                                    $book["CIMG"],config("app.BOOK_IMG_NOT_FOUND")))}}" alt="hatdog to"> 
                                 </div>
                              </div>
                              <div class="d-flex pt-2 product-name align-items-left" style="height:68px"><span>{{ str_limit($book["TITLE"], $limit = 35, $end = '...') }}</span></div>
                              <div class="">
                                 <figcaption
                                 class="fig_cap_holder @if(intval($book["TBOOKS"])-intval($book["BORROWED"])==0) all_issued @endif">
                                 <div class="text-muted text-center mt-auto">-{{str_limit(ucfirst(implode(",",array_map(function ($data) use($common){return Str::lower($common::getAuthorName($data));},$book["AUTHOR"]))), $limit = 17, $end = '...') }}</div>
                                 </figcaption>
                                 <figcaption
                                 class="fig_cap_holder @if(intval($book["TBOOKS"])-intval($book["BORROWED"])==0) all_issued @endif">
                                 @if(intval($book["TBOOKS"])-intval($book["BORROWED"])==0)
                                 <div class="text-muted text-center mt-auto" style="color:red!important">Not Available</div>
                                 @else
                                 <div class="text-muted text-center mt-auto">{{$book["QTY"] - $book["BORROWED"]}} Book Available</div>
                                 @endif
                                 </figcaption>
                                 <div class="d-flex align-items-center justify-content-center colors my-2">
                                 </div>
                              </div>
                           </div>
                           </a>
                           <div class="d-none title">
                              {{Str::lower($book["TITLE"])}},
                              {{Str::lower($common::getCatName($book["CATEGORY"]))}}
                              {{implode(",",array_map(function ($data) use($common){return Str::lower($common::getAuthorName($data));},$book["AUTHOR"]))}}
                              {{implode(",",array_map(function ($data) use($common){return Str::lower($common::getPublisherName($data));},$book["PUBLISHER"]))}}
                              {{implode(",",array_map(function ($data) use($common){return Str::lower($common::getTagName($data));},$book["TAG"]))}}
                           </div>
                        </div>
                        @endforeach
                     </div>
                     <center>  @if(isset($data))
                        {{$data->links()}}
                        @endif
                     </center>
                  </div>
               </div>
         </div>
      </div>
      </main>
      <div id="sidebar-overlay"></div>
   </div>
   <div id="sidebar-overlay"></div>
</div>
</div>
</div>
<script>
   $("#search_book").on("keypress", function (e) {
              
               if (e.which == 13) {
                   if ($("#search_book").val().length > 2) {
                      
                       
                       $('#alternewbook').remove();
                   }
                   
                   if ($("#search_book").val().length == 0) {
                       $grid.isotope({filter: ''});
                       
                       
                       $('#alternewbook').remove();
                   }
               }
           });
</script>
@else
<center>
<center style="width:800px">
<br><br><br>
<h1 >"Don't worry, your book will be available for browsing soon! We just need you to encode it first. Keep up the good work!"</h1>
</center>
<center>
@endif
