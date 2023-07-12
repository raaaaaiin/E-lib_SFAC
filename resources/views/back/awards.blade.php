@extends("back.common.master")
@section("page_name")
    {{__("common.notice_mng")}}
@endsection
@section("content")
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @livewire("awards")
                </div>
            </div>
        </div>
    </div>
@endsection
@section("css_loc")
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/notice.css')}}">
@endsection
@section("js_loc")
    <script type="text/javascript" src="{{asset("js/select2.min.js")}}"></script>
    <script src="{{asset('js/notice.js')}}"></script>
@endsection
