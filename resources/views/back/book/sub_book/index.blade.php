@extends("back.common.master")
@section("page_name") {{__("common.view_all_books")}} @endsection
@section("content")
{{--    <div class="card">--}}
{{--        <div class="card-body yellow">--}}
{{--            <div class="mb-10 w-100">--}}
{{--                @include("common.messages")--}}
{{--            </div>--}}
{{--            @livewire("sub-book")--}}
{{--        </div>--}}
{{--    </div>--}}
    @livewire("sub-book")
@endsection
@section("css_loc")
    <style>

    </style>
@endsection

@section("js_loc")
    <script>
        $(document).ready(function () {
            flush_data = function ($id) {
                let element = $("#cat_" + $id);
                if (element.length) {
                    window.livewire.emit("data_manager", {"cat_detail": element.val()});
                }

            }
        });
    </script>
@endsection
