<div class="w-100">
    @php
        /* @var \App\Facades\Util $util */
        /* @var \App\Facades\Common $common */
    @endphp
    @php $location_target="dd_filter"; @endphp
    @include("back.common.spinner")
    @php
    @endphp









    <div class="card">
    <div class="card-header blue">
                <span class="card-header-title">Must Return Today</span>
              </div>
        <div class="card-body yellow">
            <div class="form-row">
                <input type="hidden" id="return_date" value="">
                <input type="hidden" id="fine" value="">
                <input type="hidden" id="remark" value="">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                        <tr>
                          <th>{{__("common.bo_id")}}</th>
                            <th>Accession</th>
                            <th>{!!__("common.book_img")!!}</th>
                            <th style="width: 65px;">{!!__("common.user_img")!!}</th>
                            {{--                            <th>{{__("common.title")}}</th>--}}
                            <th>{!!__("common.short_issued_date") !!}</th>
                            <th>{!!__("common.date_to_return")!!}</th>
                            <th>{!!__("common.date_returned")!!}</th>
                            <th>Day Late
                                <i class="far fa-eye mouse" wire:click="$set('dd_filter', true)"></i>
                            </th>
                            <th style="width: 120px;">Day Left</th>
                            <th style="width: 120px;">{{__("common.remark")}}</th>
                            <th>{{__("common.issued_by")}}</th>
                            <th>{!!__("common.pl_created_on")!!}</th>
                            <th style="width:120px">{{__("common.action")}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($today))
                            @foreach($today as $item)
                            @php
                            @endphp
                                <tr class="@if(\Carbon\Carbon::now()>\Carbon\Carbon::parse($item->date_to_return)) bg-odd @endif text-sm">
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->sub_book->sub_book_id}}</td>
                                    <td>
                                        <img data-toggle="tooltip" data-placement="top" title="{{$item->book->title}}"
                                             style="width: 50px" class="img-thumbnail"
                                             src="{{$item->book->cover_img()}}"/>
                                    </td>
                                    @php
                                        $name=$item->user->name;
                                        $phone = $item->user->get_phone();
                                        $email = $item->user->email;
                                        $proof = $item->user->get_proof();
                                        $academics = $item->user->get_academic_details();
                                        $short_name = $name;
                                        if(\Illuminate\Support\Str::length($name)>5){
                                           $checkifspace = explode(" ",$name);
                                           if($checkifspace){
                                               $short_name=$checkifspace[0];
                                           }
                                        }
                                    @endphp
                                    <td>
                                        <figure>
                                            <img data-toggle="tooltip" data-placement="top" title="{{$name}}"
                                                     style="width: 45px" class="img-thumbnail"
                                                     src="{{asset("uploads/".$item->user->get_user_image())}}"/>
                                            <figcaption class="">
                                                <span class="text-sm">{{$short_name}}</span><br/>
                                                <span class="badge badge-light">uid:{{$item->user_id}}</span>
                                            </figcaption>
                                        </figure>
                                        @if(!empty($email) && $email!='--')
                                            <i class="far fa-envelope" data-toggle="tooltip" data-placement="top"
                                               title="{{$email}}"></i>
                                        @endif

                                        @if(!empty($phone) && $phone!='--')
                                            <i class="fas fa-phone" data-toggle="tooltip"
                                               style="font-size: 12px;margin-left: 5px;"
                                               data-placement="top"
                                               title="{{$phone}}"></i>
                                        @endif
                                        @if(!empty($academics) && $academics!='--')
                                            <i class="fas fa-university"  data-toggle="tooltip"
                                               style="font-size: 15px;margin-left: 5px;"
                                               data-placement="top"
                                               title="{{$academics}}"></i>
                                        @endif
                                        @if(!empty($proof) && $proof!='--' && !empty($util::fileChecker(public_path("uploads"),$proof,"")))
                                            <a target="_blank" href="{{asset("uploads/".$proof)}}">
                                                <i class="fas fa-paperclip mouse" data-toggle="tooltip"
                                                   style="font-size: 12px;margin-left: 5px;"
                                                   data-placement="top"
                                                   title="Proof"></i></a>

                                        @endif

                                    </td>
                                    {{--                                    <td>{{$item->book->title}}</td>--}}
                                    <td class="show_g_dt">{{Util::goodDate($item->date_borrowed)}}</td>
                                    <td class="show_g_dt">{{Util::goodDate($item->date_to_return)}}</td>
                                    <td class="show_g_dt"

                                    >{!! $item->date_returned ? Util::goodDate($item->date_returned): "<input type='text' wire:ignore class='form-control date_picker'/>" !!}</td>
                                    @php
                                        $date_to_return = Illuminate\Support\Carbon::parse($item->date_to_return);
                                        $now = Illuminate\Support\Carbon::now();
                                        $lv_delayed_days = 0;
                                        $lv_fine = 0;
                                        if(!isset($item->date_returned))
                                        {

                                            if($now>$date_to_return){ // we are late
                                                $lv_delayed_days = $date_to_return->diffInDays($now);;
                                                $lv_fine = $lv_delayed_days*$common::getSiteSettings("fine_per_day",1);
                                            }
                                         }
                                    @endphp
                                    <td>{{is_null($item->date_returned) ? $lv_delayed_days : ($item->delayed_day ?? 0)}}</td>
                                    <td>{!! is_null($item->date_returned) ? $now>$date_to_return ? "MUST RETURN NOW" : $now->diffInDays($date_to_return) + 1 : "Returned" !!}</td>
                                    <td>{!! is_null($item->date_returned) ? ("<textarea id='remark_".$item->id."' rows=3 wire:ignore class='form-control remark_obj text-sm'>".$util::getIfNotEmpty($item->remark)."</textarea>"):
                                ($util::getIfNotEmpty($item->remark) ?? "--") !!}</td>
                                    <td>


                                    <figure>
                                            <img data-toggle="tooltip" data-placement="top" title="{{ $item->issued_by_person->name}}"
                                                     style="width: 45px" class="img-thumbnail"
                                                     src="{{asset("uploads/".\App\Models\User::get_user_photo($item->issued_by_person->id))}}"/>
                                            <figcaption class="">
                                                <span class="text-sm">{{ $item->issued_by_person->name}}</span><br/>
                                                <span class="badge badge-light">uid:{{ $item->issued_by_person->id}}</span>
                                            </figcaption>
                                        </figure>

                                    </td>
                                    <td>{{Util::goodDate($item->created_at)}}</td>
                                    <td>
                                        @if(!$item->date_returned)
                                            <button type="button"
                                                    onclick="flush_data({{$item->id}});lv_confirm_then_submit(this,'{{__("common.cnf_receive_of_book")}}','receiveBook','{\'id\':{{$item->id}}}');"
                                                    class="btn btn-xs btn-dark mb-1">{{__("common.receive_book")}}
                                            </button>
                                            <button type="button"
                                                    onclick="lv_confirm_then_submit(this,'{{__("common.cnf_mark_lost")}}','markLostBook','{\'id\':{{$item->sub_book_id}},\'uid\':{{$item->user_id}}}')"
                                                    class="btn btn-xs btn-dark mb-1">{{__("common.mark_lost")}}
                                            </button>
                                            @if($item->payment && $item->payment->payment_status)
                                                <span class="badge badge-primary">{{__("common.paid")}}</span>
                                                <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top"
                                                   title="{{__("common.paid_msg_for_admins",["inv_id"=>$item->payment->invoice_no,
                                            "amt_paid"=>$item->payment->payed_amount,"paid_date"=>$util::goodDate($item->payment->created_at),
                                            "payer_email"=>$item->payment->payer_email,"symbol"=>$common::getSiteSettings("currency_symbol")])}}"></i>
                                            @endif
                                            @if($item->payment && $item->payment->refund_status)
                                                <span class="badge badge-warning">{{__("common.refund")}}</span>
                                                <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top"
                                                   title="{{__("common.refnd_msg_for_admins",["inv_id"=>$item->payment->refund_id,
                                            "amt_rfnd"=>$item->payment->refund_amount,"status"=>$item->payment->refund_status,"curr"=>$common::getSiteSettings("currency_symbol")
                                            ])}}"></i>
                                            @endif
                                            <button type="button"
                                                    onclick="lv_confirm_then_submit(this,'{{__("commonv2.cnf_mark_damage")}}','markDamageBook',
                                                        '{\'id\':{{$item->sub_book_id}},\'uid\':{{$item->user_id}}}')"
                                                    class="btn btn-xs btn-dark mb-1">{{__("commonv2.cnf_damage")}}
                                            </button>
                                        @else
                                            <span class="badge badge-success">{{__("common.received")}}</span><br/>
                                            @if($item->sub_book->lost_by==$item->user_id)
                                                <span class="badge badge-danger">{{__("common.losted")}}</span>
                                            @endif
                                            @if($item->sub_book->damaged_by==$item->user_id)
                                                <span data-toggle="tooltip" data-placement="top"
                                                      title="{{__("commonv2.damaged")}}" class="badge badge-danger"><i
                                                        class="fas fa-faucet"></i></span>
                                            @endif
                                        @endif
                                    </td>

                                </tr>

                            @endforeach
                            @if(!$items->count())
                                <tr>
                                    <td colspan="14">
                                        <div class="alert alert-dark">{{__("common.no_book_borrowed_yet")}}</div>
                                    </td>
                                </tr>
                            @endif
                        @endif
                        </tbody>
                    </table>
                    @if(isset($items) && $items->count())
                        {{$items->links()}}
                    @endif
                </div>
            </div>
        </div>
    </div>









     <div class="card">
    <div class="card-header blue">
                <span class="card-header-title">To be Return this week</span>
              </div>
        <div class="card-body yellow">

            <div class="form-row">
                <input type="hidden" id="return_date" value="">
                <input type="hidden" id="fine" value="">
                <input type="hidden" id="remark" value="">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                        <tr>
                           <th>{{__("common.bo_id")}}</th>
                            <th>Accession</th>
                            <th>{!!__("common.book_img")!!}</th>
                            <th style="width: 65px;">{!!__("common.user_img")!!}</th>
                            {{--                            <th>{{__("common.title")}}</th>--}}
                            <th>{!!__("common.short_issued_date") !!}</th>
                            <th>{!!__("common.date_to_return")!!}</th>
                            <th>{!!__("common.date_returned")!!}</th>
                            <th>Day Late
                                <i class="far fa-eye mouse" wire:click="$set('dd_filter', true)"></i>
                            </th>
                            <th style="width: 120px;">Day Left</th>
                            <th style="width: 120px;">{{__("common.remark")}}</th>
                            <th>{{__("common.issued_by")}}</th>
                            <th>{!!__("common.pl_created_on")!!}</th>
                            <th style="width:120px">{{__("common.action")}}</th>
                        </tr>
                        </thead>
                        <tbody>

                        @if(isset($items))
                            @foreach($items as $item)

                            @php
                            @endphp
                                <tr class="@if(\Carbon\Carbon::now()>\Carbon\Carbon::parse($item->date_to_return)) bg-odd @endif text-sm">
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->sub_book->sub_book_id}}</td>
                                    <td>
                                        <img data-toggle="tooltip" data-placement="top" title="{{$item->book->title}}"
                                             style="width: 50px" class="img-thumbnail"
                                             src="{{$item->book->cover_img()}}"/>
                                    </td>
                                    @php
                                        $name=$item->user->name;
                                        $phone = $item->user->get_phone();
                                        $email = $item->user->email;
                                        $proof = $item->user->get_proof();
                                        $academics = $item->user->get_academic_details();
                                        $short_name = $name;
                                        if(\Illuminate\Support\Str::length($name)>5){
                                           $checkifspace = explode(" ",$name);
                                           if($checkifspace){
                                               $short_name=$checkifspace[0];
                                           }
                                        }
                                    @endphp
                                    <td>
                                        <figure>
                                            <img data-toggle="tooltip" data-placement="top" title="{{$name}}"
                                                     style="width: 45px" class="img-thumbnail"
                                                     src="{{asset("uploads/".$item->user->get_user_image())}}"/>
                                            <figcaption class="">
                                                <span class="text-sm">{{$short_name}}</span><br/>
                                                <span class="badge badge-light">uid:{{$item->user_id}}</span>
                                            </figcaption>
                                        </figure>
                                        @if(!empty($email) && $email!='--')
                                            <i class="far fa-envelope" data-toggle="tooltip" data-placement="top"
                                               title="{{$email}}"></i>
                                        @endif

                                        @if(!empty($phone) && $phone!='--')
                                            <i class="fas fa-phone" data-toggle="tooltip"
                                               style="font-size: 12px;margin-left: 5px;"
                                               data-placement="top"
                                               title="{{$phone}}"></i>
                                        @endif
                                        @if(!empty($academics) && $academics!='--')
                                            <i class="fas fa-university"  data-toggle="tooltip"
                                               style="font-size: 15px;margin-left: 5px;"
                                               data-placement="top"
                                               title="{{$academics}}"></i>
                                        @endif
                                        @if(!empty($proof) && $proof!='--' && !empty($util::fileChecker(public_path("uploads"),$proof,"")))
                                            <a target="_blank" href="{{asset("uploads/".$proof)}}">
                                                <i class="fas fa-paperclip mouse" data-toggle="tooltip"
                                                   style="font-size: 12px;margin-left: 5px;"
                                                   data-placement="top"
                                                   title="Proof"></i></a>

                                        @endif

                                    </td>
                                    {{--                                    <td>{{$item->book->title}}</td>--}}
                                    <td class="show_g_dt">{{Util::goodDate($item->date_borrowed)}}</td>
                                    <td class="show_g_dt">{{Util::goodDate($item->date_to_return)}}</td>
                                    <td class="show_g_dt"

                                    >{!! $item->date_returned ? Util::goodDate($item->date_returned): "<input type='text' wire:ignore class='form-control date_picker'/>" !!}</td>
                                    @php
                                        $date_to_return = Illuminate\Support\Carbon::parse($item->date_to_return);
                                        $now = Illuminate\Support\Carbon::now();
                                        $lv_delayed_days = 0;
                                        $lv_fine = 0;
                                        if(!isset($item->date_returned))
                                        {

                                            if($now>$date_to_return){ // we are late
                                                $lv_delayed_days = $date_to_return->diffInDays($now);;
                                                $lv_fine = $lv_delayed_days*$common::getSiteSettings("fine_per_day",1);
                                            }
                                         }
                                    @endphp
                                    <td>{{is_null($item->date_returned) ? $lv_delayed_days : ($item->delayed_day ?? 0)}}</td>
                                    <td>{!! is_null($item->date_returned) ? $now>$date_to_return ? "MUST RETURN NOW" : $now->diffInDays($date_to_return) + 1 : "Returned" !!}</td>
                                    <td>{!! is_null($item->date_returned) ? ("<textarea id='remark_".$item->id."' rows=3 wire:ignore class='form-control remark_obj text-sm'>".$util::getIfNotEmpty($item->remark)."</textarea>"):
                                ($util::getIfNotEmpty($item->remark) ?? "--") !!}</td>
                                    <td>


                                    <figure>
                                            <img data-toggle="tooltip" data-placement="top" title="{{ $item->issued_by_person->name}}"
                                                     style="width: 45px" class="img-thumbnail"
                                                     src="{{asset("uploads/".\App\Models\User::get_user_photo($item->issued_by_person->id))}}"/>
                                            <figcaption class="">
                                                <span class="text-sm">{{ $item->issued_by_person->name}}</span><br/>
                                                <span class="badge badge-light">uid:{{ $item->issued_by_person->id}}</span>
                                            </figcaption>
                                        </figure>

                                    </td>
                                    <td>{{Util::goodDate($item->created_at)}}</td>
                                    <td>
                                        @if(!$item->date_returned)
                                            <button type="button"
                                                    onclick="flush_data({{$item->id}});lv_confirm_then_submit(this,'{{__("common.cnf_receive_of_book")}}','receiveBook','{\'id\':{{$item->id}}}');"
                                                    class="btn btn-xs btn-dark mb-1">{{__("common.receive_book")}}
                                            </button>
                                            <button type="button"
                                                    onclick="lv_confirm_then_submit(this,'{{__("common.cnf_mark_lost")}}','markLostBook','{\'id\':{{$item->sub_book_id}},\'uid\':{{$item->user_id}}}')"
                                                    class="btn btn-xs btn-dark mb-1">{{__("common.mark_lost")}}
                                            </button>
                                            @if($item->payment && $item->payment->payment_status)
                                                <span class="badge badge-primary">{{__("common.paid")}}</span>
                                                <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top"
                                                   title="{{__("common.paid_msg_for_admins",["inv_id"=>$item->payment->invoice_no,
                                            "amt_paid"=>$item->payment->payed_amount,"paid_date"=>$util::goodDate($item->payment->created_at),
                                            "payer_email"=>$item->payment->payer_email,"symbol"=>$common::getSiteSettings("currency_symbol")])}}"></i>
                                            @endif
                                            @if($item->payment && $item->payment->refund_status)
                                                <span class="badge badge-warning">{{__("common.refund")}}</span>
                                                <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top"
                                                   title="{{__("common.refnd_msg_for_admins",["inv_id"=>$item->payment->refund_id,
                                            "amt_rfnd"=>$item->payment->refund_amount,"status"=>$item->payment->refund_status,"curr"=>$common::getSiteSettings("currency_symbol")
                                            ])}}"></i>
                                            @endif
                                            <button type="button"
                                                    onclick="lv_confirm_then_submit(this,'{{__("commonv2.cnf_mark_damage")}}','markDamageBook',
                                                        '{\'id\':{{$item->sub_book_id}},\'uid\':{{$item->user_id}}}')"
                                                    class="btn btn-xs btn-dark mb-1">{{__("commonv2.cnf_damage")}}
                                            </button>
                                        @else
                                            <span class="badge badge-success">{{__("common.received")}}</span><br/>
                                            @if($item->sub_book->lost_by==$item->user_id)
                                                <span class="badge badge-danger">{{__("common.losted")}}</span>
                                            @endif
                                            @if($item->sub_book->damaged_by==$item->user_id)
                                                <span data-toggle="tooltip" data-placement="top"
                                                      title="{{__("commonv2.damaged")}}" class="badge badge-danger"><i
                                                        class="fas fa-faucet"></i></span>
                                            @endif
                                        @endif
                                    </td>

                                </tr>

                            @endforeach
                            @if(!$items->count())
                                <tr>
                                    <td colspan="14">
                                        <div class="alert alert-dark">{{__("common.no_book_borrowed_yet")}}</div>
                                    </td>
                                </tr>
                            @endif
                        @endif
                        </tbody>
                    </table>
                    @if(isset($items) && $items->count())
                        {{$items->links()}}
                    @endif
                </div>
            </div>
        </div>
    </div>










    <div class="card">
     <div class="card-header blue">
                <span class="card-header-title">All Book</span>
              </div>
        <div class="card-body yellow">

        <div class="card-body">
            <div class="form-row mb-10">
                <div class="col-md">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">{{__("common.advanced_filter")}}</span>
                        </div>
                        <input type="text" wire:model="search_keyword" class="form-control" name=""
                               placeholder="{{__("common.ty_search")}}">
                        <div class="input-group-append">
                            <a href="{{route('indexReceiveBooks')}}" class="btn btn-danger">
                                <i class="far fa-trash-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <input type="hidden" id="return_date" value="">
                <input type="hidden" id="fine" value="">
                <input type="hidden" id="remark" value="">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                        <tr>
                           <th>{{__("common.bo_id")}}</th>
                            <th>Accession</th>
                            <th>{!!__("common.book_img")!!}</th>
                            <th style="width: 65px;">{!!__("common.user_img")!!}</th>
                            {{--                            <th>{{__("common.title")}}</th>--}}
                            <th>{!!__("common.short_issued_date") !!}</th>
                            <th>{!!__("common.date_to_return")!!}</th>
                            <th>{!!__("common.date_returned")!!}</th>
                            <th>Day Late
                                <i class="far fa-eye mouse" wire:click="$set('dd_filter', true)"></i>
                            </th>
                            <th style="width: 120px;">Day Left</th>
                            <th style="width: 120px;">{{__("common.remark")}}</th>
                            <th>{{__("common.issued_by")}}</th>
                            <th>{!!__("common.pl_created_on")!!}</th>
                            <th style="width:120px">{{__("common.action")}}</th>
                        </tr>
                        </thead>
                        <tbody>

                        @if(isset($items))
                            @foreach($items as $item)

                            @php
                            @endphp
                                <tr class="@if(\Carbon\Carbon::now()>\Carbon\Carbon::parse($item->date_to_return)) bg-odd @endif text-sm">
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->sub_book->sub_book_id}}</td>
                                    <td>
                                        <img data-toggle="tooltip" data-placement="top" title="{{$item->book->title}}"
                                             style="width: 50px" class="img-thumbnail"
                                             src="{{$item->book->cover_img()}}"/>
                                    </td>
                                    @php
                                        $name=$item->user->name;
                                        $phone = $item->user->get_phone();
                                        $email = $item->user->email;
                                        $proof = $item->user->get_proof();
                                        $academics = $item->user->get_academic_details();
                                        $short_name = $name;
                                        if(\Illuminate\Support\Str::length($name)>5){
                                           $checkifspace = explode(" ",$name);
                                           if($checkifspace){
                                               $short_name=$checkifspace[0];
                                           }
                                        }
                                    @endphp
                                    <td>
                                        <figure>
                                            <img data-toggle="tooltip" data-placement="top" title="{{$name}}"
                                                     style="width: 45px" class="img-thumbnail"
                                                     src="{{asset("uploads/".$item->user->get_user_image())}}"/>
                                            <figcaption class="">
                                                <span class="text-sm">{{$short_name}}</span><br/>
                                                <span class="badge badge-light">uid:{{$item->user_id}}</span>
                                            </figcaption>
                                        </figure>
                                        @if(!empty($email) && $email!='--')
                                            <i class="far fa-envelope" data-toggle="tooltip" data-placement="top"
                                               title="{{$email}}"></i>
                                        @endif

                                        @if(!empty($phone) && $phone!='--')
                                            <i class="fas fa-phone" data-toggle="tooltip"
                                               style="font-size: 12px;margin-left: 5px;"
                                               data-placement="top"
                                               title="{{$phone}}"></i>
                                        @endif
                                        @if(!empty($academics) && $academics!='--')
                                            <i class="fas fa-university"  data-toggle="tooltip"
                                               style="font-size: 15px;margin-left: 5px;"
                                               data-placement="top"
                                               title="{{$academics}}"></i>
                                        @endif
                                        @if(!empty($proof) && $proof!='--' && !empty($util::fileChecker(public_path("uploads"),$proof,"")))
                                            <a target="_blank" href="{{asset("uploads/".$proof)}}">
                                                <i class="fas fa-paperclip mouse" data-toggle="tooltip"
                                                   style="font-size: 12px;margin-left: 5px;"
                                                   data-placement="top"
                                                   title="Proof"></i></a>

                                        @endif

                                    </td>
                                    {{--                                    <td>{{$item->book->title}}</td>--}}
                                    <td class="show_g_dt">{{Util::goodDate($item->date_borrowed)}}</td>
                                    <td class="show_g_dt">{{Util::goodDate($item->date_to_return)}}</td>
                                    <td class="show_g_dt"

                                    >{!! $item->date_returned ? Util::goodDate($item->date_returned): "<input type='text' wire:ignore class='form-control date_picker'/>" !!}</td>
                                    @php
                                        $date_to_return = Illuminate\Support\Carbon::parse($item->date_to_return);
                                        $now = Illuminate\Support\Carbon::now();
                                        $lv_delayed_days = 0;
                                        $lv_fine = 0;
                                        if(!isset($item->date_returned))
                                        {
                                            $this->notifcreator($date_to_return->diffInDays($now) + 1,$item->user_id,$item->sub_book->sub_book_id);
                                            if($now>$date_to_return){ // we are late
                                                $lv_delayed_days = $date_to_return->diffInDays($now);;
                                                $lv_fine = $lv_delayed_days*$common::getSiteSettings("fine_per_day",1);
                                            }
                                         }
                                    @endphp
                                    <td>{{is_null($item->date_returned) ? $lv_delayed_days : ($item->delayed_day ?? 0)}}</td>
                                    <td>{!! is_null($item->date_returned) ? $now>$date_to_return ? "MUST RETURN NOW" : $now->diffInDays($date_to_return) + 1 : "Returned" !!}</td>
                                    <td>{!! is_null($item->date_returned) ? ("<textarea id='remark_".$item->id."' rows=3 wire:ignore class='form-control remark_obj text-sm'>".$util::getIfNotEmpty($item->remark)."</textarea>"):
                                ($util::getIfNotEmpty($item->remark) ?? "--") !!}</td>
                                    <td>


                                    <figure>
                                            <img data-toggle="tooltip" data-placement="top" title="{{ $item->issued_by_person->name}}"
                                                     style="width: 45px" class="img-thumbnail"
                                                     src="{{asset("uploads/".\App\Models\User::get_user_photo($item->issued_by_person->id))}}"/>
                                            <figcaption class="">
                                                <span class="text-sm">{{ $item->issued_by_person->name}}</span><br/>
                                                <span class="badge badge-light">uid:{{ $item->issued_by_person->id}}</span>
                                            </figcaption>
                                        </figure>

                                    </td>
                                    <td>{{Util::goodDate($item->created_at)}}</td>
                                    <td>
                                        @if(!$item->date_returned)
                                            <button type="button"
                                                    onclick="flush_data({{$item->id}});lv_confirm_then_submit(this,'{{__("common.cnf_receive_of_book")}}','receiveBook','{\'id\':{{$item->id}}}');"
                                                    class="btn btn-xs btn-dark mb-1">{{__("common.receive_book")}}
                                            </button>
                                            <button type="button"
                                                    onclick="lv_confirm_then_submit(this,'{{__("common.cnf_mark_lost")}}','markLostBook','{\'id\':{{$item->sub_book_id}},\'uid\':{{$item->user_id}}}')"
                                                    class="btn btn-xs btn-dark mb-1">{{__("common.mark_lost")}}
                                            </button>
                                            @if($item->payment && $item->payment->payment_status)
                                                <span class="badge badge-primary">{{__("common.paid")}}</span>
                                                <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top"
                                                   title="{{__("common.paid_msg_for_admins",["inv_id"=>$item->payment->invoice_no,
                                            "amt_paid"=>$item->payment->payed_amount,"paid_date"=>$util::goodDate($item->payment->created_at),
                                            "payer_email"=>$item->payment->payer_email,"symbol"=>$common::getSiteSettings("currency_symbol")])}}"></i>
                                            @endif
                                            @if($item->payment && $item->payment->refund_status)
                                                <span class="badge badge-warning">{{__("common.refund")}}</span>
                                                <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top"
                                                   title="{{__("common.refnd_msg_for_admins",["inv_id"=>$item->payment->refund_id,
                                            "amt_rfnd"=>$item->payment->refund_amount,"status"=>$item->payment->refund_status,"curr"=>$common::getSiteSettings("currency_symbol")
                                            ])}}"></i>
                                            @endif
                                            <button type="button"
                                                    onclick="lv_confirm_then_submit(this,'{{__("commonv2.cnf_mark_damage")}}','markDamageBook',
                                                        '{\'id\':{{$item->sub_book_id}},\'uid\':{{$item->user_id}}}')"
                                                    class="btn btn-xs btn-dark mb-1">{{__("commonv2.cnf_damage")}}
                                            </button>
                                        @else
                                            <span class="badge badge-success">{{__("common.received")}}</span><br/>
                                            @if($item->sub_book->lost_by==$item->user_id)
                                                <span class="badge badge-danger">{{__("common.losted")}}</span>
                                            @endif
                                            @if($item->sub_book->damaged_by==$item->user_id)
                                                <span data-toggle="tooltip" data-placement="top"
                                                      title="{{__("commonv2.damaged")}}" class="badge badge-danger"><i
                                                        class="fas fa-faucet"></i></span>
                                            @endif
                                        @endif
                                    </td>

                                </tr>

                            @endforeach
                            @if(!$items->count())
                                <tr>
                                    <td colspan="14">
                                        <div class="alert alert-dark">{{__("common.no_book_borrowed_yet")}}</div>
                                    </td>
                                </tr>
                            @endif
                        @endif
                        </tbody>
                    </table>
                    @if(isset($items) && $items->count())
                        {{$items->links()}}
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>






     <div class="card">
    <div class="card-header blue">
                <span class="card-header-title">List of unreturned book</span>
              </div>
        <div class="card-body yellow">

            <div class="form-row">
                <input type="hidden" id="return_date" value="">
                <input type="hidden" id="fine" value="">
                <input type="hidden" id="remark" value="">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                        <tr>
                           <th>{{__("common.bo_id")}}</th>
                            <th>Accession</th>
                            <th>{!!__("common.book_img")!!}</th>
                            <th style="width: 65px;">{!!__("common.user_img")!!}</th>
                            {{--                            <th>{{__("common.title")}}</th>--}}
                            <th>{!!__("common.short_issued_date") !!}</th>
                            <th>{!!__("common.date_to_return")!!}</th>
                            <th>{!!__("common.date_returned")!!}</th>
                            <th>Day Late
                                <i class="far fa-eye mouse" wire:click="$set('dd_filter', true)"></i>
                            </th>
                            <th style="width: 120px;">Day Left</th>
                            <th style="width: 120px;">{{__("common.remark")}}</th>
                            <th>{{__("common.issued_by")}}</th>
                            <th>{!!__("common.pl_created_on")!!}</th>
                            <th style="width:120px">{{__("common.action")}}</th>
                        </tr>
                        </thead>
                        <tbody>

                        @if(isset($items))
                            @foreach($items as $item)

                            @php
                            @endphp
                                <tr class="@if(\Carbon\Carbon::now()>\Carbon\Carbon::parse($item->date_to_return)) bg-odd @endif text-sm">
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->sub_book->sub_book_id}}</td>
                                    <td>
                                        <img data-toggle="tooltip" data-placement="top" title="{{$item->book->title}}"
                                             style="width: 50px" class="img-thumbnail"
                                             src="{{$item->book->cover_img()}}"/>
                                    </td>
                                    @php
                                        $name=$item->user->name;
                                        $phone = $item->user->get_phone();
                                        $email = $item->user->email;
                                        $proof = $item->user->get_proof();
                                        $academics = $item->user->get_academic_details();
                                        $short_name = $name;
                                        if(\Illuminate\Support\Str::length($name)>5){
                                           $checkifspace = explode(" ",$name);
                                           if($checkifspace){
                                               $short_name=$checkifspace[0];
                                           }
                                        }
                                    @endphp
                                    <td>
                                        <figure>
                                            <img data-toggle="tooltip" data-placement="top" title="{{$name}}"
                                                     style="width: 45px" class="img-thumbnail"
                                                     src="{{asset("uploads/".$item->user->get_user_image())}}"/>
                                            <figcaption class="">
                                                <span class="text-sm">{{$short_name}}</span><br/>
                                                <span class="badge badge-light">uid:{{$item->user_id}}</span>
                                            </figcaption>
                                        </figure>
                                        @if(!empty($email) && $email!='--')
                                            <i class="far fa-envelope" data-toggle="tooltip" data-placement="top"
                                               title="{{$email}}"></i>
                                        @endif

                                        @if(!empty($phone) && $phone!='--')
                                            <i class="fas fa-phone" data-toggle="tooltip"
                                               style="font-size: 12px;margin-left: 5px;"
                                               data-placement="top"
                                               title="{{$phone}}"></i>
                                        @endif
                                        @if(!empty($academics) && $academics!='--')
                                            <i class="fas fa-university"  data-toggle="tooltip"
                                               style="font-size: 15px;margin-left: 5px;"
                                               data-placement="top"
                                               title="{{$academics}}"></i>
                                        @endif
                                        @if(!empty($proof) && $proof!='--' && !empty($util::fileChecker(public_path("uploads"),$proof,"")))
                                            <a target="_blank" href="{{asset("uploads/".$proof)}}">
                                                <i class="fas fa-paperclip mouse" data-toggle="tooltip"
                                                   style="font-size: 12px;margin-left: 5px;"
                                                   data-placement="top"
                                                   title="Proof"></i></a>

                                        @endif

                                    </td>
                                    {{--                                    <td>{{$item->book->title}}</td>--}}
                                    <td class="show_g_dt">{{Util::goodDate($item->date_borrowed)}}</td>
                                    <td class="show_g_dt">{{Util::goodDate($item->date_to_return)}}</td>
                                    <td class="show_g_dt"

                                    >{!! $item->date_returned ? Util::goodDate($item->date_returned): "<input type='text' wire:ignore class='form-control date_picker'/>" !!}</td>
                                    @php
                                        $date_to_return = Illuminate\Support\Carbon::parse($item->date_to_return);
                                        $now = Illuminate\Support\Carbon::now();
                                        $lv_delayed_days = 0;
                                        $lv_fine = 0;
                                        if(!isset($item->date_returned))
                                        {

                                            if($now>$date_to_return){ // we are late
                                                $lv_delayed_days = $date_to_return->diffInDays($now);;
                                                $lv_fine = $lv_delayed_days*$common::getSiteSettings("fine_per_day",1);
                                            }
                                         }
                                    @endphp
                                    <td>{{is_null($item->date_returned) ? $lv_delayed_days : ($item->delayed_day ?? 0)}}</td>
                                    <td>{!! is_null($item->date_returned) ? $now>$date_to_return ? "MUST RETURN NOW" : $now->diffInDays($date_to_return) + 1 : "Returned" !!}</td>
                                    <td>{!! is_null($item->date_returned) ? ("<textarea id='remark_".$item->id."' rows=3 wire:ignore class='form-control remark_obj text-sm'>".$util::getIfNotEmpty($item->remark)."</textarea>"):
                                ($util::getIfNotEmpty($item->remark) ?? "--") !!}</td>
                                    <td>


                                    <figure>
                                            <img data-toggle="tooltip" data-placement="top" title="{{ $item->issued_by_person->name}}"
                                                     style="width: 45px" class="img-thumbnail"
                                                     src="{{asset("uploads/".\App\Models\User::get_user_photo($item->issued_by_person->id))}}"/>
                                            <figcaption class="">
                                                <span class="text-sm">{{ $item->issued_by_person->name}}</span><br/>
                                                <span class="badge badge-light">uid:{{ $item->issued_by_person->id}}</span>
                                            </figcaption>
                                        </figure>

                                    </td>
                                    <td>{{Util::goodDate($item->created_at)}}</td>
                                    <td>
                                        @if(!$item->date_returned)
                                            <button type="button"
                                                    onclick="flush_data({{$item->id}});lv_confirm_then_submit(this,'{{__("common.cnf_receive_of_book")}}','receiveBook','{\'id\':{{$item->id}}}');"
                                                    class="btn btn-xs btn-dark mb-1">{{__("common.receive_book")}}
                                            </button>
                                            <button type="button"
                                                    onclick="lv_confirm_then_submit(this,'{{__("common.cnf_mark_lost")}}','markLostBook','{\'id\':{{$item->sub_book_id}},\'uid\':{{$item->user_id}}}')"
                                                    class="btn btn-xs btn-dark mb-1">{{__("common.mark_lost")}}
                                            </button>
                                            @if($item->payment && $item->payment->payment_status)
                                                <span class="badge badge-primary">{{__("common.paid")}}</span>
                                                <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top"
                                                   title="{{__("common.paid_msg_for_admins",["inv_id"=>$item->payment->invoice_no,
                                            "amt_paid"=>$item->payment->payed_amount,"paid_date"=>$util::goodDate($item->payment->created_at),
                                            "payer_email"=>$item->payment->payer_email,"symbol"=>$common::getSiteSettings("currency_symbol")])}}"></i>
                                            @endif
                                            @if($item->payment && $item->payment->refund_status)
                                                <span class="badge badge-warning">{{__("common.refund")}}</span>
                                                <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top"
                                                   title="{{__("common.refnd_msg_for_admins",["inv_id"=>$item->payment->refund_id,
                                            "amt_rfnd"=>$item->payment->refund_amount,"status"=>$item->payment->refund_status,"curr"=>$common::getSiteSettings("currency_symbol")
                                            ])}}"></i>
                                            @endif
                                            <button type="button"
                                                    onclick="lv_confirm_then_submit(this,'{{__("commonv2.cnf_mark_damage")}}','markDamageBook',
                                                        '{\'id\':{{$item->sub_book_id}},\'uid\':{{$item->user_id}}}')"
                                                    class="btn btn-xs btn-dark mb-1">{{__("commonv2.cnf_damage")}}
                                            </button>
                                        @else
                                            <span class="badge badge-success">{{__("common.received")}}</span><br/>
                                            @if($item->sub_book->lost_by==$item->user_id)
                                                <span class="badge badge-danger">{{__("common.losted")}}</span>
                                            @endif
                                            @if($item->sub_book->damaged_by==$item->user_id)
                                                <span data-toggle="tooltip" data-placement="top"
                                                      title="{{__("commonv2.damaged")}}" class="badge badge-danger"><i
                                                        class="fas fa-faucet"></i></span>
                                            @endif
                                        @endif
                                    </td>

                                </tr>

                            @endforeach
                            @if(!$items->count())
                                <tr>
                                    <td colspan="14">
                                        <div class="alert alert-dark">{{__("common.no_book_borrowed_yet")}}</div>
                                    </td>
                                </tr>
                            @endif
                        @endif
                        </tbody>
                    </table>
                    @if(isset($items) && $items->count())
                        {{$items->links()}}
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .btn-group-xs > .btn, .btn-xs {
            padding: .45rem .4rem;
            font-size: .875rem;
            line-height: .5;
            border-radius: .2rem;
        }

        @media screen and (max-width: 480px) {
            .text-sm .btn {
                line-height: 12px;
            }
        }


    </style>
</div>


