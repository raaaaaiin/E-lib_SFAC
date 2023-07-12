<div class="w-100">
    @php
        /* @var \App\Facades\Util $util */
        /* @var \App\Facades\Common $common */
    @endphp
    <div class="form-row">
        <input type="hidden" id="return_date" value="">
        <input type="hidden" id="fine" value="">
        <input type="hidden" id="remark" value="">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm">
                <thead>
                <tr>
                    <td>{{__("common.bo_id")}}</td>
                    <td>{!!__("common.bc").CForm::generateInfoToolTip(__('common.pl_bc'),'','left')!!}</td>
                    <td>{!!__("common.book_img")!!}</td>
                    <td>{!!__("common.user_img")!!}</td>
                    <td>{{__("common.title")}}</td>
                    <td>{!!__("common.short_issued_date").CForm::generateInfoToolTip(__('common.pl_issued_date'),'','left') !!}</td>
                    <td>{!!__("common.date_to_return").CForm::generateInfoToolTip(__('common.pl_dtr'),'','left')!!}</td>
                    <td>{!!__("common.date_returned").CForm::generateInfoToolTip(__('common.pl_dr'),'','left')!!}</td>
                    <td>{!!__("common.dd").CForm::generateInfoToolTip(__('common.pl_dd'),'','left')!!}</td>
                    <td>{{__("common.fine")}}</td>
                    <td>{{__("common.issued_by")}}</td>
                    <td>{{__("common.action")}}</td>
                </tr>
                </thead>
                <tbody>
                @if(isset($items))
                    @foreach($items as $item)
                        <tr class="@if(\Carbon\Carbon::now()>\Carbon\Carbon::parse($item->date_to_return)) bg-odd @endif text-sm">
                            <td>{{$item->id}}</td>
                            <td>{{$item->sub_book->sub_book_id}}</td>
                            <td>
                                <img style="width: 50px" class="img-thumbnail" src="{{$item->book->cover_img()}}"/>
                            </td>
                            @php
                                $name=$item->user->name;
                                $short_name = $name;
                                if(\Illuminate\Support\Str::length($name)>5){
                                   $checkifspace = explode(" ",$name);
                                   if($checkifspace){
                                       $short_name=$checkifspace[0];
                                   }
                                }
                            @endphp
                            <td>
                                <figure><img data-toggle="tooltip" data-placement="top" title="{{$name}}"
                                             style="width: 25px" class="img-thumbnail"
                                             src="{{asset("uploads/".$item->user->get_user_image())}}"/>
                                    <figcaption class="">
                                        <span class="text-sm">{{$short_name}}</span><br/>
                                        <span class="badge badge-light">uid:{{$item->user_id}}</span>
                                    </figcaption>
                                </figure>
                            </td>
                            <td>{{$item->book->title}}</td>
                            <td>{{Util::goodDate($item->date_borrowed)}}</td>
                            <td>{{Util::goodDate($item->date_to_return)}}</td>
                            <td>{!! $item->date_returned ? Util::goodDate($item->date_returned): "--" !!}</td>
                            @php
                                $date_to_return = Illuminate\Support\Carbon::parse($item->date_to_return);
                                $now = Illuminate\Support\Carbon::now();
                                $lv_delayed_days = 0;
                                $lv_fine = 0;
                                if(!isset($item->date_returned)){
                                    if($now>$date_to_return){ // we are late
                                        $lv_delayed_days = $date_to_return->diffInDays($now);
                                        $lv_fine = $lv_delayed_days*$common::getSiteSettings("fine_per_day",1);
                                    }
                                 }
                            @endphp
                            <td>{{is_null($item->date_returned) ? $lv_delayed_days : ($item->delayed_day ?? 0)}}</td>
                            <td>{!! is_null($item->date_returned) && $item->payment && !$item->payment->payment_status ? $common::getSiteSettings("currency_symbol").' '.$lv_fine :($item->fine ? $common::getSiteSettings("currency_symbol").' '.$item->fine : "--") !!}</td>


                            <td>{!! '<i class="far fa-user-circle" data-toggle="tooltip" data-placement="left" title="'.($item->issued_by_person ? $item->issued_by_person->name : "--").'"></i>' !!}</td>

                            <td>
                                @if(!$item->date_returned && $lv_delayed_days > 0 && $common::getSiteSettings("enable_PAYPAL_SANDBOX",false))
                                    {{-- Payment Mode --}}
                                    @if(!$item->payment)
                                        <button type="button"
                                                onclick="lv_confirm_then_submit(this,'{{__("common.initiate_the_fine_payment_transaction")}}',
                                                    'startPayment','{\'id\':{{$item->user_id}},\'borr_id\':{{$item->id}},\'b_id\':{{$item->book->id}},\'sb_id\':\'{{$item->sub_book->sub_book_id}}\',\'fine_amt\':{{$lv_fine}}}');"
                                                class="btn btn-xs btn-dark mb-1">{{__("common.pay_fine")}}
                                        </button>
                                    @else
                                        @if($item->payment->payment_status)
                                            <span class="badge badge-primary">{{__("common.paid")}}</span>
                                            <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top"
                                               title="{{__('common.lp_paid_msg')}}"></i>
                                        @endif
                                    @endif
                                @else
                                    @if($item->date_returned)
                                    <span class="badge badge-success">{{__("common.received")}}</span><br/>
                                    @else
                                    <span class="badge badge-warning">{{__("common.reading_days")}}</span><br/>
                                    @endif
                                    @if($item->sub_book->lost_by==$item->user_id)
                                        <span class="badge badge-danger">{{__("common.losted")}}</span>
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
        </div>
        @if(isset($items) && $items->count())
            {{$items->links()}}
        @endif
    </div>
</div>
