@php
    /* @var \App\Facades\Util $util */
    /* @var \App\Facades\Common $common */
@endphp
@extends("front.master")
@section("content")

    <!--====== SLIDER PART START ======-->

    <section id="home" class="slider_area">
        @php $all_sliders = \App\Models\Slider::all(); @endphp
        @if(is_countable($all_sliders) && count($all_sliders)>0)
        <div id="carouselThree" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselThree" data-slide-to="0" class="active"></li>
                <li data-target="#carouselThree" data-slide-to="1"></li>
                <li data-target="#carouselThree" data-slide-to="2"></li>
            </ol>
            <div id="parent" class="carousel-inner">
                @foreach($all_sliders as $slider_obj)
                    <div class="carousel-item @if($loop->index==0) active @endif">
                        <div class="container-fluid p-0">
                            <div class="row no-gutters">
                                <div class="col-lg-12">
                                    <div id="child" class="slider-content p-0">
                                        <img   style="height:100%;" src="{{asset('uploads/'.$slider_obj->image)}}" alt="Slider_{{$loop->index}}" class="w-100 slider_img">
                                        <div class="slider_h1_holder"><h1 class="title">{{$slider_obj->header}}</h1></div>
                                        <div class="slider_h3_holder"><h3 class="text m-0 slider_h3">{{$slider_obj->sub_header}}</h3></div>
                                    </div>
                                </div>
                            </div> <!-- row -->
                        </div> <!-- container -->
                    </div> <!-- carousel-item -->
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#carouselThree" role="button" data-slide="prev">
                <i class="lni lni-arrow-left"></i>
            </a>
            <a class="carousel-control-next" href="#carouselThree" role="button" data-slide="next">
                <i class="lni lni-arrow-right"></i>
            </a>
        </div>
        @endif
    </section>
    @if($common::getSiteSettings("no_of_faqs",0)>0)
        <section id="about" class="about-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="faq-content mt-45">
                            <div class="about-title">
                                <h6 class="sub-title">{{__("common.a_little_more_about_us")}}</h6>
                                <h4 class="title">{!! $common::getSiteSettings("faq_heading") !!}</h4>
                            </div> 
                            <div class="about-accordion">
                                <div class="accordion" id="accordion">
                                    @foreach(range(1,$common::getSiteSettings("no_of_faqs")) as $i)
                                        <div class="card">
                                            <div class="card-header blue" id="heading{{$i}}">
                                                <a href="#" data-toggle="collapse" data-target="#collapse{{$i}}"
                                                   aria-expanded="@if($loop->first) true @else false @endif"
                                                   aria-controls="">{!! Str::title($common::getSiteSettings("faq_que_".$i)) !!}
                                                  
                                           <span class="float-right"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
  <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
</svg></span>
                                             

                                                   </a>
                                                   
                                            </div>

                                            <div id="collapse{{$i}}" class="collapse @if($loop->first)  @endif"
                                                 aria-labelledby="heading{{$i}}"
                                                 data-parent="#accordion">
                                                <div class="card-body yellow">
                                                    <p class="text">{!!  $common::getSiteSettings("faq_ans_".$i)!!}</p>
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                        
                                    @endforeach

                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-7">
                        <div class="about-image">
                            <img src="{{asset('uploads/faq-banner.png')}}" alt="about">
                        </div>
                    </div>
                </div> 
            </div> 
        </section>
    @endif


   
@endsection

@section("css_loc")
    <style>
        .all_issued {
            background-color: red;
            color: white;
        }

        .search_txtbox {
            font-size: 17px !important;
            border: 2px solid #e85454 !important;
            padding: 5px !important;
            height: 68px !important;
            box-shadow: 0px 2px 19px 0px rgb(21 18 18 / 18%);
        }

        .border-radius-0 {
            border-radius: 0 !important;
        }

        .dewey_holder {
            right: 0;
            text-align: right;
            bottom: -24px;
            background-color: black;
            color: white;
        }

        .book_wrapper {
            box-shadow: 0px 19px 50px 0px rgb(21 18 18 / 25%);
            padding-bottom: 3%;
        }

    </style>

@endsection
@section("js_loc")
    <script>
        $(document).ready(function () {
            $(".bhoechie-tab-menu>div.list-group>a").click(function (e) {
                e.preventDefault();
                $(this).siblings('a.active').removeClass("active");
                $(this).addClass("active");
                var index = $(this).index();
                $(".bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
                $(".bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
            });
            $("#home_bread").on("click", function (e) {
                e.preventDefault();
                window.livewire.emit('data_manager', {'sel_main_cat': '', "sel_sub_cat": ''});
            });
            $("#main_bread").on("click", function (e) {
                e.preventDefault();
                debugger;
                window.livewire.emit('data_manager', {"sel_sub_cat": ''});
            });
        });

        $(window).on('resize', function(){
        if(screen.width > 820){
        document.getElementById("parent").style.height = screen.height * 0.9 + "px";
        document.getElementById("child").style.height = screen.height * 0.9 + "px";
        }else{
         document.getElementById("parent").style.height = null;
                document.getElementById("child").style.height = null;
        }

        });
        if(screen.width > 820){
         document.getElementById("parent").style.height = screen.height * 0.9 + "px";
        document.getElementById("child").style.height = screen.height * 0.9 + "px";
        }else{
         document.getElementById("parent").style.height = null;
                document.getElementById("child").style.height =null;
        }
    </script>
@endsection
