<div>
    @php
        /* @var \App\Facades\Util $util */
        /* @var \App\Facades\Common $common */
    @endphp
    <div class="row">
        <div class="col-md-12 col-12 mb-10">
            <form id="issueBook">
                @csrf
                <div class="card">
                    <div class="card-header"><span class="card-header-title">{{__("common.issue_book")}}</span></div>
                    <div class="card-body">
                        <div class="form-row mb-10">
                            <div wire:ignore class="mb-10 col-md col-6">
                                <div class="form-row mb-10">
                                    {!! CForm::inputGroupHeader(__("common.search_user")."<a data-toggle='tooltip' 
                                    data-placement='top' title='Try User Id : 370 or 369'
                                  class='pl-1'><i class='fas fa-info-circle'></i></a>") !!}
                                    <input id="user_autocomplete" placeholder="{{__("common.ty_search")}}" type="text"
                                           class="form-control">
                                    {!! CForm::inputGroupFooter() !!}
                                </div>
                                <div class="form-row">
                                    <div class="col-md-3">
                                        <img id="user_image" src="{{$util::fakeImage(400,400)}}"
                                             class="ui-state-default img-thumbnail">
                                    </div>
                                    <div class="col-md-9">
                                        <input type="hidden" id="user_id">
                                        <input type="hidden" id="user_course_id">
                                        <input type="hidden" id="user_year_id">
                                        <ul class="list-group text-sm">
                                            <li class="list-group-item text-capitalize"
                                                style="padding-left: 7px;">{{__("common.user_id")}} :
                                                <span class="user_field_val"
                                                      id="spn_user_id">{{__("common.n_a")}}</span></li>
                                            <li class="list-group-item text-capitalize">{{__("common.course")}} : <span
                                                    class="user_field_val"
                                                    id="user_course">{{__("common.n_a")}}</span>
                                                | {{__("common.year")}} :<span class="user_field_val"
                                                                               id="user_year">{{__("common.n_a")}}</span>
                                            </li>
                                            <li class="list-group-item">{{__("common.email")}} : <span
                                                    class="user_field_val"
                                                    id="user_email">{{__("common.n_a")}}</span>
                                            </li>
                                            <li class="list-group-item address_li">{{__("common.address")}} : <span
                                                    class="user_field_val"
                                                    id="user_address">{{__("common.n_a")}}</span>
                                            </li>
                                            <li class="list-group-item address_li">{{__("common.borrowed")}} : <span
                                                    class="user_field_val"
                                                    id="user_borrowed_cnt">{{__("common.n_a")}}</span>
                                            </li>
                                            <li class="list-group-item address_li">{{__("commonv2.lmt_allw")}} : <span
                                                    class="user_field_val"
                                                    id="user_limit">{{__("common.n_a")}}</span>
                                            </li>
                                            <li class="list-group-item user_history_holder">{{__("common.borrowing_history")}}
                                                <a target="_blank" href="" id="user_history" class="float-right"><i
                                                        class="fas fa-search mr-1"></i></a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>


                            </div>
                            @if($common::getSiteSettings("enable_bardcode_reading_mode"))
                                <div class="mb-10 col-md col-6">
                                    <div wire:ignore class="form-row mb-10">
                                        {!! CForm::inputGroupHeader(__("common.search_book").'<i class="fas fa-barcode ml-1"></i>') !!}
                                        <input id="book_ids" wire:model.defer="tmp_barcode_book_id"
                                               placeholder="{{__("commonv2.pl_book_id_comma")}}" type="text"
                                               class="form-control">
                                        <div class="input-group-append">
                                            <button class="btn btn-dark btn-sm" wire:click="attach()" type="button"><i
                                                    class="fas fa-cart-plus"></i></button>
                                        </div>
                                        {!! CForm::inputGroupFooter() !!}
                                    </div>
                                    <div class="form-row"
                                         style="height: 200px;overflow-y: auto;border: 1px solid lightgray;padding: 10px;">
                                        <ul class="list-group w-100">
                                            @foreach($sel_books_info as $book_obj)
                                                <li class="list-group-item" style="padding: 0.5rem;">
                                                    <button type="button" class="btn btn-danger btn-xs float-right"
                                                            wire:click="deleteTmpSelectedBookId({{$book_obj->sub_book_id}})">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                    <img class="img-thumbnail" src="{{$book_obj->book->cover_img()}}"
                                                         style="width: 30px;display: block;float: left;margin-right: 2%;padding-top: 5px;"/>
                                                    <span class="text-sm">
                                                        {{$book_obj->book->title}}
                                                        <span class="badge badge-dark">{{$book_obj->sub_book_id}}</span>
                                                    </span>
                                                </li>
                                            @endforeach
                                            @if(is_countable($sel_books_info) && !count($sel_books_info))
                                                <div class="alert alert-dark text-sm">No books selected yet.</div>
                                            @endif

                                            {{--                                            <li class="list-group-item">Dapibus ac facilisis in</li>--}}
                                            {{--                                            <li class="list-group-item">Morbi leo risus</li>--}}
                                            {{--                                            <li class="list-group-item">Porta ac consectetur ac</li>--}}
                                            {{--                                            <li class="list-group-item">Vestibulum at eros</li>--}}
                                        </ul>
                                    </div>
                                </div>
                            @else
                                <div wire:ignore class="mb-10 col-md col-6">
                                    <div class="form-row mb-10">
                                        {!! CForm::inputGroupHeader(__("common.search_book")."<a data-toggle='tooltip' 
                                    data-placement='top' style='padding-left:5px;' title='Try Book Id : Type 97'><i class='fas fa-info-circle'></i></a>") !!}
                                        <input id="book_autocomplete" placeholder="{{__("common.ty_search")}}"
                                               type="text" class="form-control">
                                        {!! CForm::inputGroupFooter() !!}
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-3">
                                            <img id="book_image" src="https://via.placeholder.com/400x400"
                                                 class="ui-state-default img-thumbnail">
                                        </div>
                                        <div class="col-md-9">
                                            <input type="hidden" id="book_id">
                                            <input type="hidden" id="book_m_id">
                                            <ul class="list-group text-sm">
                                                <li class="list-group-item text-capitalize" style="padding-left: 7px;">
                                                    {{__("common.book_code")}} : <span class="book_field_val"
                                                                                       id="book_span_code">{{__("common.n_a")}}</span>
                                                </li>
                                                <li class="list-group-item text-capitalize">{{__("common.book_title")}}
                                                    : <span class="book_field_val"
                                                            id="book_title">{{__("common.n_a")}}</span>
                                                </li>
                                                <li class="list-group-item text-capitalize">{{__("common.cat")}} : <span
                                                        class="book_field_val"
                                                        id="book_category">{{__("common.n_a")}}
                                        </span> | {{__("common.book_condition")}} : <span class="book_field_val"
                                                                                          id="book_condition">{{__("common.n_a")}}</span>
                                                    | {{__("common.book_price")}} : <span class="book_field_val"
                                                                                          id="book_price">{{__("common.n_a")}}</span>
                                                </li>
                                                <li class="list-group-item">{{__("common.remark")}} : <span
                                                        class="book_field_val"
                                                        id="book_remark">{{__("common.n_a")}}</span>
                                                </li>
                                                <li class="list-group-item book_history_holder">{{__("common.last_history")}}
                                                    <a target="_blank" href="" id="book_history" class="float-right"><i
                                                            class="fas fa-search mr-1"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="form-row mb-10">
                            <div wire:ignore class="col-md mb-10">
                                {!! CForm::inputGroupHeader(__("common.issue_date")) !!}
                                <input type="text" id="issue_date_tmp" class="form-control"/>
                                <input type="hidden" id="issue_date"/>
                                {!! CForm::inputGroupFooter() !!}
                            </div>
                            <div wire:ignore class="col-md mb-10">
                                {!! CForm::inputGroupHeader(__("common.return_date")) !!}
                                <input type="text" id="return_date_tmp" class="form-control"/>
                                <input type="hidden" id="return_date"/>
                                {!! CForm::inputGroupFooter() !!}
                            </div>
                            <div class="col-md mb-10">
                                <button type="button" @if(!$allow_issue) disabled @endif
                                @if($common::getSiteSettings("enable_bardcode_reading_mode")) wire:click="bulkissueBook"
                                        @else wire:click="issueBook" @endif
                                        class="btn btn-danger">{{__("common.issue_book")}}</button>
                            </div>
                        </div>
                        <div class="form-row">
                            {!! CForm::inputGroupHeader("Remark") !!}
                            <textarea class="form-control" wire:model.lazy="sel_remark"></textarea>
                            {!! CForm::inputGroupFooter() !!}
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-12 mb-10">
            <div class="card">
                <div class="card-header">
                    {{__("commonv2.req_for_borrowing")}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                            <tr>
                                <th scope="col">#</td>
                                <th scope="col">{{__("common.user_id")}}</td>
                                <th scope="col">{{__("common.user_img")}}</td>
                                <th scope="col">{{__("common.full_name")}}</td>
                                <th scope="col">{{__("common.book_id")}}</td>
                                <th scope="col">{{__("common.book_img")}}</td>
                                <th scope="col">{{__("commonv2.req_book")}}</td>
                                <th scope="col">{{__("common.created_on")}}</td>
                                <th scope="col">{{__("common.borrow_on")}}</td>
                                <th scope="col">{{__("common.return_date")}}</td>
                                <th scope="col">{{__("common.action")}}</td>
                            </tr>
                            </thead>
                            <tbody>
                            {{--                           @php dd($books_pending); @endphp--}}
                            <input type="hidden" id="return_dt"/>
                            @foreach($books_pending as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->user->id}}</td>
                                    <td><img style="width: 50px;"
                                             src="{{asset('uploads/'.$item->user->get_user_image())}}"
                                             class="img-thumbnail"/></td>
                                    <td>{{$item->user->name}}</td>
                                    <td style="font-size: 20px;">{{$item->sub_book->sub_book_id}}</td>
                                    <td><img style="width: 50px;" src="{{$item->sub_book->book->cover_img()}}"
                                             class="img-thumbnail"/></td>
                                    <td>{{Str::words($item->sub_book->book->title,5,"...")}}</td>
                                    <td>{{$util::goodDate($item->created_at)}}</td>
                                    <td>{{$util::goodDate($item->expectedborrow)}}</td>
                                    <td><input id="retdate" type="text" class="return_dt form-control" value="{{$util::goodDate($item->expectedreturn)}}"></td>
                                    <script>
                                    
                                    </script>
                                    <td>
                                        <button class="btn btn-dark btn-sm" type="button"
                                                wire:click="issueBookRequested({{$item->user_id}},{{$item->sub_book->id}},{{$item->sub_book->book->id}})">
                                            <i class="far fa-check-circle"></i></button>
                                        <button class="btn btn-danger btn-sm" type="button"
                                                wire:click="cancelRequest({{$item->id}})"><i
                                                class="far fa-times-circle"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                            @if(is_countable($books_pending) && !count($books_pending))
                                <tr><td colspan="100"><div class="alert alert-dark">{{__("commonv2.no_books_in_request_queue")}}</div></td></tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    @if(!is_null($books_pending) && is_countable($books_pending) && $books_pending instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        {{$books_pending->links()}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
