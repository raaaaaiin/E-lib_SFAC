<div>

<input type="hidden" id="return_date" value="">
                <input type="hidden" id="fine" value="">
                <input type="hidden" id="remark" value="">
  <div class="content-wrapper w-100 m-0">
    <div class="w-100 m-0">
      <div class="main-body">
        <!-- Breadcrumb -->
        <!-- /Breadcrumb -->
        <div class="row gutters-sm">
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
                        <span class="text-secondary">  
						@foreach($this->section as $items)
						@foreach($items as $course=>$year) {{Str::title($common::getCourseName($course))}} @endforeach @endforeach </span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-mortarboard" viewBox="0 0 16 16">
                            <path d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917l-7.5-3.5ZM8 8.46 1.758 5.965 8 3.052l6.242 2.913L8 8.46Z" />
                            <path d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466 4.176 9.032Zm-.068 1.873.22-.748 3.496 1.311a.5.5 0 0 0 .352 0l3.496-1.311.22.748L8 12.46l-3.892-1.556Z" />
                          </svg> Section
                        </h6>
                        <span class="text-secondary">@foreach($this->section as $items) @foreach($items as $course=>$year) {{Str::title($common::getCourseName($course))}} {{$common::getCourseYearName($year)}} @endforeach @endforeach</span>
                      </li>
					  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="mb-0">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-mortarboard" viewBox="0 0 16 16">
                            <path d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917l-7.5-3.5ZM8 8.46 1.758 5.965 8 3.052l6.242 2.913L8 8.46Z" />
                            <path d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466 4.176 9.032Zm-.068 1.873.22-.748 3.496 1.311a.5.5 0 0 0 .352 0l3.496-1.311.22.748L8 12.46l-3.892-1.556Z" />
                          </svg> Total Penalty
                        </h6>
                        <span class="text-secondary">@php
                        $penalty=$common::getTotalFines($this->user_id)? $common::getTotalFines($this->user_id) : 0;
                        @endphp

                        {{$penalty}} PHP</span>
                      </li>
                      @if($this->ownAccess == true)
                      <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <div class="input-group-prepend ">
                          <span class="input-group-text ">Input Remarks</span>
                        </div>
                        <input id="remarkvalue" type="text" class="form-control">
                      </li>
                      @endif
                    </ul>
                    <br>
                    <div class="ml-auto float-right">
                    
                    @if($this->ownAccess == true)
					  <button id="remark" class="btn btn-outline-success">Remarks</button>
					  
                        <button id="submit" class="btn btn-outline-primary">Return All</button> 
                        
                    
                    @else
                    @endif
                    
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
           <div class="col-md-6 mb-3">
            <div class="dashcard dashcardshad">
              <div class="card-header blue">
                <span class="card-header-title">Returne Book</span>
              </div>
              <div wire:ignore class="card-body yellow">
                <script>
                  var builder;
                </script> @php $today = date("Y-m-d"); $this->loadRequest(); $notfullyrendered = 0; $counter =1; @endphp @foreach($this->request as $key => $data) @php $borrowing = date($data["Borrowed"]); @endphp @if($borrowing > $today) <div class="col p-0">
                  <div class="alert alert-light" role="alert">
                    <h4 class="alert-heading m-0" style="font-size:16px">Book below is scheduled on: {{$data["Borrowed"]}} </h4>
                  </div> @else @endif @php if($notfullyrendered == 0){ $this->selectedtypes = $data["Accession"]; } @endphp
                  <div class="card">
                    <div class="additional">
                      <div class="user-card">
                        <img style="    width: 150px;
                        height: 100%;" src="{{asset(str_replace (array('[', ']',chr(34)), '' , $data["book_img"]))}}"></img>
                      </div>
                      <div class="more-info">
                        <div class="coords p-2 m-0">
                          <span class="titles">Title: <span class="span">{{$data["title"]}}</span>
                          </span>
                          <br>
                          <span class="titles">Accession: <span class="span">{{$data["Accession"]}}</span>
                          </span>
                          <br>
                          <span class="titles" style="@if($borrowing > $today)
                               color:Red

                                  @endif">Borrow Date: <span class="span">{{$data["Borrowed"]}}</span>
                          </span>
                          <br>
                          <span class="titles">Return Date: <span class="span">{{$data["Returned"]}}</span>
                          </span>
                          <br>
                          <span class="titles">Borrower: <span class="span">{{$data["name"]}}</span>
                          </span>
                          <br>
                          <span class="titles">Issuer: <span class="span"> {{$data["issue"]}}</span>
                          </span>
                          <br>
                          <br>
                          <span class="titles">Hover to slide <span class="span"></span>
                          </span>
                          <br>
                        </div>
                      </div>
                    </div>
                    <div class="general p-2 m-0 d-flex" style="flex-direction: column;    justify-content: space-between;">
                      <div>
                        
                         @php
                                        $date_to_return = Illuminate\Support\Carbon::parse($data["Returned"]);
                                        $now = Illuminate\Support\Carbon::now();
                                        $lv_delayed_days = 0;
                                        $lv_fine = 0;
                                        if(!isset($data["Return"]))
                                        {
                                            $this->notifcreator($date_to_return->diffInDays($now) + 1,$data["user_id"],$data["Accession"]);
                                            if($now>$date_to_return){ // we are late
                                                $lv_delayed_days = $date_to_return->diffInDays($now);;
                                                $lv_fine = $lv_delayed_days*$common::getSiteSettings("fine_per_day",1);
                                            }
                                         }
                                    @endphp

                       
                        <span class="titles">Late: <span class="span">{{is_null($data["Return"]) ? strval($lv_delayed_days)." Days" : ($data["delayed_day"] ?? strval(0)." Days")}}</span>
                        </span>
                        <br>
                        <span class="titles">Expiration: <span class="span">{!! is_null($data["Return"]) ? $now>$date_to_return ? "MUST RETURN NOW" : strval($now->diffInDays($date_to_return) + 1) . " Days left" : "Returned" !!} 
