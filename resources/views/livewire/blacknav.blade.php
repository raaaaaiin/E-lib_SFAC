
@php
    /* @var \App\Facades\Util $util */
    /* @var \App\Facades\Common $common */
 /* @var \App\Models\UserNotif $notif */


@endphp
<!-- Navbar -->

<style>
@media only screen and (max-width: 600px) {

    .mobile-m-0{margin:0;
    max-width:100vw!important;
    height:100vh!important}
    .minimimi{
  height: 800px;}
  .mininini{
   height:100vh;}

  }

</style>

<script src="{{asset('js/instascan.min.js')}}"></script>



<div class="modal fade" id="myyModal" role="dialog " >


    <div class="modal-dialog mobile-m-0">
      <!-- Modal content-->
      <div class="card modal-content minimimi" >
        <div class="card-header p-2 modal-header" style="background-color:rgb(113 2 2)">
          <ul class="nav nav-pills w-100 justify-content-between align-self-center ">
          <li class="nav-item d-flex align-self-center">
              <a id="closemodal" class="nav-link" href="#" data-toggle="myyModal" style="font-size:18px;color:#f5f5f5" ><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            </li>

            <li class="nav-item">
                <a href="{{route('dashboard')}}" style="background-color:rgb(113 2 2);padding-left:0px" class="brand-link" >
        <img style="margin-left:-3px;max-height: 45px;margin-top: -7px;" src="{{asset('uploads/satellite.png')}}"
             alt="{{config("app.APP_NAME")}}"
             class="brand-image"
        >

    </a>
            </li>


          </ul>
        </div>
        <!-- /.card-header -->
        <div class="card-body modal-body mininini">
          <div class="tab-content">
           <div class="container">
	<div class="row justify-content-center">

	<div class="col-md-12">

	<div class="card-header bg-transparent mb-0"><h5 class="text-center"><span>Scan QR Code</span></h5>

	<div class="card-body">
		<video id="preview" width="100%" height="100%"></video>

	<div class="form-group">


	</div>
	</div>
	</div>
	</div>
	</div>
</div>
          <!-- /.tab-content -->
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->

<!-- /.row -->

</div>


</div>




<script>




</script>



<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
    @php

     $notif = new \App\Models\UserNotif;
    @endphp
    @can("mng-notif-admin")
    @php
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
     function read($params) {
           $notifread = new \App\Models\UserNotifread;
           $notifread::updateOrCreate(["user_id" => \Auth::Id(),"meta_value" => "read","meta_key" => $params]);
     }
     if (isset($_GET['id'])) {
        read($_GET['id']);
      }

     $notifread = new \App\Models\UserNotifread;

     $unread = 0;
     $final = array_slice($data,0,8);
     $totalunread=0;





     @endphp

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a id="openmodal" class="nav-link" data-toggle="dropdown" href="#" style="padding-left:0px;padding-right:0px">
                <span class="fa-stack">
  <i class="fa fa-qrcode fa-stack-1x" aria-hidden="true"></i>
</span>

            </a>
            </li>

            <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" style="padding-left:0px;padding-right:0px">
                <span class="fa-stack" @php echo $notif->notifcount==0 ? "" : 'data-count="'.$notif->notifcount.'"';@endphp>
  <i class="fa-solid fa-bell fa-stack-1x"></i>
</span>

            </a>
            <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right">

                <div class="content">
                <div class="header">
      <p>Notifications</p>

     </div>
     @foreach ($final as $item)

     @php
     $notifstatus = $notifread->verifynotif($item["id"]);

     @endphp

     @if($item["Meta_key"] =="Request")  <a style="padding: 0!important" href="{{!isset($item["role"]) ? url('/cycle-books?id='.$item["id"]):url('/timeline?id='.$item["id"])}}"></span>@endif
        @if($item["Meta_key"] =="Approved")<a style="padding: 0!important" href="{{!isset($item["role"]) ?url('/issued-books?id='.$item["id"]):url('/timeline?id='.$item["id"])}}">@endif
        @if($item["Meta_key"] =="NewBook") <a style="padding: 0!important" href="{{route("details", ['page_slug' => $common::utf8Slug(\App\Models\Book::get_book_name($item["Target"]))])}}
                                 ">@endif
        @if($item["Meta_key"] =="Promotion")<a style="padding: 0!important" href="{{!isset($item["role"]) ?url('/role-perm-mng?id='.$item["id"]):url('/timeline?id='.$item["id"])}}">@endif
        @if($item["Meta_key"] =="Notice")<a style="padding: 0!important" href="{{url('/notice-mng?id='.$item["id"])}}">@endif
        @if($item["Meta_key"] =="Carousel")<a style="padding: 0!important" href="{{url('/slider-mng?id='.$item["id"])}}">@endif
        @if($item["Meta_key"] =="Enquiries")<a style="padding: 0!important" href="{{url('/enquiry-mng?id='.$item["id"])}}">@endif
        @if($item["Meta_key"] =="ReturnAlert")<a style="padding: 0!important" href="{{url('/enquiry-mng?id='.$item["id"])}}">@endif




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
       <div class="text">
        <p><span class="name">{{!isset($item["role"]) ? \App\Models\User::get_user_name($item["User"]):$item["Useralt"] }}</span>
        {{$item["Action"]}}

        @if($item["Meta_key"] =="Request")  <span class="name">{{ \App\Models\SubBook::get_book_name($item["Target"]) }}</span>@endif
        @if($item["Meta_key"] =="Approved")<span class="name">{{ \App\Models\User::get_user_name($item["Target"]) }} </span>@endif
        @if($item["Meta_key"] =="NewBook") <span class="name">{{ \App\Models\Book::get_book_name($item["Target"]) }} </span>@endif
        @if($item["Meta_key"] =="Promotion")<span class="name">{{$item["Target"]}}</span>@endif
        @if($item["Meta_key"] =="Notice")<span class="name">{{$item["Target"]}}</span>@endif
        @if($item["Meta_key"] =="Carousel")<span class="name">{{$item["Target"]}}</span>@endif
        @if($item["Meta_key"] =="Enquiries")<span class="name">{{$item["Target"]}}</span>@endif
        @if($item["Meta_key"] =="ReturnAlert")  <span class="name">{{ \App\Models\SubBook::get_book_name($item["Target"]) }}</span>@endif


         @if($item["Meta_key"] =="Approved"){{ \App\Models\Book::get_book_name_byID($item["Modifier"]) }} </span>
         @else
         {{$item["Modifier"]}}
         @endif</p>
         <p class="time">{{$item["created_at"]->diffForHumans()}}</p>
       </div>
      </div>
      </a>
     @endforeach

      <div class="header" style="padding: 0!important"></div>
       <div class="header justify-content-center">
      <a href="{{url("/notif")}}" style="padding: 0px">See all Notification</a>
     </div>
     </div>








            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" style="padding-left:0px">
                <span class="fa-stack">
  <i class="fas fa-chevron-circle-down fa-stack-1x"></i>
