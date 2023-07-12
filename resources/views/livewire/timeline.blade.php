@php
$loading_target ="activeUser";
@endphp


 <div class="d-flex">

            <div id="menu" class="container-fluid py-4" >
       <div class="wrapper">



<div class="wrapper">



        <main>
            <div class="main-section d-flex justify-content-center">
                <div class="">
                    <div class="main-section-data ">
                        <div class="row">

                         <div class="row">
                         @include("back.common.spinner")
                            <div class="col-lg-3 p-4">
                                <div class="user-data full-width">
                                        <div class="user-profile">
                                            <div class="username-dt">
                                                <div class="usr-pic">
                                                    <img style="width:100%; height:100%" src="{{asset("uploads/".$photo_link)}}" alt="">
                                                </div>
                                            </div><!--username-dt end-->
                                            <div class="user-specs">
                                                <h3>{{$this->name}}</h3>
                                                 @foreach($current_user->roles as $role)
                                            <span
                                                class="badge badge-dark">{{\Illuminate\Support\Str::title($role->name)}}</span>
                                        @endforeach
                                                @php
                                            use App\Models\UserMeta as meta;
                                            $assigned_on = null;
                                            $user_meta = meta::where("user_id",\Illuminate\Support\Facades\Auth::id())->first();
                                            if($user_meta){
                                            $assigned_on = json_decode($user_meta->get_assign());
                                            }
                                        @endphp
                                        @if($assigned_on)
                                            @foreach($assigned_on as $items)
                                                @foreach($items as $std=>$div)
                                                @php
                                                $currentCourse = $std;
                                                $currentYear = $div;
                                                $currentSection = $std.$div;
                                                @endphp
                                                    <span
                                                        class="badge badge-primary">
                                                        {{Str::title($common::getCourseName($std))}} {{Str::title($common::getCourseYearName($div))}}</span>
                                                    <br/>
                                                @endforeach
                                            @endforeach
                                        @endif
                                            </div>
                                        </div><!--user-profile end-->




                                    @if(!empty($about_me))
                                        <strong> {{__("common.about_me")}}</strong>
                                        <p class="text-muted">{{$about_me}}</p>
                                    @endif
                                    </div>





                                      @php
                                        $clicked =  App\Models\BookMeta::whereBetween('created_at', [Carbon\Carbon::now()->startOfWeek(Carbon\Carbon::MONDAY), Carbon\Carbon::now()->endOfWeek(Carbon\Carbon::SUNDAY)])->where('meta_key','Views')->orderByRaw('CONVERT(meta_value, SIGNED) desc')->LIMIT(10)->get();
                                       
                                    @endphp
                                    <div class="widget widget-jobs">
                                        <div class="sd-title">
                                            <h3>Most Viewed This Week</h3>
                                            <i class="la la-ellipsis-v"></i>
                                        </div>
                                        <div class="jobs-list">
                                         @if($clicked->isEmpty())
   <div class="job-info">    <div class="job-info">
                                                <div class="job-details w-100">
                                                    <h3>Data is not yet available.</h3>
                                                </div>

                                            </div>
                                            </div>
                                            
@endif
                                        @foreach($clicked as $views)
                                        <a wire:click="activeUser" class="p-0" href="{{route("details", ['page_slug' => $common::utf8Slug(App\Models\SubBook::get_directuniquebook_name($views->unique_id))])}}">
                                            <div class="job-info">
                                                <div class="job-details w-100">
                                                    <h3>{{str_limit(Illuminate\Support\Str::limit(App\Models\SubBook::get_directuniquebook_name($views->unique_id), 45,), $limit = 20, $end = '...')}}</h3>

                                                </div>

                                            </div>
                                            </a>
<!--job-info end-->                     @endforeach

<!--job-info end-->
                                        </div>
                                        </div>

                                        @php
                                        $clickeed =  App\Models\BookMeta::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->where('meta_key','Views')->orderByRaw('CONVERT(meta_value, SIGNED) desc')->LIMIT(10)->get();

                                    @endphp
                                    <div class="widget widget-jobs">
                                        <div class="sd-title">
                                            <h3>Most Viewed This Month</h3>
                                            <i class="la la-ellipsis-v"></i>
                                        </div>
                                        <div class="jobs-list">
                                         @if($clicked->isEmpty())
   <div class="job-info">    <div class="job-info">
                                                <div class="job-details w-100">
                                                    <h3>Data is not yet available.</h3>
                                                </div>

                                            </div>
                                            </div>
                                            @endif
                                        @foreach($clickeed as $views)
                                        <a wire:click="activeUser" class="p-0" href="{{route("details", ['page_slug' => $common::utf8Slug(App\Models\SubBook::get_directuniquebook_name($views->unique_id))])}}">
                                            <div class="job-info">
                                                <div class="job-details w-100">
                                                    <h3>{{str_limit(Illuminate\Support\Str::limit(App\Models\SubBook::get_directuniquebook_name($views->unique_id), 45,), $limit = 20, $end = '...')}}</h3>

                                                </div>

                                            </div>
                                            </a>
