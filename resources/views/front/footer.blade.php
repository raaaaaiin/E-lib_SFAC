@php
    /* @var \App\Facades\Util $util */
    /* @var \App\Facades\Common $common */
@endphp
<link rel="stylesheet" href="{{asset('css/footer.css')}}">

<footer id="footer" class="footer-1">
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

                        @livewire("front-subscribe")

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
