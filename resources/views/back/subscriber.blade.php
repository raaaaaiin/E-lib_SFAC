@extends("back.common.master")
@section("page_name")
    {{__("common.subs_mng")}}
@endsection
@section("content")
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @livewire("subscriber")
                </div>
            </div>
        </div>
    </div>
@endsection
@section("css_loc")
    <link href="{{asset('css/bootstrap-toggle.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/subscriber.css')}}" rel="stylesheet">
@endsection
@section("js_loc")
    <script src="{{asset('js/bootstrap-toggle.min.js')}}"></script>
    <script src="{{asset('js/subscriber.js')}}"></script>
@endsection