<!--job-info end-->                     @endforeach
<!--job-info end-->
                                        </div>
                                        </div>
                            </div>
                            <div class="col-lg-6 p-4">
                                <div class="main-ws-sec">
                                    <!--post-topbar end-->
                                    <div class="posts-section">





















                                    @php

    function date_compare($element1, $element2) {
    $datetime1 = strtotime($element1['created_at']);
    $datetime2 = strtotime($element2['created_at']);
    return $datetime1 - $datetime2;
    }

 usort($this->merged, 'date_compare');
 $this->merged = array_reverse($this->merged);
                                    @endphp
                                     @include("back.common.spinner")

                                     @if(empty($this->merged))
    
   <div class=" yellow post-bar">
                                    <div class="post_topbar">
                                          <div class="usy-dt">
                                             <img  style="width:50px;cursor: pointer"  data-toggle="tooltip" data-placement="top"
                                             class="img-thumbnail" src="{{asset('uploads/lugusatilit.png')}}" />

                                             <div class="usy-name">
                                              <h5 style="
    margin: 0;
    padding: 0;
    border: 0;
    font-size: 16px;
    font: inherit;
    vertical-align: baseline;
    color: #000;
    text-transform: capitalize;
    font-weight: 600;
    margin-bottom: 6px;
    margin-top: 2px;
">Saint Francis of Assisi College</h5>
                                               
                                             </div>
                                          </div>
                                       </div>
                                     <img  style="width:100%     margin-top: 50px;
    padding: 0; ;cursor: pointer"  data-toggle="tooltip" data-placement="top"
                                             class="img-thumbnail"
                                             src="{{asset('uploads/defaultcover.png')}}" />
                                       
                                       <div class="job_descp">
                                          <center>
                                         
                                          </center>
                                          <br>
                                           <a  class="p-0 m-0" href="#" style="color:black"><h2>
                                         Ready, set, explore!</h2></a>
                                          <p  style="text-align: justify;text-justify: inter-word;">
                                            Get ready to dive into the data! It's always here and waiting for you to uncover its secrets The data is eagerly waiting for you to unlock it! Let's get exploring!

                                          </p>
                                          <ul class="skill-tags">
                                             
                                          </ul>
                                       </div>
                                       <div class="job-status-bar">
                                          
                                       </div>
                                    </div>
@endif

                                        @foreach($this->merged as $data)








                                        @if($data["views"] == 1)
                                        @php
                                        $validator = false;
                                        @endphp
                                        @else
                                        @php
                                           $validator = false;
                                            $poster = null;
                                            $user_metaa = meta::where("user_id",$data["Id"])->first();
                                            if($user_metaa){
                                            $poster = json_decode($user_metaa->get_assign());
                                            }
                                        @endphp
                                        @if($poster)
                                            @foreach($poster as $items)
                                                @foreach($items as $std=>$div)
                                                @php
                                                $pcurrentCourse = $std;
                                                $pcurrentYear = $div;
                                                $pcurrentSection = $std.$div;
                                                @endphp
                                                @endforeach
                                            @endforeach
                                        @endif
                                        @endif


                                        @if($data["views"] == 2)
                                        @php
                                        if($pcurrentCourse == $currentCourse){
                                            $validator = true;
                                        }
                                        @endphp


                                        @elseif($data["views"] == 3)
                                        @php
                                        if(substr($pcurrentYear, 0, 1) == substr($currentYear, 0, 1)){
                                            $validator = true;
                                        }
                                        @endphp


                                        @elseif($data["views"] == 4)
                                        @php
                                        if($pcurrentSection == $currentSection){

                                            $validator = true;
                                        }
                                        @endphp
                                        @elseif($data["views"] == 5)
                                        @php
                                        if(strval(Auth::id()) == $data["Id"]){
                                            $validator = true;
                                        }
                                        @endphp
                                        @endif











                                        @php
                                        $validator = true
                                        @endphp



                                       @if($validator == true)
                                           @php
                                               @endphp
                                    <div class="yellow post-bar">
                                       <div class="post_topbar">
                                          <div class="usy-dt">
                                             <img  style="width:50px;cursor: pointer"  data-toggle="tooltip" data-placement="top"
                                             class="img-thumbnail" wire:click="activeUser" onclick="location='{{route("profile", ['v_id' => $common::utf8Slug($data["Id"])])}}'"
                                             src="{{asset($data["image"])}}" />
                                             <div class="usy-name">
                                                <a href="{{route("profile", ['v_id' => $common::utf8Slug($data["Id"])])}}" style="color:#000;padding:0;"><h5 style="
    margin: 0;
    padding: 0;
    border: 0;
    font-size: 16px;
    font: inherit;
    vertical-align: baseline;
    color: #000;
    text-transform: capitalize;
    font-weight: 600;
    margin-bottom: 6px;
    margin-top: 2px;
