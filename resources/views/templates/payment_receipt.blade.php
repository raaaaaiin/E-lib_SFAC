@php
    /* @var \App\Facades\Util $util */
    /* @var \App\Facades\Common $common */
@endphp
@extends("common.master")
@section("css_loc")
    <link href="{{asset('front/css/bootstrap.min.css')}}" rel="stylesheet" id="bootstrap-css">
    <script src="{{asset('front/js/bootstrap.min.js')}}"></script>
@endsection
@section("title") {{isset($message) ? $message.__("common.late_fine_receipt"):__("common.late_fine_receipt")}} @endsection
@section("content")
    <style>
        .jumbotron {
            background-color: white;
            border: 1px dashed;
            font-size: 20px;
            font-family: emoji;
        }
    </style>
    @if(isset($mode) && $mode!="refund")
        <div class="container">
            <div class="row">
                @if ($order_status === "Success")

                    <div class="jumbotron text-xs-center m-auto">
                        <h3 class="display-3" style="font-size: 2.5rem;">{{__("common.pay_registerd")}}</h3>
                        <hr style="    border-top: 1px solid #130f0f;">
                        <h4> {{__("common.pl_info_payment")}} </h4>
                        <h5>{{__("common.lp_paid_msg")}}</h5>
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <tbody>
                                <tr>
                                    <td>
                                        {{__("common.inv_no")}} :
                                    </td>
                                    <td>{{$invoice_id}}</td>
                                </tr>
                                <tr>
                                    <td>
                                        {{__("common.payer_name")}} :
                                    </td>
                                    <td>
                                        {{$payer_name}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{__("common.pay_mode")}} :
                                    </td>
                                    <td>{{$payment_mode}}</td>
                                </tr>
                                <tr>
                                    <td>
                                        {{__("common.user_id")}} :
                                    </td>
                                    <td>{{$user_id}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        {{__("common.fine_amount")}} :
                                    </td>
                                    <td>{{$payed_amount}}</td>
                                </tr>
                                <tr>
                                    <td>
                                        {{__("common.fine_paid_by_email")}} :
                                    </td>
                                    <td>{{$payer_email}}</td>
                                </tr>
                                <tr>
                                    <td>
                                        {{__("common.payer_id")}} :
                                    </td>
                                    <td>{{$payer_id}}</td>
                                </tr>
                                @php $user = \App\Models\User::find($user_id);@endphp
                                @if($user)
                                    <tr>
                                        <td>
                                            {{__("common.name")}} :
                                        </td>
                                        <td>{{$user->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{__("common.course")}} :
                                        </td>
                                        <td>{{$common::getCourseName((new \App\Models\User)->get_course($user_id))}}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{__("common.course_year")}} :
                                        </td>
                                        <td>{{$common::getCourseYearName((new \App\Models\User)->get_year($user_id))}}</td>
                                    </tr>

                                    <tr>
                                        <td>
                                            {{__("common.book_name")}} :
                                        </td>
                                        <td>{{$req["book_name"]}}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td>
                                        {{__("common.curr_wrk_year")}} :
                                    </td>
                                    <td>{{\App\Models\Year::find($common::getWorkingYear())->year_from}}</td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                        <button class="btn btn-sm btn-dark mr-1"
                                onclick="window.print()">{{__("common.prnt_fee_receipt")}}</button>
                        <a class="btn btn-sm btn-primary"
                           href="{{route('dashboard')}}">{{__("common.go_to")}} {{__("common.dashboard")}}</a>

                    </div>
                @elseif ($order_status === "Aborted")
                    <div class="jumbotron text-xs-center m-auto">
                        <h1 class="">{{__("common.trans_abort")}}</h1>
                         <a class="btn btn-sm btn-primary"
                           href="{{route('dashboard')}}">{{__("common.go_to")}} {{__("common.dashboard")}}</a>
                    </div>
                @elseif ($order_status === "Failure")
                    <div class="jumbotron text-xs-center m-auto">
                        <h1 class="">{{__("common.trans_time_out")}}</h1>
                        <a class="btn btn-sm btn-primary"
                           href="{{route('dashboard')}}">{{__("common.go_to")}} {{__("common.dashboard")}}</a>
                    </div>
                @else
                    <div class="jumbotron text-xs-center m-auto">
                        <h1 class="">{{__("common.illegal_sec_data_access")}}</h1>
                        <a class="btn btn-sm btn-primary"
                           href="{{route('dashboard')}}">{{__("common.go_to")}} {{__("common.dashboard")}}</a>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="container">

            <div class="row">


                <div class="jumbotron text-xs-center m-auto">
                    <h3 class="display-3" style="font-size: 2.5rem;">{{__("common.refund")}}</h3>
                    <hr style="    border-top: 1px solid #130f0f;">
                    @if(isset($ref_status) && $ref_status=="completed")
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <tbody>
                                <tr>
                                    <td>
                                        {{__("common.inv_no")}} :
                                    </td>
                                    <td>{{$invoice_id}}</td>
                                </tr>
                                <tr>
                                    <td>
                                        {{__("common.payment_id")}} :
                                    </td>
                                    <td>{{$sale_id}}</td>
                                </tr>
                                <tr>
                                    <td>
                                        {{__("common.payment_id")}} :
                                    </td>
                                    <td>{{$parent_pay_id}}</td>
                                </tr>
                                <tr>
                                    <td>
                                        {{__("common.amt_refund")}} :
                                    </td>
                                    <td>{{$amt_refund}}</td>
                                </tr>
                                <tr>
                                    <td>
                                        {{__("common.ref_status")}} :
                                    </td>
                                    <td>{{Str::title($ref_status)}}</td>
                                </tr>
                                </tbody>
                            </table>
                            <a class="btn btn-sm btn-primary"
                               href="{{route('dashboard')}}">{{__("common.go_to")}} {{__("common.dashboard")}}</a>
                        </div>
                    @else
                        @if(isset($errorName))
                            <h4>{{$errorName}}</h4>
                        @endif
                        @if(isset($errorReason))
                            <h5>{{$errorReason}}</h5>
                        @endif
                            <a class="btn btn-sm btn-primary"
                               href="{{route('dashboard')}}">{{__("common.go_to")}} {{__("common.dashboard")}}</a>
                    @endif
                </div>
            </div>
        </div>
    @endif
@endsection




