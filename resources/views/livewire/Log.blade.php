<div>



  <div class="content-wrapper w-100 m-0">
    <div class="w-100 m-0">
      <div class="main-body">
        <!-- Breadcrumb -->
        <!-- /Breadcrumb -->
        <div class="row gutters-sm">

        <div class="col-md-3 mb-3">
            <div class="dashcard dashcardshad">
              <div class="card-header blue">
                <span class="card-header-title">Scan QR Code</span>
              </div>
              
              <div wire:ignore="" class="card-body yellow">

              
	<div class="card-body">
		<video id="previewLog" width="100%" height="100%"></video>
        <div>
        <br>
              <h3>Rules in Library</h3>
              <ul class="list-group list-group-flush">
              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap"><span class="text-secondary" >Students must present a valid SHAN ID when borrowing library materials.</span></li>
              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap"><span class="text-secondary" >Students are allowed to borrow a maximum of two (2) books at a time.</span></li>
              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap"><span class="text-secondary" >Each loan item may be renewed for up to three (3) consecutive times, provided that the book is not already reserved, or overdue.
</span></li>
              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap"><span class="text-secondary" >All loan items, which cannot be renewed, should be returned to the library on or before its due date.</span></li>
             
              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap"><span class="text-secondary" >Students are responsible for materials checked out until they return all borrowed books to the library.</span></li>
              </ul>
              </div>
        </div>
              
            </div>



          </div>


        </div>



          <div class="col-md-6">
            <div class="dashcard dashcardshad">
              <div class="card-header blue">
                <span class="card-header-title">User Information *Auto Hides after 5 Seconds</span>
              </div>
              <div class="card-body yellow">
                <div class="dashcard mb-3">
                  <div class="dashcard-body pb-0">
                    <div class="row">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Student Number</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                        {{$this->user_id}}
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Full Name</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                        {{$this->name}}
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Gender</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                        {{$this->gender}}
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Role</h6>
                      </div>
                      <div class="col-sm-9 text-secondary"> @foreach($this->roles as $role){{Str::title($role->name)}} @endforeach </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-3">
                        <h6 class="mb-0">Address</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                        {{$this->address}}
                      </div>
                    </div>
                    <hr>
                    <div class="row"></div>
                  </div>
                </div>
                <div class="row gutters-sm">
                  <div class="col-sm-6 mb-3">
                    <div class="dashcard h-100">
                      <div class="dashcard-body pt-0">
                        <h6 class="d-flex align-items-center mb-3">
                          <i class="material-icons text-info mr-2">Previously</i>Remarks
                        </h6>
                        <div style="overflow-y: scroll;
    height: 268px;"> @foreach($this->currentlyRemarks as $key => $data) <div class="pf-gallery p-0 row mb-2" style="border-bottom:1px;">
                            <div class=" post_topbar p-0">
                              <div class="row usy-dt w-100" style="align-items: center;">
                                <div class="col-md-9 usy-name m-0">
                                  <h5 style="
    margin-left:10px!important;margin: 0;
    padding: 0;
    border: 0;
    font-size: 14px!important;
    font: inherit;
    vertical-align: baseline;
    color: #000;
    text-transform: capitalize;
    font-weight: 600;
">{{$data["Remarks"] ? $data["Remarks"] : "A book was successfully returned."}}</h5> @if(empty($data["Accession"])) @else <h5 style="
    margin-left:10px!important;margin: 0;
    padding: 0;
    border: 0;
    font-size: 14px!important;
    font: inherit;
    vertical-align: baseline;
    color: #000;
    text-transform: capitalize;
">Refference:{{$data["Accession"]}}</h5> @endif <h5 style="
    margin-left:10px!important;margin: 0;
    padding: 0;
    border: 0;
    font-size: 14px!important;
    font: inherit;
    vertical-align: baseline;
    color: #000;
    text-transform: capitalize;
">Date posted: {{$data["Returned"]}}</h5>
                                </div>
                              </div>
                            </div>
                          </div> @endforeach </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 mb-3">
                    <div class="dashcard h-100">
                      <div class="dashcard-body pt-0" style="overflow-y: scroll;">
                        <h6 class="d-flex align-items-center mb-3">
                          <i class="material-icons text-info mr-2">Previously</i>Borrowed
                        </h6>
                        <div style="overflow-y: scroll;
    height: 268px;"> @foreach($this->currentlyBorrowed as $key => $data) <div class="pf-gallery p-0 row" style="border-bottom:1px;">
                            <div class=" post_topbar p-0">
                              <div class="row usy-dt w-100" style="align-items: center;">
                                <img class="col-md-2" style="height:100%;width:100%;cursor: pointer;border-radius: 0px!important" data-toggle="tooltip" data-placement="top" class="img-thumbnail" wire:click="activeUser" onclick="location='{{route("details", ['page_slug' => $common::utf8Slug($data["title"])])}}'" src="{{asset(str_replace (array('[', ']',chr(34)), '' , $data["book_img"]))}}" />
                                <div class="col-md-9 usy-name m-0">
                                  <a href="{{route("details", ['page_slug' => $common::utf8Slug($data["title"])])}}" style="color:#000;padding:0;">
                                    <h5 style="
    margin-left:10px!important;margin: 0;
    padding: 0;
    border: 0;
    font-size: 14px!important;
    font: inherit;
    vertical-align: baseline;
    color: #000;
    text-transform: capitalize;
    font-weight: 600;
">{{$data["title"]}}</h5>
                                    <h5 style="
    margin-left:10px!important;margin: 0;
    padding: 0;
    border: 0;
    font-size: 14px!important;
    font: inherit;
    vertical-align: baseline;
    color: #000;
    text-transform: capitalize;
