@extends("back.common.master")
@section("page_name")
    {{__("common.lng_translations")}}
@endsection
@section("content")
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @livewire("language-translation")
                </div>
            </div>
        </div>
    </div>
@endsection
@section("css_loc")
    <link rel="stylesheet" href="{{asset('css/lang.css')}}">
@endsection
@section("js_loc")
    <script src="{{asset('js/lang.js')}}"></script>
@endsection
