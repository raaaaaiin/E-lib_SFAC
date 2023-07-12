<div>
    @php
        /* @var \App\Facades\Util $util */
        /* @var \App\Facades\Common $common */
    @endphp
    <div class="card">
        <div class="card-body yellow">
            @can("mng-transaction")
                <div class="row mb-10">
                    <div class="col-12">
                        {!! CForm::inputGroupHeader(__("common.advanced_filter")) !!}
                        <input type="text" wire:model="search_keyword" class="form-control">
                        <div class="input-group-append">

                            <select class="form-control" wire:model="sel_payment_type">
                                <option value="">{{__("common.select")}}</option>
                                <option value="refund">{{__("common.refund")}}</option>
                                <option value="all">{{__("common.all_trans")}}</option>
                            </select>
                            <select class="form-control" wire:model="sel_working_year">
                                <option value="">{{__("common.select")}}</option>
                                @foreach($common::getAllYears() as $year)
                                    <option value="{{$year->id}}">{{$year->year_from}}</option>
                                @endforeach
                            </select>
                        </div>
                        {!! CForm::inputGroupFooter() !!}
                    </div>
                </div>
            @endcan
            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead>
                    <tr class="text-sm">
                        <th scope="col">#</th>

                        <th scope="col">{{__("common.inv_no")}}</th>
                        <th scope="col"
                            style="width: 60px;">{!!__("common.uid").CForm::generateInfoToolTip(__("common.user_id"),'','left')!!}</th>
                        <th scope="col">{{__("common.name")}}</th>
                        <th scope="col">{{__("common.course")}}</th>
                        <th scope="col">{{__("common.year")}}</th>
                        <th scope="col">{{__("common.paid_for")}}</th>
                        @can("mng-transaction")
                            <th scope="col">{{__("common.currency")}}</th>
                            <th scope="col">{!!__("common.fee_payer_id").CForm::generateInfoToolTip(__("common.pl_payer_id"),'','left')!!}</th>
                            <th scope="col">{!!__("common.fee_paid_by_email").CForm::generateInfoToolTip(__("common.pl_fee_paid_by_email"),'','left')!!}</th>
                            <th scope="col">{!!__("common.pl_ref_url").CForm::generateInfoToolTip(__("common.ref_url"),'','left')!!}</th>
                            <th scope="col">{{__("common.phone")}}</th>
                            <th scope="col">{!!__("common.pl_payer_name").CForm::generateInfoToolTip(__("common.payer_name"),'','left')!!}</th>
                            <th scope="col">{!!__("common.pay_id").CForm::generateInfoToolTip(__("common.pl_payer_id"),'','left')!!}</th>
                        @endcan
                        <th scope="col"
                            style="width: 103px;">{!!__("common.pl_paid_amount").CForm::generateInfoToolTip(__("common.paid_amount"),'','left')!!}</th>
                        <th scope="col"
                            style="width: 94px;">{!!__("common.pl_pay_status").CForm::generateInfoToolTip(__("common.pay_status"),'','left')!!}</th>


                        <th scope="col"
                            style="width: 81px;">{!!__("common.pl_working_year").CForm::generateInfoToolTip(__("common.working_year"),'','left')!!}</th>
                        <th scope="col">{{__("common.date")}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($receipts) && $receipts->count()>0)
                        @foreach($receipts as $receipt)
                            <tr>
                                <td>{{$receipt->id}}</td>
                                <td class="text-sm" style="width: 85px;"><span
                                        class="p_email_wrap">{{$receipt->invoice_no}}</span>
                                    @if(isset($receipt->refund_amount) && $receipt->refund_amount)
                                        <span data-toggle="tooltip" data-placement="top" title="{{__("common.r_id")}}"
                                              class="badge badge-warning">{{$receipt->refund_id}}</span>
                                        <span data-toggle="tooltip" data-placement="top"
                                              title="{{__("common.r_status")}}"
                                              class="badge badge-success">{{Str::title($receipt->refund_status)}}</span>
                                        <span data-toggle="tooltip" data-placement="top" title="{{__("common.r_amt")}}"
                                              class="badge badge-success">{{$common::getSiteSettings("currency_symbol")}}{{$receipt->refund_amount}}</span>
                                    @endif
                                </td>
                                <td class="text-sm">
                                    {{$receipt->uid?$receipt->uid:"N/A"}}
                                    @can("mng-transaction")
                                        {!! CForm::generateInfoToolTip(__('common.tp_assign_trans')) !!}
                                        <input type="text" class="form-control" id="assign_{{$receipt->id}}">
                                        <button class="btn btn-dark btn-xs"
                                                onclick="flush_before({{$receipt->id}});lv_confirm_then_submit(this,'{{__("common.cnf_are_you_sure")}}','assignTrans','{\'id\':{{$receipt->id}}}')"
                                                type="button"
                                        >{{__("common.assign")}}</button>

                                    @endcan
                                </td>
                                <td class="text-sm">{{$receipt->uid?\App\Models\User::get_user_name($receipt->uid):"N/A"}}</td>
                                <td>{{$receipt->course_id ? $common::getCourseName($receipt->course_id) :"N/A"}}</td>
                                <td>{{$receipt->course_year_id ? $common::getCourseYearName($receipt->course_year_id):"N/A"}}</td>

                                <td class="text-sm"><span
                                        class="badge badge-dark w-100">{{__("common.bid")}}</span>{{$receipt->borrowed->sub_book->sub_book_id}}
                                    <span
                                        class="badge badge-dark w-100">{{__("common.book_title")}}</span>{{$receipt->borrowed->book->title}}
                                </td>
                                @can("mng-transaction")
                                    <td>{{$receipt->currency}}</td>
                                    <td>{{$receipt->payer_id}}</td>
                                    <td class="text-sm"><span class="p_email_wrap">{{$receipt->payer_email}}</span></td>
                                    <td class="text-sm">
                                        @if($receipt->refund_status=="completed")
                                            <span class="badge badge-warning">{{__("common.refunded")}}</span>
                                            <span class="p_email_wrap p_refund_wrap">{{$receipt->refund_id}} </span>
                                        @else
                                            <input class="form-control" data-toggle="tooltip" data-placement="left"
                                                   title="{{__("common.pl_amount_to_refund")}}" type="text"
                                                   id="refund_{{$receipt->id}}">
                                            <button class="btn btn-danger btn-xs"
                                                    onclick="start_refund('{{route('gateway.refund_fine')}}?payment_id={{$receipt->id}}',{{$receipt->id}});">{{__("common.refund")}}</button>
                                        @endif
                                    </td>
                                    <td>{{$receipt->payer_phone}}</td>
                                    <td>{{$receipt->payer_name}}</td>
                                    <td class="text-sm"><span class="p_email_wrap">{{$receipt->payment_id}}</span></td>
                                @endcan
                                <td><span id="payed_amt_{{$receipt->id}}">{{$receipt->payed_amount}}</span></td>
                                <td>{{$receipt->payment_status}}</td>


                                <td>{{$common::getYearName($common::getWorkingYear())}}</td>
                                <td>{{$util::goodDate($receipt->created_at)}}</td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="100">
                                <div class="alert alert-dark">{{__("common.no_data_exist")}}</div>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            {{$receipts->links()}}
        </div>
    </div>
</div>
