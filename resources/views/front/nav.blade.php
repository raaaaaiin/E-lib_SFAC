<section class="navbar-area sticky" style="width:100vw">
@php $loading_target ="activeUser";@endphp
    <div class="container-fluid" >
        <div class="row">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg">

                    <a class="navbar-brand" href="{{config("app.APP_URL")}}" style="padding:0px">
                        @if(!empty($common::getSiteSettings('org_logo')))
                            <img class="logo_img"
                                 src="{{asset("uploads/".$common::getSiteSettings('org_logo'))}}"
                                 alt="{{$common::getSiteSettings("org_name")}}"
                                 style="width:50px;height:50px">
                        @else
                            <img class="logo_img" href="{{config("app.APP_URL")}}"
                                 src="{{asset("uploads/".config("app.DEFAULT_LOGO"))}}"
                                 alt="{{$common::getSiteSettings("org_name",config("app.APP_NAME"))}}"
                                 style="width:50px;height:50px">
                        @endif
                    </a>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTwo"
                            aria-controls="navbarTwo" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="toggler-icon"></span>
                        <span class="toggler-icon"></span>
                        <span class="toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse sub-menu-bar" id="navbarTwo">
                    @livewire('search-users')
                    @include("back.common.spinner")
                        <ul class="navbar-nav" style="margin-left: auto;">
                            <li class="nav-item active"><a class="page-scroll"
                                                           href="@if(request()->is("/")) #home @else {{config('app.APP_URL')}} @endif">{{__("common.home")}}</a>
                            </li>
                            
                            @if(Auth::check())
                                <li class="nav-item"><a class=""
                                                        href="{{route('newsfeed.index')}}">{{__("common.newsfeed")}}</a>
                                </li>
                            @else
                            
                               
                           
                                <li class="nav-item"><a class="" wire:click="activeUser" href="{{route('login')}}">{{__("common.login")}}</a>
                                </li>
                            @endif
                            <li class="nav-item">
                            </li>
                        </ul>
                    </div>

                </nav> <!-- navbar -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</section>