">{{$data["name"]}}</h5></a>
                                                <span>{{$data["created_at"]->diffForHumans()}}&#9;&#9;
                                                @if($data["views"] ==1)
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-globe2" viewBox="0 0 16 16" >
                                                <title>Shared with Everyone</title>
  <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855-.143.268-.276.56-.395.872.705.157 1.472.257 2.282.287V1.077zM4.249 3.539c.142-.384.304-.744.481-1.078a6.7 6.7 0 0 1 .597-.933A7.01 7.01 0 0 0 3.051 3.05c.362.184.763.349 1.198.49zM3.509 7.5c.036-1.07.188-2.087.436-3.008a9.124 9.124 0 0 1-1.565-.667A6.964 6.964 0 0 0 1.018 7.5h2.49zm1.4-2.741a12.344 12.344 0 0 0-.4 2.741H7.5V5.091c-.91-.03-1.783-.145-2.591-.332zM8.5 5.09V7.5h2.99a12.342 12.342 0 0 0-.399-2.741c-.808.187-1.681.301-2.591.332zM4.51 8.5c.035.987.176 1.914.399 2.741A13.612 13.612 0 0 1 7.5 10.91V8.5H4.51zm3.99 0v2.409c.91.03 1.783.145 2.591.332.223-.827.364-1.754.4-2.741H8.5zm-3.282 3.696c.12.312.252.604.395.872.552 1.035 1.218 1.65 1.887 1.855V11.91c-.81.03-1.577.13-2.282.287zm.11 2.276a6.696 6.696 0 0 1-.598-.933 8.853 8.853 0 0 1-.481-1.079 8.38 8.38 0 0 0-1.198.49 7.01 7.01 0 0 0 2.276 1.522zm-1.383-2.964A13.36 13.36 0 0 1 3.508 8.5h-2.49a6.963 6.963 0 0 0 1.362 3.675c.47-.258.995-.482 1.565-.667zm6.728 2.964a7.009 7.009 0 0 0 2.275-1.521 8.376 8.376 0 0 0-1.197-.49 8.853 8.853 0 0 1-.481 1.078 6.688 6.688 0 0 1-.597.933zM8.5 11.909v3.014c.67-.204 1.335-.82 1.887-1.855.143-.268.276-.56.395-.872A12.63 12.63 0 0 0 8.5 11.91zm3.555-.401c.57.185 1.095.409 1.565.667A6.963 6.963 0 0 0 14.982 8.5h-2.49a13.36 13.36 0 0 1-.437 3.008zM14.982 7.5a6.963 6.963 0 0 0-1.362-3.675c-.47.258-.995.482-1.565.667.248.92.4 1.938.437 3.008h2.49zM11.27 2.461c.177.334.339.694.482 1.078a8.368 8.368 0 0 0 1.196-.49 7.01 7.01 0 0 0-2.275-1.52c.218.283.418.597.597.932zm-.488 1.343a7.765 7.765 0 0 0-.395-.872C9.835 1.897 9.17 1.282 8.5 1.077V4.09c.81-.03 1.577-.13 2.282-.287z"/></svg>
@elseif($data["views"] == 5)
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
<title>Only Me</title>
  <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
</svg>
@else
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
@if($data["views"] == 2)
<title>Shared within current course</title>
@elseif($data["views"] == 3)
<title>Shared within year level</title>
@elseif($data["views"] == 4)
<title>Shared with current section</title>
@elseif($data["views"] == 5)
<title>Only Me</title>
@endif
  <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
