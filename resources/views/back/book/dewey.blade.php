@extends("back.common.master")
@section("page_name") {{__("commonv2.dewey_classification")}} @endsection
@section("content")
    @livewire("dewey-decimal")
@endsection
@section("css_loc")
    <style>
        .parent {
            background-color: #ffffff !important;
            color: black !important;
        }
        .sub_parent{

        }
    </style>
@endsection
