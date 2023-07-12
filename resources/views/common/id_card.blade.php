<style>
p,strong {
color:white;
}

.serviceBox{
    color: #555;
    font-family: 'Poppins', sans-serif;
    text-align: center;
    padding: 0 10px 20px;
    margin: 0 -5px;
    position: relative;
    z-index: 1;
}
.serviceBox:before,
.serviceBox:after{
    content: '';
    background-color: #fff;
    border-radius: 20px;
    box-shadow: 0 0 20px -5px rgba(0,0,0,0.4);
    position: absolute;
    left: 15px;
    top: 0;
    right: 15px;
    bottom: 10px;
    z-index: -1;
}
.serviceBox:after{
    background-color: transparent;
    border: 2px solid #F84745;
    border-top: none;
    border-radius: 0 0 20px 20px;
    box-shadow: none;
    left: 0;
    top: 30%;
    right: 0;
    bottom: 0;
}
.serviceBox .service-icon{
    color: #fff;
    background: #F84745;
    font-size: 30px;
    padding: 5px 5px;
    margin: 0 0 11px;
    border-radius: 0 0 20px 20px;
    display: inline-block;
} 
.serviceBox .title{
    color: #F84745;
    font-size: 20px;
    font-weight: 600;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin: 0 0 15px;
}
.serviceBox .description{
    font-size: 14px;
    line-height: 23px;
    margin: 0 10px;
}
.serviceBox.orange .service-icon{ background: #FD6D49; }
.serviceBox.orange:after{ border-color: #FD6D49; }
.serviceBox.orange .title{ color: #FD6D49; }
.serviceBox.blue .service-icon{ background: #1BA9F4; }
.serviceBox.blue:after{ border-color: #1BA9F4; }
.serviceBox.blue .title{ color: #1BA9F4; }
.serviceBox.purple .service-icon{ background:rgb(113 2 2); }
.serviceBox.purple:after{ border-color: rgb(113 2 2); }
.serviceBox.purple .title{ color: rgb(113 2 2); }
@media only screen and (max-width: 990px){
    .serviceBox{ margin: 0 0 40px; }
}
</style>
<div  >
    <div class="id-card-holder m-0" id="imageDIV">
        <div class="id-card" style="background-color:rgb(113 2 2); color:white;">
            <!--
            <div class="header">
                <img
                    src="{{asset('uploads/'.$util::fileChecker(public_path("uploads"),
                                $common::getSiteSettings("org_logo"),config('app.DEFAULT_LOGO')))}}">
            </div>-->
            <br>
            <div class="col-md-12 col-sm-6">
                    <div class="serviceBox purple">
                        <div class="service-icon">
                           
                <img width="125"
                    src="{{asset('uploads/'.$util::fileChecker(public_path("uploads"),
                                $common::getSiteSettings("org_logo"),config('app.DEFAULT_LOGO')))}}">
            
                        </div>
                        @php
                        
                    $assigned_on=$common::getStandardDivisionAssignedToLoggedInUser();
                
$encrypt = bin2hex($id);
                        @endphp
                         <h1 class="userid">{{QrCode::size(175)->generate($encrypt)}}</h1>
                    </div>
                </div>
            
            <strong><h2 style="background-color:rgb(113 2 2); color:white;">{{$user ? \Illuminate\Support\Str::title($user) : "N/A"}}</h2></strong>
           
            
            <hr>
           
            <h3 class="url_holder" style="background-color:rgb(113 2 2); color:white;">
            @if($assigned_on)
                    @foreach($assigned_on as $items)
                        @foreach($items as $course=>$year)
                            
                                {{ucwords($common::getCourseName($course))}}
                           
                        @endforeach
                    @endforeach
                @endif</h3>
            {!! $util::goodFormatAddress($common::getSiteSettings("org_address")) !!}
            <p style="background-color:rgb(113 2 2); color:white;" >Ph: {{$common::getSiteSettings("org_phone")}} |
                E-mail: {{$common::getSiteSettings("org_email")}}</p>
            
        </div>
    </div>
</div>
<br>
<h5 style="color:red">*Take a screenshot</h5>
<br>
<h5 style="color:red">*This will serve as your library gate pass</h5>
<script src="{{asset('front/js/html2canvas.min.js')}}"></script>
<script>
 
var container = document.getElementById('imageDIV'); // full page 
			html2canvas(container).then(function(canvas) {
                var link = document.createElement("a");
                document.body.appendChild(link);
                link.download = "QRCode.png";
                link.href = canvas.toDataURL("image/png");
                link.target = '_blank';
                link.click();
                if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
}else{
  history.back()
}
                
            });
</script>