</svg>
@endif
</span>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="job_descp">

                                          <center>
                                              <a  class="p-0 m-0" wire:click="activeUser" href="#" style="color:black"><img  style="width:200px;cursor: pointer;"  data-toggle="tooltip" data-placement="top"
                                             class="img-thumbnail"
                                             src="{{asset(str_replace (array('[', ']','"', '"'), '' , $data["book_img"]))}}"
                                             /></a>
                                          </center>
                                          <br>
                                          <a  class="p-0 m-0" wire:click="activeUser" href="#" style="color:black"><h2>
                                          {{$data["title"]}}</h2></a>
                                          <p style="text-align: justify;text-justify: inter-word;">
                                          {!! str_limit($data["desc"], $limit = 350, $end = '...') !!}
                                         {{-- <a wire:click="activeUser" href="{{route("details", ['page_slug' => $common::utf8Slug($data["title"])])}}" title="">{{$data["View"]}}</a>
                                          --}}</p>
                                          <ul class="skill-tags">
                                             <li></li>
                                          </ul>
                                       </div>
                                       <div class="job-status-bar">
                                          {{--<a>{!! str_replace (array('[', ']','"'), '' , $data["isReturned"]) !!}</a>--}}
                                       </div>
                                    </div>

                                    <!--post-bar end-->
                                     @endif
                                    @endforeach
                                        </div><!--post-bar end-->

                                        <!--post-bar end-->
                                        <!--posty end-->
                                        <!--process-comm end-->
                                    </div>
<!--main-ws-sec end-->
                            </div>
                            <div class="col-lg-3 p-4">
                                <div class="right-sidebar">
                                     <div class="widget widget-jobs">
                                        <div class="sd-title">
                                            <h3>Trending This Month</h3>
                                            <i class="la la-ellipsis-v"></i>
                                        </div>
                                        @php
                                    $trendbooks = $common::getBooksDetailsForFrontEndPreffTrendCategMonthly();
                                    @endphp

                                        <div class="jobs-list">

                                         @if(empty($trendbooks))
   <div class="job-info">    <div class="job-info">
                                                <div class="job-details w-100">
                                                    <h3>Data is not yet available.</h3>
                                                </div>

                                            </div>
                                            </div>
                                            @endif

                                    @foreach($trendbooks as $book)
                                    <a wire:click="activeUser" class="p-0" href="{{route("details", ['page_slug' => $common::utf8Slug($book["TITLE"])])}}">
                                            <div class="job-info">
                                                <div class="job-details w-100">
                                                    <h3>{{ str_limit($book["TITLE"], $limit = 20, $end = '...') }}</h3>
                                                    <p>{{Ucfirst($common::getCatName($book["CATEGORY"]))}}</p>
                                                </div>

                                            </div>
                                            </a>

<!--job-info end-->             @endforeach

<!--job-info end-->
                                        </div>
                                        </div>
<!--jobs-list end-->
<!--widget-about end-->
                                    <div class="widget widget-jobs">
                                        <div class="sd-title">

                                            <h3>You May Also Like</h3>
                                            <i class="la la-ellipsis-v"></i>
                                        </div>
                                        <div class="jobs-list">

                                         @php
                                    $prefbooks = $common::getBooksDetailsForFrontEndPersonalPreff();
                                  
                                    @endphp
                                    @if(empty($prefbooks))
   <div class="job-info">
                                                <div class="job-details w-100">
                                                    <h3>Data is not yet available.</h3>
                                                </div>
                                                <div class="hr-rate">

                                                </div>
                                            </div>
@endif
                                    @foreach(array_slice($prefbooks,10) as $book)
                                    <a wire:click="activeUser" class="p-0" href="{{route("details", ['page_slug' => $common::utf8Slug($book["TITLE"])])}}">
                                            <div class="job-info">
                                                <div class="job-details w-100">
                                                    <h3>{{ str_limit($book["TITLE"], $limit = 20, $end = '...') }}</h3>
                                                    <p>{{Ucfirst($common::getCatName($book["CATEGORY"]))}}</p>
                                                </div>
                                                <div class="hr-rate">

                                                </div>
                                            </div>
                                            </a>
                                            @endforeach

                                        </div>
<!--jobs-list end-->
                                    </div>
<!--widget-jobs end-->

                                    </div>
<!--widget-jobs end-->
                                </div>
<!--right-sidebar end-->
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    <div id="sidebar-overlay"></div></div>
    <div id="sidebar-overlay"></div></div>
    </div>
    </div>
