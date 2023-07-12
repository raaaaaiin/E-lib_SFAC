@php
    /* @var \App\Facades\Util $util */
    /* @var \App\Facades\Common $common */
@endphp
@extends("common.master")
@section("css_loc")
    <link href="{{asset('front/css/bootstrap.min.css')}}" rel="stylesheet" id="bootstrap-css">
    <style>
        body {
            background-color: #d7d6d3;
            font-family: 'verdana';
        }

        .id-card-holder {
            width: 300px;
            padding: 4px;
            margin: 0 auto;
            background-color: #1f1f1f;
            border-radius: 5px;
            position: relative;
        }

        .id-card-holder:after {
            content: '';
            width: 7px;
            display: block;
            background-color: #0a0a0a;
            height: 100px;
            position: absolute;
            top: 105px;
            border-radius: 0 5px 5px 0;
        }

        .id-card-holder:before {
            content: '';
            width: 7px;
            display: block;
            background-color: #0a0a0a;
            height: 100px;
            position: absolute;
            top: 105px;
            left: 290px;
            border-radius: 5px 0 0 5px;
        }

        .id-card {

            background-color: #fff;
            padding: 10px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 1.5px 0px #b9b9b9;
        }

        .id-card img {
            margin: 0 auto;
        }

        .header img {
            width: 150px;
            margin-top: 15px;
        }

        .photo img {
            width: 80px;
            margin-top: 15px;
        }

        h2 {
            font-size: 20px;
            margin: 5px 0;
        }

        h3 {
            font-size: 12px;
            margin: 2.5px 0;
            font-weight: 300;
        }

        .userid {

        }

        p {
            margin: 6px;
            color: black;
            font-family: monospace;
            font-size: 11px;
        }

        strong {
            color: black;
            font-weight: bold;
        }

        .url_holder {
            font-size: 14px;
            font-family: monospace;
            font-style: italic;
            font-weight: bold;
        }

        .return_msg {
            font-size: 10px;
            text-align: left;
            margin-top: 5%;
            font-weight: bold;
            color: red;
        }

        @media print {

            .row {
                display: block !important;
            }
            .dashbtn{display: none!important;}
            .col-md-6 {
                float: left !important;
            }

            body {
                font-family: 'verdana';
                font-size: 18px;
            }

            .id-card-holder {
                width: 400px;
                padding: 4px;
                margin: 0 auto;
                border: 3px solid;
            }


            .id-card {
                background-color: #fff;
                padding: 10px;
                text-align: center;
            }

            .id-card img {
                margin: 0 auto;
            }

            .header img {
                width: 200px;
                margin-top: 15px;
            }

            .photo img {
                width: 100px;
                margin-top: 15px;
            }

            h2 {
                font-size: 25px;
                margin: 5px 0;
            }

            h3 {
                font-size: 19px;
                margin: 2.5px 0;
                font-weight: 300;
            }

            .userid {

            }

            p {
                margin: 6px;
                color: black;
                font-family: monospace;
                font-size: 18px;
            }

            strong {
                color: black;
                font-weight: bold;
            }

            .url_holder {
                font-size: 19px;
                font-family: monospace;
                font-style: italic;
                font-weight: bold;
            }

            .return_msg {
                font-size: 15px;
                text-align: left;
                margin-top: 5%;
                font-weight: bold;
                color: red;
            }
        }
    </style>
@endsection
@section("title") {{__("commonv2.print_id_id_cards")}} @endsection
@section("content")
    {{--    {!! $data ?? "Nothing can be found here.<a href='".config('app.APP_URL')."'>Go to HomePage</a>" !!}--}}
    <div class="container-fluid">

        <div class="row">
            {!! $raw_html ?? __('commonv2.nothing_can_be_found_here')." <a href='".config('app.APP_URL')."'>".__('common.homepage')."</a>" !!}
        </div>
    </div>
@endsection
@section("js_loc")
<script>
alert("Im alive!");
</script>
@endsection