</span>
                        </span>
                        <br>
                        <span class="titles">Penalty: <span class="span">{{$lv_fine}} PHP</span>
                        </span>
                        <br>
                        <span class="titles">Comment: <span class="span"><textarea id='remark_".$data["id"]."' rows=3 wire:ignore class='form-control remark_obj text-sm'></textarea></span>
                        </span>
                      </div>
                      <div class="d-flex ml-auto">
                                            <button type="button"
                                                    onclick="lv_confirm_then_submit(this,'{{__("Confirm to renew this loan for another 5 days")}}','renewloan','{\'id\':{{$data["origid"]}}}');"
                                                    class="btn btn-xs btn-dark mb-1 m-1">{{__("Loan Renew")}}
                                            </button>
											<button type="button"
                                                    onclick="lv_confirm_then_submit(this,'{{__("common.cnf_mark_lost")}}','markLostBook','{\'id\':{{$data["sub_book_origid"]}},\'uid\':{{$data["user_id"]}}}')"
                                                    class="btn btn-xs btn-dark mb-1 m-1">{{__("common.mark_lost")}}
                                            </button>
                                            
                                            <button type="button"
                                                    onclick="lv_confirm_then_submit(this,'{{__("commonv2.cnf_mark_damage")}}','markDamageBook',
                                                        '{\'id\':{{$data["sub_book_origid"]}},\'uid\':{{$data["user_id"]}}}')"
                                                    class="btn btn-xs btn-dark mb-1 m-1">{{__("commonv2.cnf_damage")}}
                                            </button>
											<button type="button"
                                                    onclick="flush_data({{$data["id"]}});lv_confirm_then_submit(this,'{{__("common.cnf_receive_of_book")}}','receiveBook','{\'id\':{{$data["origid"]}}}');"
                                                    class="btn btn-xs btn-dark mb-1 m-1">{{__("common.receive_book")}}
                                            </button>
                                       
                      </div>
                    </div>
                  </div> @php $counter += 1; $notfullyrendered = 1; @endphp @endforeach
                </div>
              </div>
              <script>
                var finaltext = builder;
                $(".form-check-input").click(function() {
                  if ($(this).prop("checked")) {
                    finaltext = finaltext + $(this).val() + ",";
                  } else {
                    finaltext = finaltext.replace($(this).val() + ",", '');
                  }
                });
                $("#submit").click(function() {
                  window.livewire.emit('test', finaltext);
                });
                $("#remark").click(function() {
                  window.livewire.emit('saveRemarks', $('#remarkvalue').val());
                });
              </script>
            </div>
          <div class="col-md-3">
            <div class="dashcard dashcardshad">
              <div class="card-header blue">
                <span class="card-header-title">User Information</span>
              </div>
              <div class="card-body yellow">
                <div class="dashcard mb-3">
                  <div class="dashcard-body pb-0">
                    <div class="row">
                      <div class="col-sm-5">
                        <h6 class="mb-0">Student Number</h6>
                      </div>
                      <div class="col-sm-7 text-secondary">
                        {{$this->user_id}}
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-5">
                        <h6 class="mb-0">Full Name</h6>
                      </div>
                      <div class="col-sm-7 text-secondary">
                        {{$this->name}}
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-5">
                        <h6 class="mb-0">Gender</h6>
                      </div>
                      <div class="col-sm-7 text-secondary">
                        {{$this->gender}}
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-5">
                        <h6 class="mb-0">Role</h6>
                      </div>
                      <div class="col-sm-7 text-secondary"> @foreach($this->roles as $role){{Str::title($role->name)}} @endforeach </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-5">
                        <h6 class="mb-0">Address</h6>
                      </div>
                      <div class="col-sm-7 text-secondary">
                        {{$this->address}}
                      </div>
                    </div>
                    <hr>
                    <div class="row"></div>
                  </div>
                </div>
                <div class="row gutters-sm">
                  <div class="col-sm-6 mb-3" style="overflow-x:hidden">
                    <div class="dashcard h-100" >
                      <div class="dashcard-body pt-0" style="overflow-x:hidden">
                        <h6 class="d-flex align-items-center mb-3" style="overflow-x:hidden">
                          <i class="material-icons text-info mr-2">Previously</i>Remarks
                        </h6>
                        <div style="overflow-y: scroll; height: 268px;"> @foreach($this->currentlyRemarks as $key => $data) <div class="pf-gallery p-0 row mb-2" style="border-bottom:1px;">
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
                  <div class="col-sm-6 mb-3"  style="overflow-x:hidden">
                    <div class="dashcard h-100" style="overflow-x:hidden">
                      <div class="dashcard-body pt-0" style="overflow-y: scroll;">
                        <h6 class="d-flex align-items-center mb-3" style="overflow-x:hidden">
                          <i class="material-icons text-info mr-2">Previously</i>Borrowed
                        </h6>
                        <div style="overflow-y: scroll;
    height: 268px;"> @foreach($this->currentlyBorrowed as $key => $data) <div class="pf-gallery p-0 row" style="border-bottom:1px;">
                            <div class=" post_topbar p-0">
                              <div class="row usy-dt w-100" style="align-items: center;">
                              
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
          background: linear-gradient(#f0f0f0, #f0f0f0);
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
          background: linear-gradient(#d0d0d0, #d0d0d0);
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
  flush_data = function ($id) {
        $fine_obj = $("#fine_" + $id);
        $remark_obj = $("#remark_" + $id);
        if ($fine_obj.length) {
            $("#fine").val($fine_obj.val());
        }
        if ($remark_obj.length) {
            $("#remark").val($remark_obj.text());
        }
        window.livewire.emit('data_manager', {"fine": $("#fine").val()});
        window.livewire.emit('data_manager', {"remark": $("#remark").val()});
    }
    window.addEventListener('refresh_elements', event => {
        refresh_elements(event);
    });
  </script>
</div>
