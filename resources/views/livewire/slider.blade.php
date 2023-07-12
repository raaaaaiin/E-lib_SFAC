<div>
    @php
        /* @var \App\Facades\Util $util */
        /* @var \App\Facades\Common $common */
    @endphp
    @php $loading_target = "saveSlider,slider_image" ;@endphp
    @include("back.common.spinner")
    <div class="card  col-12">
        <div class="card-body yellow">
            @if(session()->has("form_slider") && session()->get("form_slider"))
                <div class="row">
                    <div class="col-12">
                        @include("common.messages")
                    </div>
                </div>
            @endif

            <div class="row mb-2">
                <form class="col-12 p-0" wire:submit.prevent="saveSlider" enctype="multipart/form-data">
                    @csrf
                    @if($mode=="edit")
                        <input type="hidden" wire:model="edit_id"/>
                    @endif

                    <input type="hidden" wire:model="mode"/>
                    <div class="form-row p-1">

                        <div class="col-md-6 col-12 mb-2">

                            {!! CForm::inputGroupHeader(__("common.grp_name")) !!}
                            <input type="text" class="form-control"
                                   placeholder="{{__("common.pl_grp_name")}}" wire:model.lazy="group">
                            @error('group')
                            <div
                                class="error_holder">@include('back.common.validation', ['message' =>  $message ])</div> @enderror
                            {!! CForm::inputGroupFooter() !!}

                        </div>

                        <div class="col-md-6 col-12 mb-2">

                            {!! CForm::inputGroupHeader(__("common.img")) !!}
                            <input wire:ignore type="file" class="form-control text-sm" accept=".jpg,.jpeg,.png"
                                   wire:model="slider_image">
                            @error('slider_image')
                            <div
                                class="error_holder">@include('back.common.validation', ['message' =>  $message ])</div> @enderror
                            {!! CForm::inputGroupFooter() !!}
                        </div>

                        <div class="col-md-6 col-12 mb-2">

                            {!! CForm::inputGroupHeader(__("common.sld_header")) !!}
                            <textarea class="form-control"
                                      wire:model.lazy="header"></textarea>
                            @error('header')
                            <div
                                class="error_holder">@include('back.common.validation', ['message' =>  $message ])</div> @enderror
                            {!! CForm::inputGroupFooter() !!}

                        </div>

                        <div class="col-md-6 col-12 mb-2">

                            {!! CForm::inputGroupHeader(__("common.sld_sub_header")) !!}
                            <textarea class="form-control"
                                      placeholder="{{__("common.short_desc")}}"
                                      wire:model.lazy="sub_header"></textarea>
                            @error('sub_header')
                            <div
                                class="error_holder">@include('back.common.validation', ['message' =>  $message ])</div> @enderror
                            {!! CForm::inputGroupFooter() !!}

                        </div>

                        <div class="form-group col-12">
                            <button type="submit" class="btn btn-sm btn-dark"><i
                                    class="fas fa-save mr-1"></i>{{__("common.save_slider")}}</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{__("common.grp_name")}}</th>
                            <th scope="col">{{__("common.header")}}</th>
                            <th scope="col">{{__("common.sub_header")}}</th>
                            <th scope="col">{{__("common.img")}}</th>
                            <th scope="col">{{__("common.action")}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($sliders->total())
                            @foreach($sliders as $slider)
                                <tr>
                                    <td>{{$slider->id}}</td>
                                    <td>{{$slider->group}}</td>
                                    <td>{{$slider->header ? $slider->header: "N/A"}}</td>
                                    <td>{{$slider->sub_header ? $slider->sub_header : "N/A"}}</td>
                                    <td>@if($slider->image) <img src="{{asset("uploads/".$slider->image)}}"
                                                                 class="w-75 img-thumbnail"/> @else N/A @endif</td>

                                    <td style="width: 84px;">
                                        <button type="button" wire:click="editSlider({{$slider->id}})"
                                                class="btn float-left btn-sm btn-dark action_btn">
                                            <i class="far fa-edit"></i>
                                        </button>
                                        <button
                                            onclick="lv_confirm_then_submit(this,'{{__("common.cnf_del")}}','deleteSlider','{\'id\':{{$slider->id}}}')"
                                            type="button"
                                            class="btn float-left btn-sm btn-danger action_btn">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>

                                    </td>

                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6">
                                    <div class="alert alert-dark col-12">{{__("common.no_slider_exist")}}!</div>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                {{$sliders->links()}}
            </div>
        </div>
    </div>
</div>
