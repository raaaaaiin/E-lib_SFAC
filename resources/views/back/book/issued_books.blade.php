@extends("back.common.master")
@section("page_name") {{__("common.issued_book_list")}} @endsection
@section("content")
    @if(isset($search))
        @livewire("issued-books",["search_keyword"=>$search])
    @else
        @livewire("issued-books")
    @endif
@endsection
@section("css_loc")
    <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
@endsection
@section("js_loc")
<script src="{{asset('front/js/slick.min.js')}}"></script>
<script src="{{asset('front/js/jquery.magnific-popup.min.js')}}"></script>

<script src="{{asset('front/js/imagesloaded.pkgd.min.js')}}"></script>
<script src="{{asset('front/js/isotope.pkgd.min.js')}}"></script>

    <script src="{{asset('js/book_issued.js')}}"></script>
@endsection
