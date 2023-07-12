@extends("back.common.master")
@section("page_name")
    {{__("common.enquiry_mng")}}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header blue"><span class="card-header-title">{{__("common.all_enquiries")}}</span>
                    </div>
                    <div class="card-body yellow">
                        @livewire("enquiries")
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
