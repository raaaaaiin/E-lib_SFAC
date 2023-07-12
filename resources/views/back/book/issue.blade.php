@php
    /* @var \App\Facades\Util $util */
    /* @var \App\Facades\Common $common */
@endphp
@extends("back.common.master")
@section("page_name") {{__("common.issue_book")}} @endsection
@section("content")
    @if(isset($id))
        @livewire("issue",["book_id_to_issue"=>$id])
    @else
        @livewire("issue")
    @endif
    @include("back.common.spinner")
@endsection
@section("css_loc")
    <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('css/book_issue.css')}}">
@endsection
@section("js_loc")
<script src="{{asset('front/js/slick.min.js')}}"></script>
<script src="{{asset('front/js/jquery.magnific-popup.min.js')}}"></script>

<script src="{{asset('front/js/imagesloaded.pkgd.min.js')}}"></script>
<script src="{{asset('front/js/isotope.pkgd.min.js')}}"></script>

    <script>
        url_json_user = "{{route('json.get_user_ids')}}";
        url_book_user = "{{route('json.get_book_ids')}}";
    </script>
    <script src="{{asset('js/jquery-ui.js')}}"></script>
    <script src="{{asset('js/book_issue.js')}}"></script>
    <script>
        $(document).ready(function () {
            $("#user_autocomplete").on("change", function () {
                $(".user_history_holder").show();
                if ($(this).val().length) {
                    $("#user_history").attr("href", '{{route("indexReceiveBooks")}}?search=' + $("#user_id").val() + ",")
                } else {
                    $(".user_history_holder").hide();
                    $("#user_history").attr("href", '#');
                }
            });
            $("#book_autocomplete").on("change", function () {
                $(".book_history_holder").show();
                if ($(this).val().length) {
                    $("#book_history").attr("href", '{{route("indexReceiveBooks")}}?search=' + $("#book_span_code").text())
                } else {
                    $(".book_history_holder").hide();
                    $("#book_history").attr("href", '#');
                }
            });

            window.addEventListener('refresh_user_book_cnt', event => {
                $.ajax({
                    url: '{{route('json.get_borrowed_books_count')}}',
                    dataType: "json",
                    data: {
                        user_id: event.detail.user_id
                    },
                    success: function (data) {
                        $("#user_borrowed_cnt").text(data.borrowed);
                    }
                });
            });

        })


    </script>
@endsection
