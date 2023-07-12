@extends("back.common.master")
@section("page_name")
    {{__("common.user_management")}}
@endsection
@section("content")
    <div class="content">
        <div class="container-fluid">
            @if(isset($page_mode))
                @livewire("user-mng",["page_mode"=>$page_mode,"course_year"=>$course_year,"course_id"=>$course_id])
            @else
                @livewire("user-mng");
            @endif
        </div>
    </div>
@endsection
@section("js_loc")
    <script>
        $(document).ready(function () {
            confirm_and_submit = function ($this, $action) {
                lv_confirm_then_submit($this, "{{__("common.are_you_sure_abt_this_act")}}", $action);
            };
        });
    </script>
@endsection
