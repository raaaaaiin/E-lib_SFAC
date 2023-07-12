<div class="container">
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    {{--    @include("back.common.spinner")--}}
    <div class="card">
        <div class="card-header blue">{{__("commonv2.add_edit_dewey_class")}}
            {{--            <a target="_blank" class="btn-link ml-2" href="https://en.wikipedia.org/wiki/List_of_Dewey_Decimal_classes">Dewey--}}
            {{--                Ref.</a><small>Just for getting s</small>--}}
            <div class="float-right">
                <button class="btn btn-sm btn-dark mr-1" type="button"
                        wire:click="clearClassTable()">{{__("commonv2.clear_dt_start_new")}}
                </button>
                
                <button class="btn btn-sm btn-dark" type="button"
                        wire:click="clearAllCategoryOfBook()">{{__("commonv2.reset_book_cat")}}
                </button>
            </div>
        </div>
        <div class="card-body yellow">
            <div class="container">
                <form wire:submit.prevent="saveCat">
                    <div class="form-row">
                        <div class="mb-2 col-md-12 col-12">
                            {!! CForm::inputGroupHeader(__("commonv2.calling_id")) !!}
                            <input class="form-control" wire:model.defer="cat_name" required>
                            {!! CForm::inputGroupFooter() !!}
                        </div>
                        <div class="mb-2 col-md-6 col-12">
                            {!! CForm::inputGroupHeader(__("commonv2.main_cat")) !!}
                            <select wire:model="sel_parent" class="form-control">
                                <option value="">{{__("common.select")}}</option>
                                @foreach($cat_parent as $item)
                                    <option value="{{$item->id}}">{{$item->cat_name}}</option>
                                @endforeach
                            </select>
                            {!! CForm::inputGroupFooter() !!}
                        </div>
                        {{--                        <div class="mb-2 col-md-6 col-12">--}}
                        {{--                            {!! CForm::inputGroupHeader(__("commonv2.sub_cat_of")) !!}--}}
                        {{--                            <select wire:model="sel_sub_parent" class="form-control">--}}
                        {{--                                <option value="">{{__("common.select")}}</option>--}}
                        {{--                                @foreach($cat_sub_parent as $item)--}}
                        {{--                                    <option @if($item->parent==0)--}}
                        {{--                                            @endif value="{{$item->id}}">{{$item->cat_name}}</option>--}}
                        {{--                                @endforeach--}}
                        {{--                            </select>--}}
                        {{--                            {!! CForm::inputGroupFooter() !!}--}}
                        {{--                        </div>--}}
                        {{--                        <div class="mb-2 col-md-6 col-12">--}}
                        {{--                            {!! CForm::inputGroupHeader(__("commonv2.dewey_no")) !!}--}}
                        {{--                            <input class="form-control" wire:model.defer="dewey_no" @if(!$common::getSiteSettings("enable_basic_classification")) required @endif--}}
                        {{--                                   placeholder="500.01 {{__("commonv2.the_system_attach_shelf_no")}}">--}}
                        {{--                            {!! CForm::inputGroupFooter() !!}--}}
                        {{--                        </div>--}}
                        <div class="mb-2 col-md-5 col-12">
                            {!! CForm::inputGroupHeader(__("commonv2.shelf_no")) !!}
                            <input class="form-control" type="text" wire:model.defer="shelf_no"
                                   placeholder="{{__("commonv2.any_no_between0099")}}">
                            {!! CForm::inputGroupFooter() !!}
                        </div>
                        
                        <div class="mb-2 col-md-1 col-12 d-flex" style="align-items: flex-end;">
                            <button class="btn btn-sm btn-dark w-100 " style="height:calc(2.25rem + 2px);"  wire:loading.class="disabled" type="submit">
                                <i class="far fa-hdd mr-1"></i>
                                {{__("common.save")}}</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>{{__("commonv2.calling_id")}}</th>
                                <th>{{__("commonv2.main_cat")}}</th>
                                <th>{{__("commonv2.shelf_no")}}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($all_dewey_data) && is_countable($all_dewey_data) && !count($all_dewey_data))
                                <tr>
                                    <td colspan="100">
                                        <div class="alert alert-dark">{{__("common.no_data_exist")}}</div>
                                    </td>
                                </tr>
                            @else
                                @foreach($all_dewey_data as $dewey)
                                    <tr class="parent level0">
                                        <td scope="row">{{$dewey->id}}</td>
                                        <td style="display: none">{{$common::formatDeweyNo($dewey->dewey_no,4)}}</td>
                                        <td colspan="2">{{$dewey->cat_name}}</td>
                                        {{--                                        <td>{{"N/A"}}</td>--}}

                                        <td>{{$common::formatShelfNo($dewey->shelf_no)}}</td>
                                        <td>
                                            <button type="button" wire:click="editCat({{$dewey->id}})"
                                                    class="btn float-left btn-sm btn-dark action_btn">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <button
                                                wire:loading.class="disabled"
                                                onclick="lv_confirm_then_submit(this,'{{__("common.cnf_del")}}','deleteCat','{\'id\':{{$dewey->id}}}')"
                                                type="button"
                                                class="btn float-left btn-sm btn-danger action_btn">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>

                                        </td>
                                    </tr>
                                    @php $childrens = \App\Models\DeweyDecimal::where("parent",$dewey->id)->get(); @endphp
                                    @if(isset($childrens) && count($childrens))
                                        @foreach($childrens as $deweychld)
                                            <tr class="children level1">
                                                <td scope="row">{{$deweychld->id}}</td>
                                                <td style="display: none">{{$common::formatDeweyNo($deweychld->dewey_no)}}</td>
                                                <td>{{$deweychld->cat_name}}</td>
                                                <td class="parent">{{$dewey->cat_name}}</td>

                                                <td>{{$common::formatShelfNo($deweychld->shelf_no)}}</td>
                                                <td>
                                                    <button type="button" wire:click="editCat({{$deweychld->id}})"
                                                            class="btn float-left btn-sm btn-dark action_btn">
                                                        <i class="far fa-edit"></i>
                                                    </button>
                                                    <button
                                                        wire:loading.class="disabled"
                                                        onclick="lv_confirm_then_submit(this,'{{__("common.cnf_del")}}','deleteCat','{\'id\':{{$deweychld->id}}}')"
                                                        type="button"
                                                        class="btn float-left btn-sm btn-danger action_btn">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>

                                                </td>
                                            </tr>

                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>

                    @if($all_dewey_data instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        {{$all_dewey_data->links()}}
                    @endif
                </div>
            </div>
        </div>
    </div>
    <style>
        .level0 {
        background-color:#e5e4e4/* Old #f4d03f */;
        }

        .level1 {
            background: #0056b3;
            color:#0056b3;
        }

        .level2 {
            background-color: ##e5e4e4/* Old #f4d03f */;
        }
    </style>
</div>
