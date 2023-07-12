<div>

@php
use App\Models\UserMeta as meta;
$validator = false;
$borrowvalidator = false;
$lockvalidator = false;
@endphp
@if($this->isOwner == 1)
@php
                                        $validator = true;
                                         $assigned_on = null;
                                            $user_meta = meta::where("user_id",$this->user_id)->first();
                                            $getlookup = $user_meta->getprivacysearch($this->user_id);
                                            $getprivacyborrow = $user_meta->getprivacyborrow($this->user_id);
                                            $getprivacyprofile = $user_meta->getprivacyprofile($this->user_id);
                                            if($user_meta){
                                            $assigned_on = json_decode($user_meta->get_assign());
                                            }
                                        @endphp
@else

@php


                                            $assigned_on = null;
                                            $user_meta =App\Models\UserMeta::where("user_id",$this->user_id)->first();
                                              $getprivacyborrow = $user_meta->getprivacyborrow($this->user_id);
                                              $getprivacyprofile = $user_meta->getprivacyprofile($this->user_id);
                                            $getlookup = $user_meta->getprivacysearch($this->user_id);
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
                                                @endforeach
                                            @endforeach
                                        @endif







  @if($getlookup == 1)
                                        @php
                                        $validator = true;
                                        @endphp
  @else
                                        @php
                                           $validator = false;
                                            $poster = null;
                                            $user_metaa = meta::where("user_id",Auth::Id())->first();
                                            if($user_meta){
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


                                        @if($getlookup == 2)
                                        @php
                                        if($pcurrentCourse == $currentCourse){
                                            $validator = true;
                                        }
                                        @endphp


                                        @elseif($getlookup == 3)
                                        @php
                                        if(substr($pcurrentYear, 0, 1) == substr($currentYear, 0, 1)){
                                            $validator = true;
                                        }
                                        @endphp


                                        @elseif($getlookup == 4)
                                        @php
                                        if($pcurrentSection == $currentSection){

                                            $validator = true;
                                        }
                                        @endphp
                                        @elseif($getlookup == 5)
                                        @php
                                        if(Auth::id() == $this->user_id){
                                            $validator = true;
                                        }else{

        abort(404, __("The owner doesn't allow visitors on his/her profile."));
                                        }
                                        @endphp
                                        @endif


@endif

 @if($validator == true)
   @if($this->isOwner == 1)
   <form class="form-horizontal " wire:submit.prevent="saveProfile">
<div class="modal fade" id="myModal" role="dialog "  wire:ignore.self>


    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="card modal-content">
        <div class="card-header p-2 modal-header">
          <ul class="nav nav-pills w-100 ">

            <li class="nav-item m-1">
              <a class="nav-link {{$tab==1?'active':''}}" wire:click="$set('tab', 1)" href="#" data-toggle="tab">{{__('common.edit_profile')}}</a>

            </li>
            <li class="nav-item m-1">
              <a class="nav-link {{$tab==1?'active':''}}" id="closeprivacy" href="#" data-toggle="myModal">Edit Privacy</a>

            </li>


            <li class="nav-item ml-auto">
              <a id="close" class="nav-link" href="#" data-toggle="myModal" >CLOSE</a>
            </li>


          </ul>
        </div>
        <!-- /.card-header -->
        <div class="card-body modal-body">
          <div class="tab-content">
            <div class="tab-pane {{$tab==1?'active':''}}"> @if(session()->has("form_profile") && session()->get("form_profile")) <div class="row">
                <div class="col-12"> @include("common.messages") </div>
              </div> @endif

              @csrf
              <div class="mb-2 d-flex center justify-content-center">


             <div class="cover-sec ">
                    <img class="hatdog h-100 w-100" src="{{$cover_link}}" alt="">
                    <a id="coverclick" class="d-flex" href="#" title="" style="height:100%;width:100%;top:0px!important;margin-right:0px!important;border:0px!important;background-color:#000000b5!important;">
                      <div class="d-flex" style="height:25%;width:25%;opacity: 0.75;-webkit-box-align: stretch;align-items: stretch;-webkit-box-pack: center;justify-content: center;height: 100%;-webkit-box-direction: normal;-webkit-box-orient: vertical;flex-direction: column;width: 100%;position: relative;top: 0px;-ms-flex-align: stretch;-ms-flex-direction: column;-ms-flex-negative: 0;-ms-flex-preferred-size: auto;-webkit-align-items: stretch;-webkit-flex-basis: auto;-webkit-flex-direction: column;-webkit-flex-shrink: 0;border: 0 solid black;box-sizing: border-box;display: flex;flex-basis: auto;flex-shrink: 0;margin-bottom: 0px;margin-left: 0px;margin-right: 0px;margin-top: 0px;min-height: 0px;min-width: 0px;padding-bottom: 0px;padding-left: 0px;padding-right: 0px;padding-top: 0px;z-index: 0;">

                    <div aria-label="Add banner photo" role="button" tabindex="0"  style="left:48%;height:25px;width:25px;backdrop-filter: blur(4px);background-color: rgb(255 235 59 / 30%);;-ms-flex-align: stretch;-ms-flex-direction: column;-ms-flex-negative: 0;-ms-flex-preferred-size: auto;-webkit-align-items: stretch;-webkit-box-align: stretch;-webkit-box-direction: normal;-webkit-box-orient: vertical;-webkit-flex-basis: auto;-webkit-flex-direction: column;-webkit-flex-shrink: 0;align-items: stretch;border: 0 solid black;box-sizing: border-box;display: flex;flex-basis: auto;flex-direction: column;flex-shrink: 0;margin-bottom: 0px;margin-left: 0px;margin-right: 0px;margin-top: 0px;min-height: 44px;min-width: 44px;padding-bottom: 0px;padding-left: 0px;padding-right: 0px;padding-top: 0px;position: relative;z-index: 0;outline-style: none;transition-property: background-color, box-shadow;transition-duration: 0.2s;-moz-user-select: none;-ms-user-select: none;-webkit-user-select: none;user-select: none;margin: -12px;border-color: rgba(0, 0, 0, 0);border-width: 1px;border-style: solid;border-radius: 9999px;cursor: pointer;">

                    <div dir="auto" style="-webkit-box-align: center;align-items: center;-webkit-box-pack: center;justify-content: center;-webkit-box-direction: normal;-webkit-box-orient: horizontal;flex-direction: row;"><svg viewbox="-6 -5 36 36" aria-hidden="true" style="-moz-user-select: none;-ms-user-select: none;-webkit-user-select: none;user-select: none;">
                        <g>
                        <path fill="#ffffff" d="M19.708 22H4.292C3.028 22 2 20.972 2 19.708V7.375C2 6.11 3.028 5.083 4.292 5.083h2.146C7.633 3.17 9.722 2 12 2c2.277 0 4.367 1.17 5.562 3.083h2.146C20.972 5.083 22 6.11 22 7.375v12.333C22 20.972 20.972 22 19.708 22zM4.292 6.583c-.437 0-.792.355-.792.792v12.333c0 .437.355.792.792.792h15.416c.437 0 .792-.355.792-.792V7.375c0-.437-.355-.792-.792-.792h-2.45c-.317.05-.632-.095-.782-.382-.88-1.665-2.594-2.7-4.476-2.7-1.883 0-3.598 1.035-4.476 2.702-.16.302-.502.46-.833.38H4.293z"></path>

                        <path fill="#ffffff" d="M12 8.167c-2.68 0-4.86 2.18-4.86 4.86s2.18 4.86 4.86 4.86 4.86-2.18 4.86-4.86-2.18-4.86-4.86-4.86zm2 5.583h-1.25V15c0 .414-.336.75-.75.75s-.75-.336-.75-.75v-1.25H10c-.414 0-.75-.336-.75-.75s.336-.75.75-.75h1.25V11c0-.414.336-.75.75-.75s.75.336.75.75v1.25H14c.414 0 .75.336.75.75s-.336.75-.75.75z"></path></g></svg><span class="css-901oao css-16my406 css-bfa6kz r-poiln3 r-a023e6 r-rjixqe r-bcqeeo r-qvutc0"></span>

                        </div>

                        </div>

                        </div>
                    </a>
                  </div>






               </div>
              <div class="mb-2 d-flex center justify-content-center" >





               <div class="user-pro-img" style="width:135px;height:135px;margin-bottom: 0!important;" >

               <img class="h-100 w-100" id='pht' src="{{$photo_link}}" class="cheesedog">
               <a id="photoclick" class="d-flex h-100 w-100" href="#" title="" style="height:100%;width:100%;top:0px!important;margin-right:0px!important;border:0px!important;background-color:#02000b4f!important;">
                      <div class="d-flex" style="height:25%;width:25%;opacity: 0.75;-webkit-box-align: stretch;align-items: stretch;-webkit-box-pack: center;justify-content: center;height: 100%;-webkit-box-direction: normal;-webkit-box-orient: vertical;flex-direction: column;width: 100%;position: relative;top: 0px;-ms-flex-align: stretch;-ms-flex-direction: column;-ms-flex-negative: 0;-ms-flex-preferred-size: auto;-webkit-align-items: stretch;-webkit-flex-basis: auto;-webkit-flex-direction: column;-webkit-flex-shrink: 0;border: 0 solid black;box-sizing: border-box;display: flex;flex-basis: auto;flex-shrink: 0;margin-bottom: 0px;margin-left: 0px;margin-right: 0px;margin-top: 0px;min-height: 0px;min-width: 0px;padding-bottom: 0px;padding-left: 0px;padding-right: 0px;padding-top: 0px;z-index: 0;">

                    <div aria-label="Add banner photo" role="button" tabindex="0"  style="left:43%;height:15px;width:15px;backdrop-filter: blur(4px);background-color: rgb(255 235 59 / 30%);;-ms-flex-align: stretch;-ms-flex-direction: column;-ms-flex-negative: 0;-ms-flex-preferred-size: auto;-webkit-align-items: stretch;-webkit-box-align: stretch;-webkit-box-direction: normal;-webkit-box-orient: vertical;-webkit-flex-basis: auto;-webkit-flex-direction: column;-webkit-flex-shrink: 0;align-items: stretch;border: 0 solid black;box-sizing: border-box;display: flex;flex-basis: auto;flex-direction: column;flex-shrink: 0;margin-bottom: 0px;margin-left: 0px;margin-right: 0px;margin-top: 0px;min-height: 44px;min-width: 44px;padding-bottom: 0px;padding-left: 0px;padding-right: 0px;padding-top: 0px;position: relative;z-index: 0;outline-style: none;transition-property: background-color, box-shadow;transition-duration: 0.2s;-moz-user-select: none;-ms-user-select: none;-webkit-user-select: none;user-select: none;margin: -12px;border-color: rgba(0, 0, 0, 0);border-width: 1px;border-style: solid;border-radius: 9999px;cursor: pointer;">

                    <div dir="auto" style="-webkit-box-align: center;align-items: center;-webkit-box-pack: center;justify-content: center;-webkit-box-direction: normal;-webkit-box-orient: horizontal;flex-direction: row;"><svg viewbox="-6 -5 36 36" aria-hidden="true" style="-moz-user-select: none;-ms-user-select: none;-webkit-user-select: none;user-select: none;">
                        <g>
                        <path fill="#ffffff" d="M19.708 22H4.292C3.028 22 2 20.972 2 19.708V7.375C2 6.11 3.028 5.083 4.292 5.083h2.146C7.633 3.17 9.722 2 12 2c2.277 0 4.367 1.17 5.562 3.083h2.146C20.972 5.083 22 6.11 22 7.375v12.333C22 20.972 20.972 22 19.708 22zM4.292 6.583c-.437 0-.792.355-.792.792v12.333c0 .437.355.792.792.792h15.416c.437 0 .792-.355.792-.792V7.375c0-.437-.355-.792-.792-.792h-2.45c-.317.05-.632-.095-.782-.382-.88-1.665-2.594-2.7-4.476-2.7-1.883 0-3.598 1.035-4.476 2.702-.16.302-.502.46-.833.38H4.293z"></path>

                        <path fill="#ffffff" d="M12 8.167c-2.68 0-4.86 2.18-4.86 4.86s2.18 4.86 4.86 4.86 4.86-2.18 4.86-4.86-2.18-4.86-4.86-4.86zm2 5.583h-1.25V15c0 .414-.336.75-.75.75s-.75-.336-.75-.75v-1.25H10c-.414 0-.75-.336-.75-.75s.336-.75.75-.75h1.25V11c0-.414.336-.75.75-.75s.75.336.75.75v1.25H14c.414 0 .75.336.75.75s-.336.75-.75.75z"></path></g></svg><span class="css-901oao css-16my406 css-bfa6kz r-poiln3 r-a023e6 r-rjixqe r-bcqeeo r-qvutc0"></span>

                        </div>

                        </div>

                        </div>
                    </a>
               </img>



               </div>


               </div>
              <div class="mb-2 d-none"> {!! CForm::inputGroupHeader(__("common.upload_image"),"prf") !!}
              <input id="photoinput" capture (change)="getFile($event)" type="file" class="form-control d-none  text-sm" accept=".jpg,.jpeg,.png" wire:model="photo">

              @error('photo') <div class="error_holder"> @include('back.common.validation', ['message' => $message ])
              </div>
              @enderror
              {!! CForm::inputGroupFooter()!!}

              </div>
              <div class="mb-2  d-none">
              {!! CForm::inputGroupHeader(__("common.upload_proof").CForm::generateInfoToolTip(__("common.either_image_plus_pdf")),"prf") !!}
              <input id="coverinput"  capture (change)="getFile($event)" type="file" class="form-control  text-sm" wire:model="cover" accept=".jpg,.jpeg,.png,.pdf"> @if($proof_link)
              @endif @error('proof') <div class="error_holder"> @include('back.common.validation', ['message' => $message ]) </div> @enderror {!! CForm::inputGroupFooter()!!} </div>
              <div class="mb-2  "> {!! CForm::inputGroupHeader(__("common.full_name"),"prf") !!} <input type="text" class="form-control" wire:model.defer="name" readonly> @error('name') <div class="error_holder"> @include('back.common.validation', ['message' => $message ]) </div> @enderror {!! CForm::inputGroupFooter()!!} </div>
              <div class="mb-2"> {!! CForm::inputGroupHeader(__("common.email"),"prf") !!} <input type="email" wire:model="email" class="form-control" readonly> {!! CForm::inputGroupFooter()!!} </div>
              <div class="mb-2"> {!! CForm::inputGroupHeader(__("common.phone"),"prf") !!} <input type="text" class="form-control" wire:model.defer="phone"> @error('phone') <div class="error_holder"> @include('back.common.validation', ['message' => $message ]) </div> @enderror {!! CForm::inputGroupFooter()!!} </div>

              <div class="mb-2"> {!! CForm::inputGroupHeader(__("common.address"),"prf") !!} <textarea class="form-control" wire:model.defer="address"></textarea> @error('address') <div class="error_holder"> @include('back.common.validation', ['message' => $message ]) </div> @enderror {!! CForm::inputGroupFooter()!!} </div>
              <div class="mb-2"> {!! CForm::inputGroupHeader(__("common.about_me"),"prf") !!} <textarea class="form-control" wire:model.defer="about_me"></textarea> @error('about_me') <div class="error_holder"> @include('back.common.validation', ['message' => $message ]) </div> @enderror {!! CForm::inputGroupFooter()!!} </div>
              <div class="mb-2">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="form-check">

                    </div>
                  </div> @error('check') <div class="error_holder">@include('back.common.validation', ['message' => $message ])</div> @enderror
                </div>
              </div>
              <div class="mb-2">
                <div class="input-group">
                  <button id="save" type="submit" class="btn btn-sm btn-dark" data-dismiss="MyModal">
                    <i class="fas fa-save mr-1"></i>{{__("common.save_profile")}}
                  </button><button  class="btn btn-sm btn-dark ml-2" id="qr" wire:click="qrgenerate" wire:loading.attr="disabled">
                    <i class="fas fa-save mr-1"></i>Download QR
                  </button>
                </div>
              </div>
            </div>
            <!-- /.tab-pane -->

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

<div class="modal fade" id="Privmodal" role="dialog" wire:ignore.self>


    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="card modal-content">
        <div class="card-header p-2 modal-header">
          <ul class="nav nav-pills w-100 ">
            <li class="nav-item m-1">
              <a class="nav-link {{$tab==1?'active':''}}" id="closeprivacytab" wire:click="$set('tab', 1)" href="#" data-toggle="tab">{{__('common.edit_profile')}}</a>

            </li>
            <li class="nav-item m-1">
              <a class="nav-link {{$tab==1?'active':''}}"  href="#" data-toggle="myModal">Edit Privacy</a>

            </li>
            <li class="nav-item ml-auto">
              <a id="closeprivacy" class="nav-link" href="#" data-toggle="myModal" >CLOSE</a>
            </li>


          </ul>
        </div>
        <!-- /.card-header -->
        <div class="card-body modal-body">
                                                @csrf
                                                <div class="mb-2">
                                                    {!! CForm::inputGroupHeader(__("common.current_password"),"pass") !!}
                                                    <input type="password" class="form-control"
                                                           wire:model.defer="current_password"
                                                    >
                                                    @error('current_password')
                                                    <div
                                                        class="error_holder"> @include('back.common.validation', ['message' =>  $message ]) </div> @enderror
                                                    {!! CForm::inputGroupFooter()!!}
                                                </div>

                                                <div class="mb-2">
                                                    {!! CForm::inputGroupHeader(__("common.new_password"),"pass") !!}
                                                    <input type="password" class="form-control"
                                                           wire:model.defer="password"
                                                    >
                                                    @error('password')
                                                    <div
                                                        class="error_holder"> @include('back.common.validation', ['message' =>  $message ]) </div> @enderror
                                                    {!! CForm::inputGroupFooter()!!}
                                                </div>

                                                <div class="mb-2">
                                                    {!! CForm::inputGroupHeader(__("common.confirm_password"),"pass") !!}
                                                    <input type="password" class="form-control"
                                                           wire:model.defer="password_confirmation"
                                                    >
                                                    @error('password_confirmation')
                                                    <div
                                                        class="error_holder"> @include('back.common.validation', ['message' =>  $message ]) </div> @enderror
                                                    {!! CForm::inputGroupFooter()!!}
                                                </div>

















                                                <div class="mb-2">
                                                Who can visit your profile?

                                                    <select required="" class="form-control" wire:model.defer="privacysearch">
												        <option value="1">Everyone</option>
                                                        <option value="2">Student within your course</option>
												        <option value="3" >Student within your year level</option>
												        <option value="4" >Student within your section</option>
												        <option value="5" >Only Me</option>
												    </select>
                                                </div>


                                                <div class="mb-2">
                                                    Who can see your recent borrowing?
                                                    <select required="" class="form-control" wire:model.defer="privacyborrow">
												        <option value="1">Everyone</option>
                                                        <option value="2">Student within your course</option>
												        <option value="3" >Student within your year level</option>
												        <option value="4" >Student within your section</option>
                                                        <option value="5" >Only Me</option>
												    </select>
                                                </div>


                                                <div class="mb-2">
                                                    Who can look you up?
                                                    <select required="" class="form-control"  wire:model.defer="privacyprofile">
												        <option value="1">Everyone</option>
                                                        <option value="2">Student within your course</option>
												        <option value="3" >Student within your year level</option>
												        <option value="4" >Student within your section</option>
                                                        <option value="5" >Only Me</option>
												    </select>
                                                </div>


                                                <div class="mb-2">
                                                    Who can see your name on the leader-board?

                                                    <select required="" class="form-control"  wire:model.defer="privacyleaderboard">
												        <option value="1">Everyone</option>
                                                        <option value="2">Student within your course</option>
												        <option value="3" >Student within your year level</option>
												        <option value="4" >Student within your section</option>
                                                        <option value="5" >Only Me</option>
												    </select>
                                                </div>


                                                <div class="mb-2">
                                                   Who can see your interactions? (Timeline)
                                                    <select required="" class="form-control"  wire:model.defer="privacyfuture">
												        <option value="1">Everyone</option>
                                                        <option value="2">Student within your course</option>
												        <option value="3" >Student within your year level</option>
												        <option value="4" >Student within your section</option>
                                                        <option value="5" >Only Me</option>
												    </select>
                                                </div>

                                                <div class="mb-2">
                                                    Allow the system to save your data
                                                    <select required="" class="form-control"  wire:model.defer="systempermission">
													    <option value="1">Allow The System</option>
												        <option value="2">I Do not intend to be part of data mining</option>
												    </select>
                                                    <span style="color:red;font-size: x-small;">Turning this off prevents the system from recognizing you on gatepass, making book recommendations, and including you in the leaderboard.</span>
                                                </div>




















                                                <div class="mb-2">
                                                    <div class="input-group">
                                                        <button id="savedupe" type="submit" class="btn btn-sm btn-dark" data-dismiss="MyModal">
                    <i class="fas fa-save mr-1"></i>{{__("common.save_profile")}}
                  </button><button  class="btn btn-sm btn-dark ml-2" id="qrdupe" wire:click="qrgenerate" wire:loading.attr="disabled">
                    <i class="fas fa-save mr-1"></i>Download QR
                  </button>
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
</form>

@endif
<div>



<div class="d-flex container">
  <div class="" style="width: 100%;">
    <div class="wrapper">
      <div class="wrapper">
        <main>
          <div class="main-section d-flex justify-content-center">
            <div class="">
              <div class="main-section-data ">
                <div class="row">
                  <section class="cover-sec">
                    <img class="hatdog" src="{{$cover_link}}" alt=""> @if($isOwner) <a id="changecoverphoto" href="#" title="">
                      <!-- <i class="fa fa-camera"></i> Font Awesome fontawesome.com --> Edit profile
                    </a>  @endif
                  </section>
                  <div class="row">
                    <div class="col-lg-3 pt-4">

                      <div class="main-left-sidebar">
                        <div class="user_profile">
                          <div class="user-pro-img" >
                            <img src="{{$photo_link}}" class="cheesedog">
                          </div>
                          <!--user-pro-img end-->
                          <div class="user-specs">
                            <h3>{{$name}}</h3>












                            @if($getprivacyprofile == 1)
                                        @php
                                        $lockvalidator = true;
                                        @endphp
  @else
    @endif


                                        @if($getprivacyprofile == 2)
                                        @php
                                        if($pcurrentCourse == $currentCourse){
                                            $lockvalidator = true;
                                        }
                                        @endphp


                                        @elseif($getprivacyprofile == 3)
                                        @php
                                        if(substr($pcurrentYear, 0, 1) == substr($currentYear, 0, 1)){
                                            $lockvalidator = true;
                                        }
                                        @endphp


                                        @elseif($getprivacyprofile == 4)
                                        @php
                                        if($pcurrentSection == $currentSection){

                                            $lockvalidator = true;
                                        }
                                        @endphp
                                        @elseif($getprivacyprofile == 5)
                                        @php
                                        if(Auth::id() == $this->user_id){
                                            $lockvalidator = true;
                                        }else{
                                            $lockvalidator = false;
                                        }
                                        @endphp
                                        @endif
































@if($lockvalidator == true)


                            <p class="text-muted text-center">
                            @foreach($current_user->roles as $role)
                                            <span class="badge badge-dark">{{\Illuminate\Support\Str::title($role->name)}}</span>
                            @endforeach
                            @if($assigned_on)
                                @foreach($assigned_on as $items)
                                    @foreach($items as $course=>$year)
                                        <span
                                            class="badge badge-primary">
                                            {{Str::title($common::getCourseName($course))}}  {{$common::getCourseYearName($year)}}</span>
                                        <br/>
                                    @endforeach
                                @endforeach
                            @endif
                            </p> @if(!empty($education))
                            <hr> @endif @if(!empty($address)) <strong> {{__("common.location")}}
                            </strong>
                            <p class="text-muted">{{$address}}</p>
                            <hr> @endif @if(!empty($about_me)) <strong> {{__("common.about_me")}}</strong>
                            <p class="text-muted">{{$about_me}}</p> @endif
                            <br>

                            @else
                            <span class="badge badge-red">This Profile is Locked</span>
                            <br>
                            &nbsp
                            @endif






















                          </div>
                          <!--user_pro_status end-->
                        </div>
                        <!--user_profile end-->

                        <!--suggestions end-->
                      </div>
                      <!--main-left-sidebar end-->



                       @if($lockvalidator == true)


                        <div class="widget widget-portfolio yellow">



                          <div class="wd-heady">
                            <h3>Book Request</h3>


                            <img src="images/photo-icon.png" alt="">
                          </div>
                          @if(isset($this->request))
                           @foreach($this->request as $key => $data)
                          <div class="pf-gallery">

                          <div class=" post_topbar p-0">
                                          <div class="row usy-dt w-100" style="align-items: center;">
                                             <img  class="col-md-2" style="height:100%;width:100%;cursor: pointer;border-radius: 0px!important" data-toggle="tooltip" data-placement="top"
                                             class="img-thumbnail" wire:click="activeUser" onclick="location='{{route("details", ['page_slug' => $common::utf8Slug($data["title"])])}}'"
                                            src="{{asset(str_replace (array('[', ']',chr(34)), '' , $data["book_img"]))}}"/>
                                             <div class="col-md-9 usy-name m-0">
                                                <a href="{{route("details", ['page_slug' => $common::utf8Slug($data["title"])])}}" style="color:#000;padding:0;"><h5 style="
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
">Claim On: {{$data["Borrowed"]}}</h5>
<h5 style="
    margin-left:10px!important;margin: 0;
    padding: 0;
    border: 0;
    font-size: 14px!important;
    font: inherit;
    vertical-align: baseline;
    color: #000;
    text-transform: capitalize;
">Expires On: {{$data["Borrowed"]}}</h5></a>

                                             </div>
                                             <div class="col-md-1 usy-name m-0">
                                              <button
                                              wire:click="cancelRequest({{$data["id"]}})"
                                            type="button"
                                            class="btn float-left btn-sm btn-danger action_btn">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                             </div>
                                          </div>
                                       </div>


                          </div>
                          @endforeach
                          @else



                           @foreach($this->request as $key => $data)
                          <div class="pf-gallery">

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
">Empty</h5></a>

                                             </div>
                                             <div class="col-md-1 usy-name m-0">
                                              <button

                                             </div>
                                          </div>
                                       </div>


                          </div>
                          @endforeach
                          @endif

                          <!--pf-gallery end-->
                        </div>

                        @else
                        <div class="widget widget-portfolio yellow">



                          <div class="wd-heady">
                            <h3>Issue Req are Locked</h3>
                            <img src="images/photo-icon.png" alt="">
                          </div>
                          <div class="pf-gallery">
                            <ul></ul>
                          </div>
                          <!--pf-gallery end-->
                        </div>
                        @endif



                    </div>
                    <div class="col-lg-6 p-4">
                      <div class="main-ws-sec">
                        <!--user-tab-sec end-->
                        <div class="product-feed-tab current" id="feed-dd">
                          <div class="posts-section">



















                          @if($getprivacyborrow == 1)
                                        @php
                                        $borrowvalidator = true;
                                        @endphp
  @else
    @endif


                                        @if($getprivacyborrow == 2)
                                        @php
                                        if($pcurrentCourse == $currentCourse){
                                            $borrowvalidator = true;
                                        }
                                        @endphp


                                        @elseif($getprivacyborrow == 3)
                                        @php
                                        if(substr($pcurrentYear, 0, 1) == substr($currentYear, 0, 1)){
                                            $borrowvalidator = true;
                                        }
                                        @endphp


                                        @elseif($getprivacyborrow == 4)
                                        @php
                                        if($pcurrentSection == $currentSection){

                                            $borrowvalidator = true;
                                        }
                                        @endphp
                                        @elseif($getprivacyborrow == 5)
                                        @php
                                        if(Auth::id() == $this->user_id){
                                            $borrowvalidator = true;
                                        }else{
                                            $borrowvalidator = false;
                                        }
                                        @endphp
                                        @endif































 @if($lockvalidator == true)

@if($borrowvalidator == true)
                          @foreach($merged_post as $key => $data) <div class="yellow post-bar">
                              <div class="post_topbar">
                                <div class="usy-dt">

                                  <img style="width:50px" data-toggle="tooltip" data-placement="top" class="img-thumbnail" src="{{asset($data["image"])}}" />
                                  <div class="usy-name">
                                    <h3>{{$data["name"]}}</h3>
                                    <span>{{$data["created_at"]->diffForHumans()}}</span>
                                  </div>
                                </div>
                              </div>
                              <div class="job_descp">
                                <center>

                                @if(asset(str_replace (array('[', ']',chr(34)), '' , $data["book_img"])) == asset("uploads/"."antiplaceholder"))

                                @else
                                    <img style="width:200px" data-toggle="tooltip" data-placement="top" class="img-thumbnail" src="{{asset(str_replace (array('[', ']',chr(34)), '' , $data["book_img"]))}}" />
                                @endif

                                </center>
                                <br>
                                <h2>
                                  {{$data["title"]}}
                                  </h2>
                                  <p style="text-align: justify;text-justify: inter-word;"> {!! str_limit($data["desc"], $limit = 350, $end = '...') !!} <a href="{{route("details", ['page_slug' => $common::utf8Slug($data["title"])])}}" title="">view more</a>
                                  </p>
                                  <ul class="skill-tags">
                                    <li>{!! str_replace (array('[', ']','"'), '' , $data["isReturned"]) !!}</li>
                                  </ul>
                              </div>
                              <div class="job-status-bar">
                                <a>
                                  @if($getprivacyborrow == 1)
                                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-globe2" viewBox="0 0 16 16" >
                                                <title>Shared with Everyone</title>
  <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855-.143.268-.276.56-.395.872.705.157 1.472.257 2.282.287V1.077zM4.249 3.539c.142-.384.304-.744.481-1.078a6.7 6.7 0 0 1 .597-.933A7.01 7.01 0 0 0 3.051 3.05c.362.184.763.349 1.198.49zM3.509 7.5c.036-1.07.188-2.087.436-3.008a9.124 9.124 0 0 1-1.565-.667A6.964 6.964 0 0 0 1.018 7.5h2.49zm1.4-2.741a12.344 12.344 0 0 0-.4 2.741H7.5V5.091c-.91-.03-1.783-.145-2.591-.332zM8.5 5.09V7.5h2.99a12.342 12.342 0 0 0-.399-2.741c-.808.187-1.681.301-2.591.332zM4.51 8.5c.035.987.176 1.914.399 2.741A13.612 13.612 0 0 1 7.5 10.91V8.5H4.51zm3.99 0v2.409c.91.03 1.783.145 2.591.332.223-.827.364-1.754.4-2.741H8.5zm-3.282 3.696c.12.312.252.604.395.872.552 1.035 1.218 1.65 1.887 1.855V11.91c-.81.03-1.577.13-2.282.287zm.11 2.276a6.696 6.696 0 0 1-.598-.933 8.853 8.853 0 0 1-.481-1.079 8.38 8.38 0 0 0-1.198.49 7.01 7.01 0 0 0 2.276 1.522zm-1.383-2.964A13.36 13.36 0 0 1 3.508 8.5h-2.49a6.963 6.963 0 0 0 1.362 3.675c.47-.258.995-.482 1.565-.667zm6.728 2.964a7.009 7.009 0 0 0 2.275-1.521 8.376 8.376 0 0 0-1.197-.49 8.853 8.853 0 0 1-.481 1.078 6.688 6.688 0 0 1-.597.933zM8.5 11.909v3.014c.67-.204 1.335-.82 1.887-1.855.143-.268.276-.56.395-.872A12.63 12.63 0 0 0 8.5 11.91zm3.555-.401c.57.185 1.095.409 1.565.667A6.963 6.963 0 0 0 14.982 8.5h-2.49a13.36 13.36 0 0 1-.437 3.008zM14.982 7.5a6.963 6.963 0 0 0-1.362-3.675c-.47.258-.995.482-1.565.667.248.92.4 1.938.437 3.008h2.49zM11.27 2.461c.177.334.339.694.482 1.078a8.368 8.368 0 0 0 1.196-.49 7.01 7.01 0 0 0-2.275-1.52c.218.283.418.597.597.932zm-.488 1.343a7.765 7.765 0 0 0-.395-.872C9.835 1.897 9.17 1.282 8.5 1.077V4.09c.81-.03 1.577-.13 2.282-.287z"/></svg>
@elseif($getprivacyborrow == 5)
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
<title>Only Me</title>
  <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
</svg>
@else
@if($getprivacyborrow == 2)
<title>Shared within current course</title>
@elseif($getprivacyborrow == 3)
<title>Shared within year level</title>
@elseif($getprivacyborrow == 4)
<title>Shared with current section</title>
@elseif($getprivacyborrow == 5)
<title>Only Me</title>
@endif
  <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
</svg>
@endif

                                  </a>
                              </div>
                            </div>
                            <!--post-bar end--> @endforeach
                            @else
                            <div class="yellow post-bar">

                              <div class="job_descp">
                                <center>



                                </center>
                                <br>
                                <h2>
                                  Visitors are not allowed to see recent activity because of the owner's prohibition.
                                  </h2>

                                  <ul class="skill-tags">

                                  </ul>
                              </div>
                              <div class="job-status-bar">
                                <a>
                                  <i class="la la-eye d-none"></i>Private</a>
                              </div>
                              </div>
                            @endif



                            @else
                            <div class="yellow post-bar">

                              <div class="job_descp">
                                <center>



                                </center>
                                <br>
                                <h2>
                                  The Owner has locked this profile.
                                  </h2>

                                  <ul class="skill-tags">

                                  </ul>
                              </div>
                              <div class="job-status-bar">
                                <a>
                                  <i class="la la-eye d-none"></i>Private</a>
                              </div>
                              </div>

 @endif


                            <!--post-bar end-->
                            <!--post-bar end-->
                            <!--post-bar end-->
                            <!--post-bar end-->
                            <!--process-comm end-->
                          </div>
                          <!--posts-section end-->
                        </div>
                        <!--product-feed-tab end-->
                        <!--product-feed-tab end-->
                        <!--product-feed-tab end-->
                        <!--product-feed-tab end-->
                        <!--product-feed-tab end-->
                        <!--product-feed-tab end-->
                      </div>
                      <!--main-ws-sec end-->


                    </div>



                    <div class="col-lg-3 pt-4">
                      <div class="right-sidebar">

                      @if($lockvalidator == true)


                        <div class="widget widget-portfolio yellow">



                          <div class="wd-heady">
                            <h3>AWARDS</h3>


                            <img src="images/photo-icon.png" alt="">
                          </div>
                          @foreach($this->awards as $data)
                          <div class="pf-gallery">

                          <div class=" post_topbar p-0">
                                          <div class="row usy-dt w-100" style="align-items: center;">
                                             <img  class="col-md-2" height:50px;width:50px;cursor: pointer data-toggle="tooltip" data-placement="top"
                                             class="img-thumbnail" wire:click="activeUser" onclick="location='{{route("profile", ['v_id' => $common::utf8Slug($data->user_id)])}}'"
                                             src="{{asset("uploads/".$data->img.".png")}}"/>
                                             <div class="col-md-10 usy-name m-0">
                                                <a href="{{route("profile", ['v_id' => $common::utf8Slug($data->user_id)])}}" style="color:#000;padding:0;"><h5 style="
    margin-left:10px!important;margin: 0;
    padding: 0;
    border: 0;
    font-size: 12px!important;
    font: inherit;
    vertical-align: baseline;
    color: #000;
    text-transform: capitalize;
    font-weight: 600;
">{{$data->noticetitle}}</h5></a>

                                             </div>
                                          </div>
                                       </div>


                          </div>
                          @endforeach
                          <!--pf-gallery end-->
                        </div>

                        @else
                        <div class="widget widget-portfolio yellow">



                          <div class="wd-heady">
                            <h3>AWARDS ARE LOCKED</h3>
                            <img src="images/photo-icon.png" alt="">
                          </div>
                          <div class="pf-gallery">
                            <ul></ul>
                          </div>
                          <!--pf-gallery end-->
                        </div>
                        @endif


                         @if($lockvalidator == true)


                        <div class="widget widget-portfolio yellow">



                          <div class="wd-heady">
                            <h3>Currently Borrowed</h3>


                            <img src="images/photo-icon.png" alt="">
                          </div>
                          @php
                          $this->loadCurrentlyborrowed();
                          @endphp
                          @foreach($this->currentlyBorrowed as $key => $data)
                          <div class="pf-gallery">

                          <div class=" post_topbar p-0">
                                          <div class="row usy-dt w-100" style="align-items: center;">
                                             <img  class="col-md-2" style="height:100%;width:100%;cursor: pointer;border-radius: 0px!important" data-toggle="tooltip" data-placement="top"
                                             class="img-thumbnail" wire:click="activeUser" onclick="location='{{route("details", ['page_slug' => $common::utf8Slug($data["title"])])}}'"
                                            src="{{asset(str_replace (array('[', ']',chr(34)), '' , $data["book_img"]))}}"/>
                                             <div class="col-md-9 usy-name m-0">
                                                <a href="{{route("details", ['page_slug' => $common::utf8Slug($data["title"])])}}" style="color:#000;padding:0;"><h5 style="
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
">Claim On: {{$data["Borrowed"]}}</h5>
<h5 style="
    margin-left:10px!important;margin: 0;
    padding: 0;
    border: 0;
    font-size: 14px!important;
    font: inherit;
    vertical-align: baseline;
    color: #000;
    text-transform: capitalize;
">Must Return : {{$data["Valid"]}}</h5></a>

                                             </div>

                                          </div>
                                       </div>


                          </div>
                          @endforeach
                          <!--pf-gallery end-->
                        </div>

                        @else
                        <div class="widget widget-portfolio yellow">



                          <div class="wd-heady">
                            <h3>Issue Req are Locked</h3>
                            <img src="images/photo-icon.png" alt="">
                          </div>
                          <div class="pf-gallery">
                            <ul></ul>
                          </div>
                          <!--pf-gallery end-->
                        </div>
                        @endif
                        <!--widget-portfolio end-->
                      </div>
                      <!--right-sidebar end-->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
  </div>
</div>
</div>
<style>



h1{
  margin: 10px 20px;
}
  .content-wrapper>.content {
    padding: 0;
  }

  .cheesedog {
    width: 180px;
  }

  .hatdog {

    height:50vh;
    height: calc(var(--vh, 1vh) * 50);
  }

  .hidebrtop {
    display: none;
  }

  @media only screen and (max-width: 768px) {
    .hatdog {
    height:25vh;
    height: calc(var(--vh, 1vh) * 25);
    }

    .cheesedog {
      width: 80px;
    }

  .cover-sec{
      height:25vh;
      height: calc(var(--vh, 1vh) * 25);
  }
  }



 .modal {
  overflow-y:auto;
}
</style>
 <script src="{{asset('front/js/vendor/jquery-1.12.4.min.js')}}"></script>
<script>
const submit = document.getElementById('save');
const close = document.getElementById('close');
const photoinput = document.getElementById('photoinput');
const coverinput = document.getElementById('coverinput');


$("#close").click(function () {
   $('#myModal').modal('toggle');
});
$("#save").click(function () {
  // $('#myModal').modal('toggle');
});

$("#photoclick").click(function() {
photoinput.click();

});

$("#coverclick").click(function() {
coverinput.click();

});

$("#edit").click(function() {
$("#myModal").modal();
});


$("#close").click(function(){
close.click();
});

$("#closeprivacy").click(function(){
close.click();
$("#Privmodal").modal();
});


$("#changecoverphoto").click(function(){
$("#myModal").modal();

});$("#privacy").click(function(){
$("#Privmodal").modal();
});



</script>
@endif



</div>
