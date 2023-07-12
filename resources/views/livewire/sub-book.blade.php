<div class="w-100">
    @php
        /* @var \App\Facades\Util $util */
        /* @var \App\Facades\Common $common */
    @endphp
    @php $loading_target="search_keyword,sel_parent_cat,sel_sub_cat" ;@endphp
    @include("back.common.spinner")
    <div class="card">
        <div class="card-header blue">{{__("common.mng_books")}}
            <div class="float-right">
                @if($enable_bulk_operation)
                    <button class="btn btn-dark btn-sm"
                            wire:click="$set('enable_bulk_operation',false)">{{__("commonv2.hide_bulk_options")}}</button>
                @else
                    <button class="btn btn-dark btn-sm"
                            wire:click="$set('enable_bulk_operation',true)">{{__("commonv2.shw_bulk_options")}}</button>
                @endif
            </div>
        </div>
        <div class="card-body yellow">

            @if($enable_bulk_operation)
                <div class="form-row no-gutters mb-10">
                    <div class="col-md">
                        <form method="post" class="m-1 frm_export"
                              action="{{route('books.import')}}"
                              enctype="multipart/form-data">
                            @csrf

                            <div class="input-group">

                                <input type="file" name="file" accept=".csv"
                                       class="form-control text-xs file_upload"
                                >
                                <div class="input-group-append">
                                    <button class="btn btn-xs btn-dark mr-1" type="submit"><i
                                            class="fa fa-upload mr-1"
                                            aria-hidden="true"></i>
                                        {{__("common.imp_books")}}
                                    </button>
                                    <a style="padding-top: 5%;" target="_blank" href="{{route('books.export')}}"
                                       class="btn btn-xs btn-dark" href="{{route("books.export")}}"><i
                                            class="fas fa-download mr-1"></i>
                                        {{__("common.expo_books")}}
                                    </a>

                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="form-row no-gutters mb-9">
                    <div class="col-md-12 col-12">
                        <div class="form-row no-gutters">
                            <div class="mb-2 col-12 col-md-4">
                                {!! CForm::inputGroupHeader(__("common.category")) !!}
                                <select wire:model="sel_parent_cat" class="form-control">
                                    <option value="">{{__("common.select")}}</option>
                                    @foreach($common::getAllParentCatInArray() as $k=>$v)
                                        <option value="{{$k}}">{{$v}}</option>
                                    @endforeach
                                </select>
                                {!! CForm::inputGroupFooter() !!}
                            </div>
                            <div class="mb-2 col-12 col-md-6">
                                {!! CForm::inputGroupHeader(__("commonv2.sub_cat")) !!}
                                <select wire:model="sel_sub_cat" class="form-control">
                                    <option value="">{{__("common.select")}}</option>
                                    @if($sel_parent_cat)
                                        @foreach(\App\Models\DeweyDecimal::where("parent",$sel_parent_cat)->get()->pluck("cat_name","id")->toArray() as $k=>$v)
                                            <option value="{{$k}}">{{$v}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                {!! CForm::inputGroupFooter() !!}
                            </div>
                            <div class="mb-2 col-12 col-md-2">
                                <button class="btn btn-dark" type="button" wire:click="bulkSaveCategory"><i
                                        class="fas fa-plus-circle mr-1"></i>{{__("commonv2.attach_Categories")}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="form-row no-gutters mb-10">
                <div class="col-12">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">{{__("common.advanced_filter")}}</span>
                        </div>
                        <input type="text" wire:model.debounce.500ms="search_keyword" class="form-control" name=""
                               placeholder="{{__("common.ty_search")}}">
                    </div>
                </div>
            </div>
            <div class="form-row">

                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                        <tr>
                            @if($enable_bulk_operation)
                                <td>#</td>
                            @endif
                            <td>{{__("common.id")}}</td>
                            <td>{{__("common.img")}}</td>
                            <td>{{__("common.qty")}}</td>
                            <td>{{__("common.borrowed")}}</td>
                            <td>{{__("common.isbn_10")}}</td>
                            <td>{{__("common.isbn_13")}}</td>
                            <td>{{__("common.name")}}</td>
                            <td>{{__("common.cat")}}</td>
                            <td>{{__("common.author")}}</td>
                            <td>{{__("common.preview")}}</td>
                            <td style="width: 80px;">{{__("common.action")}}
                                <input data-toggle="tooltip" data-placement="top" title="{{__("common.show_inactive")}}"
                                       class="mt-1 ml-1" type="checkbox" wire:model="show_inactive"></td>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($items as $item)
                            <tr>
                                @if($enable_bulk_operation)
                                    <td><input type="checkbox" wire:model.defer="sel_sb_id_bulk" value="{{$item->id}}">
                                    </td>
                                @endif
                                <td>{{$item->id}}</td>
                                <td><img style="width: 200px;" class="img-thumbnail"
                                         src="{{$item->cover_img()}}"/>
                                </td>
                                <td><span class="pr-1 w-50pc">{{$item->sub_books->count()}}</span>
                                    <a class="search_tbl_iss_lst w-50pc" href="{{route('books.edit',$item->id)}}">
                                        <i class="fas fa-search mr-1"></i>
                                    </a>
                                </td>
                                <td><span
                                        class="w-50pc">{{$util::countProperty($item->sub_books->toArray(),"borrowed","1")}}</span>
                                    @php $get_borrowed_books = Util::searchCollectionsAndReturnCollection($item->sub_books,"borrowed","1","sub_book_id");@endphp
                                    @if(count($get_borrowed_books))
                                        <a target="_blank" class="search_tbl_iss_lst w-50pc"
                                           href="{{route("indexReceiveBooks")}}?search={{implode(",",$get_borrowed_books)}}"><i
                                                class="fas fa-search mr-1 text-green"></i></a>
                                    @endif
                                </td>
                                <td class="text-sm">{{$item->isbn_10 ? $item->isbn_10:(Str::contains($item->unique_id,"R-")?__("common.id").": ".$item->unique_id:"N/A")}}</td>
                                <td class="text-sm">{{$item->isbn_13 ? $item->isbn_13:'N/A'}}</td>
                                <td class="text-sm"><a target="_blank"
                                                       href="{{url('/').'/details/'.$common::utf8Slug($item->title)}}">{{$item->title}}</a>
                                    <div>
                                        @if($common::getShelfNo($item->category)!=="--")
                                            <span
                                                class="text-sm font-weight-bold">{{__("commonv2.shelf_no")}} : {{$common::getShelfNo($item->category)}}</span>
                                    </div>
                                    @else -- @endif
                                </td>
                                <td class="text-sm">
                                    @if($item->category)
                                        {{Str::title($common::getCatName($common::getParentCatOfSubCat($item->category)))}}
                                        <i class="fas fa-greater-than" style="font-size: 10px;"></i>
                                    @endif
                                    <a target="_blank"
                                       href="{{url('/'."?pcat=".$common::getParentCatOfSubCat($item->category).'&scat='.$item->category."#books")}}"
                                       class="btn-link text-sm">
                                        {{Str::title($common::getCatName($item->category))}}
                                    </a>
                                </td>
                                <td class="text-sm">
                                    @php $citems = $item->authors()->pluck("authors.name")->toArray(); @endphp
                                    @if(count($citems))
                                        @foreach($citems as $citem)
                                            <a target="_blank"
                                               href="{{url('/')."?search=".$citem."#books"}}"
                                               class="btn-link text-sm">{{Str::title($citem)}}</a>
                                            @if(!$loop->last),@endif
                                        @endforeach
                                    @else
                                        <span class="text-sm">--</span>
                                    @endif
                                </td>
                                <td>
                                    @if(isset($item->custom_file))
                                        <a href="{{$item->custom_file ? asset("uploads/".$item->custom_file) : $item->preview_url}}"
                                           target="_blank"><i class="fas fa-external-link-alt"></i></a>
                                    @else
                                        --
                                    @endif
                                </td>
                                <td class="text-sm">
                                <div class="d-flex">
                                    <button class="btn btn-warning cm_edit" type="button"
                                            onclick="lv_confirm_then_submit(this,'{{$item->active?__("common.cnf_deactive"):__("common.cnf_active")}}','toggleActiveMainBook',
                                                '{\'id\':{{$item->id}}}')">@if($item->active)<i
                                            class="far fa-eye"></i>@else <i
                                            class="fas fa-eye-slash"></i> @endif</button>
                                    <a class="btn btn-dark cm_edit" href="{{route('books.edit',$item->id)}}"><i
                                            class="fas fa-pencil-alt"></i></a>
                                    <button data-toggle="tooltip" data-placement="left"
                                            title="{{__("common.delete_main_book")}}"
                                            type="button"
                                            onclick="lv_confirm_then_submit(this,'{{__("common.cnf_del")}}','deleteMainBook','{\'id\':{{$item->id}}}')"
                                            class="btn btn-danger cm_del"><i
                                            class="far fa-trash-alt"></i></button>
                                     </div>      

                                </td>
                            </tr>
                        @endforeach
                        @if(isset($items) && !count($items))
                            <tr>
                                <td colspan="100">
                                    <div class="alert alert-dark">{{__("common.no_books_exist")}}</div>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    @if(isset($items))
                        {{$items->links()}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