</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                <div class="dropdown-divider"></div>
                <a href="{{config('app.APP_URL')}}" target="_blank" class="dropdown-item">
                    <i class="fas fa-sign-out-alt mr-2"></i> {{__("common.visit_front_page")}}
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{route("profile", ['v_id' => \App\Models\User::get_current_id()])}}" class="dropdown-item">
                    <i class="far fa-id-card mr-2"></i> {{__("common.profile")}}
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{route("custom.logout")}}" class="dropdown-item">
                    <i class="fas fa-sign-out-alt mr-2"></i> {{__("logout")}}
                </a>
                <div class="dropdown-divider"></div>
            </div>
        </li>
    </ul>
</nav>
<style>
.fa-stack[data-count]:after{
  position:absolute;
  right:-2%;
  top:-7%;
  content: attr(data-count);
  font-size:60%;
  padding:.6em;
  border-radius:999px;
  line-height:.75em;
  color: white;
  background:rgba(255,0,0,.85);
  text-align:center;
  min-width:2em;
  font-weight:bold;
}
.box{
   width: 350px;
   margin-top: 2em;
   position: absolute;
   overflow: hidden;
   border: 1px solid rgba(0, 0, 0, 0.137);
   transition: all .4s;
   clip-path: polygon(0 0, 100% 0, 100% 0, 0 0);
 }
 .header{
   width: 100%;
   display: flex;
   justify-content: space-between;
   padding: 0.6em 1em;
   border-bottom: 1px solid rgba(0, 0, 0, 0.082);
 }
 .header a{
   text-decoration: none;
 }
 .content{
   width: 100%;
 }
 .notification{
   width: 100%;
   padding: 0.6em 1em;
   display: flex;
   align-items: center;
 }
 .notification img{
   width: 50px;
   height: 50px;
   border-radius: 50px;
   margin-right: 0.5em;
 }
 .notification .text p{
   font-size: 0.8em;
 }
 .notification .text p span{
   font-weight: 700;
 }
 .notification .text .time{
   font-size: 0.7em;
   color: rgba(0, 0, 0, 0.61);
 }
</style>
<!-- /.navbar -->
<script src="{{asset('front/js/vendor/jquery-1.12.4.min.js')}}"></script>
<script>
let vh = window.innerHeight * 0.01;
document.documentElement.style.setProperty('--vh', `${vh}px`);

 // always check for errors at the end.


$("#closemodal").click(function () {
   $('#myyModal').modal('toggle');
});
function tryemit(){
   window.livewire.emit('say-hello', { name : 'John' });
    alert("Emitted");
}
$("#openmodal").click(function(){
$("#myyModal").modal();
var constraints = { video: { width: 800, height: 800 } };

navigator.mediaDevices.getUserMedia(constraints)
.then(function(mediaStream) {
  var video = document.querySelector('video');
  video.srcObject = mediaStream;
  video.onloadedmetadata = function(e) {
    video.play();
  };
})
.catch(function(err) { console.log(err.name + ": " + err.message); });
let scanner = new Instascan.Scanner({video: document.getElementById('preview')});
	scanner.addListener('scan', function(content){

         alert("ehh");
	});

	Instascan.Camera.getCameras().then(function (cameras) {
            //If a camera is detected
            if (cameras.length > 0) {
                //If the user has a rear/back camera
                if (cameras[1]) {
                    //use that by default
                    scanner.start(cameras[1]);

                } else {
                    //else use front camera
                    scanner.start(cameras[0]);

                }
            } else {
                //if no cameras are detected give error

            }
        }).catch(function (e) {

        });
});
</script>
