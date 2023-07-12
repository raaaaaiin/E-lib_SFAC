@php
    /* @var \App\Facades\Util $util */
    /* @var \App\Facades\Common $common */
@endphp
@extends("common.master")
@section("css_loc")
    <link href="{{asset('front/css/bootstrap.min.css')}}" rel="stylesheet" id="bootstrap-css">

    <style>

        .dashbtn {
            margin-bottom: 3%;
        }

        body.print * {
            transition: none !important;
        }
        .show_print{display: none;}
        @media print {

            .row {
                display: block !important;
            }

            .dashbtn {
                display: none !important;
            }

            .col-md-3 {
                float: left !important;
                margin-right: 50px !important;
                margin-bottom: 50px !important;
            }

            .dashbtn {
                margin-bottom: 3%;
            }

            body {
                font-family: 'verdana';
                font-size: 18px;
                color: black !important;
                -webkit-print-color-adjust: exact;
            }

            .bar_holder {
                display: block !important;
                -webkit-print-color-adjust: exact;
            }

            .bad_holder div > * {
                -webkit-print-color-adjust: exact !important;
                height: 200px !important;
            }
            .hidden_print{
                display: none;
            }
            .show_print{
                display: block;
            }


        }
    </style>
@endsection
@section("title") {{__("commonv2.print_id_id_cards")}} @endsection
@section("content")
    {{--    {!! $data ?? "Nothing can be found here.<a href='".config('app.APP_URL')."'>Go to HomePage</a>" !!}--}}
    <div class="container-fluid">
        <div class="row dashbtn">
            <div class="col"><a href="{{route('dashboard')}}" class="btn btn-dark">{{__("common.dashboard")}}</a>
            </div>
        </div>
        <div class="row">
            @if(isset($sbook_ids) && isset($generator))
                @php $sb_ids = explode(",",$sbook_ids); @endphp
                @foreach($sb_ids as $sb)
                    <div class="col-md-3 hidden_print">
                        <div class="bar_holder d-inline-block">
                            {!!  $generator->getBarcode($sb, $generator::TYPE_CODE_128,3,50) !!}
                        </div>
                        <div>{{$sb}}</div>
                    </div>
                    <div class="col-md-3 show_print">
                        <div class="bar_holder d-inline-block">
                            {!!  $generator->getBarcode($sb, $generator::TYPE_CODE_128,3,80) !!}
                        </div>
                        <div>{{$sb}}</div>
                    </div>
                @endforeach
            @else
                {!! __("commonv2.nothing_can_be_found_here") !!}
            @endif
        </div>
    </div>
@endsection