">Accession:{{$data["Accession"]}}</h5>
                                    <h5 style="
    margin-left:10px!important;margin: 0;
    padding: 0;
    border: 0;
    font-size: 14px!important;
    font: inherit;
    vertical-align: baseline;
    color: #000;
    text-transform: capitalize;
">Borrowed On: {{$data["Borrowed"]}}</h5>
                                    <h5 style="
    margin-left:10px!important;margin: 0;
    padding: 0;
    border: 0;
    font-size: 14px!important;
    font: inherit;
    vertical-align: baseline;
    color: #000;
    text-transform: capitalize;
">Returned On: {{$data["Returned"]}}</h5>
                                  </a>
                                  <h5 style="
    margin-left:10px!important;margin: 0;
    padding: 0;
    border: 0;
    font-size: 14px!important;
    font: inherit;
    vertical-align: baseline;
    color: #000;
    text-transform: capitalize;
">Status: @if(empty($data["Returned"])) <span class="badge badge-warning float-right" style=" font-size: 14px!important;">Pending</span> @else <span class="badge badge-success float-right" style=" font-size: 14px!important;">Returned</span> @endif </h5>
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div> @endforeach </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
           <div class="col-md-3 mb-3">
            <div class="dashcard dashcardshad">
              <div class="card-header blue">
                <span class="card-header-title">User Contact</span>
              </div>
              <div class="card-body yellow">
                <div class="dashcard yellow">
                  <div class="dashcard-body">
                    <div class="d-flex flex-column align-items-center text-center">
                      <img src="{{$photo_link}}" alt="Admin" class="rounded-circle" width="150">
                      <div class="mt-3">
                        <h4>{{$name}}</h4>
                        <p class="text-secondary mb-1">Check all attachment to</p>
                        <p class="text-muted font-size-sm">Accept {{$name}}'s Request</p>
                      </div>
                    </div>
                  </div>
                  <div class="dashcard mt-3">
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                          </svg> Email
                        </h6>
                        <span class="text-secondary">{{$this->email}}</span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-phone" viewBox="0 0 16 16">
                            <path d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z" />
                            <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                          </svg> Phone
                        </h6>
                        <span class="text-secondary">{{$this->phone}}</span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-star" viewBox="0 0 16 16">
                            <path d="M7.84 4.1a.178.178 0 0 1 .32 0l.634 1.285a.178.178 0 0 0 .134.098l1.42.206c.145.021.204.2.098.303L9.42 6.993a.178.178 0 0 0-.051.158l.242 1.414a.178.178 0 0 1-.258.187l-1.27-.668a.178.178 0 0 0-.165 0l-1.27.668a.178.178 0 0 1-.257-.187l.242-1.414a.178.178 0 0 0-.05-.158l-1.03-1.001a.178.178 0 0 1 .098-.303l1.42-.206a.178.178 0 0 0 .134-.098L7.84 4.1z" />
                            <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z" />
                          </svg> Course
                        </h6>
                        <span class="text-secondary"> @if($this->section) @foreach($this->section as $items) @foreach($items as $course=>$year) {{Str::title($common::getCourseName($course))}} @endforeach @endforeach @endif</span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-mortarboard" viewBox="0 0 16 16">
                            <path d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917l-7.5-3.5ZM8 8.46 1.758 5.965 8 3.052l6.242 2.913L8 8.46Z" />
                            <path d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466 4.176 9.032Zm-.068 1.873.22-.748 3.496 1.311a.5.5 0 0 0 .352 0l3.496-1.311.22.748L8 12.46l-3.892-1.556Z" />
                          </svg> Section
                        </h6>
                        <span class="text-secondary">@if($this->section)
@foreach($this->section as $items) @foreach($items as $course=>$year) {{Str::title($common::getCourseName($course))}} {{$common::getCourseYearName($year)}} @endforeach @endforeach @endif</span>
                      </li>
                     
                    </ul>
                    <br>
                    <div class="ml-auto float-right">
                     
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
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
          background-color: #fff;
          background: linear-gradient(#e6c01d, #e6c01d);
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
          background: linear-gradient(#92bCa6, #A2CCB6);
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
    </div>
  </div>


  <script>

setInterval(function() {
    window.livewire.emit('saveTime');
    
}, 60 * 1000);

 // always check for errors at the end.
var myStr1 = "Hello";

$("#closemodal").click(function () {
   $('#myyModal').modal('toggle');
});

var myTimer = window.setInterval(ticker, 10000);

        var ticker = function() {
   window.livewire.emit('mountclear');	
};

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
let scanner = new Instascan.Scanner({video: document.getElementById('previewLog')});
	scanner.addListener('scan', function(content){
         
        if (myStr1 !== content){
        
        window.livewire.emit('logbackdata_manager', content);
        alertTimeout("System Message<br>The QR code was successfully scanned,",2000);
      
      start();
         myStr1 = content;
         
        }else{

        }
	    
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
        function start(){
              window.clearInterval(myTimer);
        myTimer = window.setInterval(ticker, 7000);
        }

        function alertTimeout(mymsg,mymsecs)
{
 var myelement = document.createElement("div");
myelement.setAttribute("style","background-color: grey;color:black; width: 450px;height: 200px;position: absolute;top:0;bottom:0;left:0;right:0;margin:auto;border: 1px solid black;font-family:arial;font-size:25px;font-weight:bold;display: flex; align-items: center; justify-content: center; text-align: center;");
 myelement.innerHTML = mymsg;
 setTimeout(function(){
  myelement.parentNode.removeChild(myelement);
 },mymsecs);
 document.body.appendChild(myelement);
}
</script>


</div>
