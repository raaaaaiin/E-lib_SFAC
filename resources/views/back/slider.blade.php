@extends("back.common.master")
@section("page_name")
    {{__("common.slider_management")}}
@endsection
@section("content")
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @livewire("slider")
                </div>
            </div>
        </div>
    </div>
@endsection

