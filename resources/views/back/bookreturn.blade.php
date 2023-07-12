@extends("back.common.master")
@section("page_name")
    {{__("common.my_profile")}}
@endsection
@section("css_loc")
   <link rel="stylesheet" href="{{asset('css/profile.css')}}">
@endsection
@section("content")
    @livewire("bookreturn",['v_id' => $v_id])
@endsection

@section("js_loc")

@endsection



