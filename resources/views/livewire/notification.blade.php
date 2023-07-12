<div class="w-100">
    @php
        /* @var \App\Facades\Util $util */
        /* @var \App\Facades\Common $common */
    @endphp
     
    @php

     $notif = new \App\Models\UserNotif;
    @endphp
    @can("mng-notif-admin")@php
    $data = $notif->verify("mng-notif-admin");@endphp
    @endcan
    @can("mng-notif-librarian")@php
    $data = $notif->verify("mng-notif-librarian");@endphp
    @endcan
    @can("mng-notif-sa")@php
    $data = $notif->verify("mng-notif-sa");@endphp
    @endcan
    @can("mng-notif-regular")@php
    $data = $notif->verify("mng-notif-regular");@endphp
    @endcan

    @php
     
     if (isset($_GET['id'])) {
        read($_GET['id']);
      }
     
     $notifread = new \App\Models\UserNotifread;
     
     $unread = 0;
     $final = array_slice($data,0,8);
     $totalunread=0;
      

  

    
     @endphp
    @include("back.common.spinner")
    <section class="content">
                <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="">
                    <div class="">
                    <div class="col-lg-12">
							<div class="tab-content yellow" id="nav-tabContent">
								<div class="tab-pane fade show active" id="nav-acc" role="tabpanel" aria-labelledby="nav-acc-tab">
                                <div class="acc-setting">
										<h3>All Notification <a class="float-right">Mark all as read </a></h3> 

                                        


                                        @foreach ($data as $item)
     <div class="notbar">
     @php
     $notifstatus = $notifread->verifynotif($item["id"]);
     
     @endphp

     @if($item["Meta_key"] =="Request")  <a style="padding: 0!important" href="{{url('/cycle-books')}}"></span>@endif
        @if($item["Meta_key"] =="Approved")<a style="padding: 0!important" href="{{url('/issued-books')}}">@endif
        @if($item["Meta_key"] =="NewBook") <a style="padding: 0!important" href="{{route("details", ['page_slug' => $common::utf8Slug(\App\Models\Book::get_book_name($item["Target"]))])}}
                                 ">@endif
        @if($item["Meta_key"] =="Promotion")<a style="padding: 0!important" href="{{url('/role-perm-mng')}}">@endif
        @if($item["Meta_key"] =="Notice")<a style="padding: 0!important" href="{{url('/notice-mng')}}">@endif
        @if($item["Meta_key"] =="Carousel")<a style="padding: 0!important" href="{{url('/slider-mng')}}">@endif
        @if($item["Meta_key"] =="Enquiries")<a style="padding: 0!important" href="{{url('/enquiry-mng')}}">@endif




     @if($notifstatus["archived"]==1)
       <div class="notification d-none">
     @endif
     @if($notifstatus["unarchived"] ==0)
        @if($notifstatus["read"] ==1)
           <div class="notification" style="position: relative;background-color: #ffffff; margin:0px;>
        @endif
        @if($notifstatus["unread"] ==0)
         <div class="notification" style="position: relative;background-color: #3232320a; margin:0px;>
">
        @endif
     @endif
       <!--<div id="setting" style="position:absolute;right: 0;" class="name"><i class="fa-regular fa-circle-ellipsis"></i></div>-->
       <img src="{{asset("uploads/".\App\Models\User::get_user_photo($item["User"]))}}" alt="" / style="width:50px;height:50px">  
       <div class="text" style="width: 100%;">  
        <p style="margin:0px;font-size:1em;" class="pt-2"><span class="name">{{ \App\Models\User::get_user_name($item["User"]) }}</span>
        {{$item["Action"]}}
        
        @if($item["Meta_key"] =="Request")  <span class="name">{{ \App\Models\SubBook::get_book_name($item["Target"]) }}</span>@endif
        @if($item["Meta_key"] =="Approved")<span class="name">{{ \App\Models\User::get_user_name($item["Target"]) }} </span>@endif
        @if($item["Meta_key"] =="NewBook") <span class="name">{{ \App\Models\Book::get_book_name($item["Target"]) }} </span>@endif
        @if($item["Meta_key"] =="Promotion")<span class="name">{{$item["Target"]}}</span>@endif
        @if($item["Meta_key"] =="Notice")<span class="name">{{$item["Target"]}}</span>@endif
        @if($item["Meta_key"] =="Carousel")<span class="name">{{$item["Target"]}}</span>@endif
        @if($item["Meta_key"] =="Enquiries")<span class="name">{{$item["Target"]}}</span>@endif

        
         @if($item["Meta_key"] =="Approved"){{ \App\Models\Book::get_book_name_byID($item["Modifier"]) }} </span>
         @else
         {{$item["Modifier"]}}
         @endif</p>
         <p class="time">{{$item["created_at"]->diffForHumans()}}</p>  
       </div>  
      </div>
      </a>
      </div>
     @endforeach

											
											

                                                
                                              
											</div><!--notbar end-->
											
									</div>
                                </div>
                                    </div>


                    </div>
                    </div>
                    </div>
                    </div>

</div>
</section>
<br>
