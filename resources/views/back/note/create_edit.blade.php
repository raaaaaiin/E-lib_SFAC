@php
    /* @var \App\Facades\Util $util */
    /* @var \App\Facades\Common $common */
@endphp
@extends("back.common.master")
@section("page_name")
    @if($mode=="create"){{__("common.add_note")}}@else{{__("common.edit_note")}}@endif
@endsection
@section("content")
    <div class="card">
        <div
            class="card-header"><span
                class="card-header-title">@if(isset($item)){{__("common.edit")}}@else {{__("common.add")}}@endif {{__("common.notes")}}</span>
            <a class="btn btn-dark btn-xs float-right"
               href="{{route('notes-mng.create')}}"><i class="fas fa-plus-circle mr-1"></i>{{__("common.add_note")}}</a>
            <a class="btn btn-dark btn-xs float-right mr-1"
               href="{{route('notes-mng.index')}}"><i class="fas fa-list mr-1"></i>{{__("common.view_note")}}</a>
        </div>
        <div class="card-body yellow">
            @if(\Illuminate\Support\Facades\Session::has("note_form") && \Illuminate\Support\Facades\Session::get("note_form"))
                <div class="row">
                    <div class="col-12">
                        @include("common.messages")
                    </div>
                </div>
            @endif
            <form method="post" action="{{route("notes-mng.store")}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="mode" value="{{$mode}}">
                @if($mode=="edit")
                    <input type="hidden" name="id" value="{{$item->id}}">
                @endif
                <div class="form-row">
                    <div class="mb-2 col-md-6 col-12">
                        {!! CForm::inputGroupHeader(__("common.select_book")) !!}
                        <select class="form-control" required name="book_id">
                            <option value="">{{__("common.select")}}</option>
                            @foreach(\App\Models\Book::pluck("title","id") as $key=>$value)
                                <option value="{{$key}}"
                                        @if(old('book_id',isset($item)?$item->book_id:"")==$key) selected @endif
                                >{{$value}}</option>
                            @endforeach
                        </select>
                        {!! CForm::inputGroupFooter() !!}
                        @error('book_id')
                        <div class="w-100">
                            @include('back.common.validation',
                        ['message' => $common::reformatErrorMsg($message),"cls_name" => "word-wrap"  ]) </div>@enderror


                    </div>
                    <div class="mb-2 col-md-6 col-12">
                        {!! CForm::inputGroupHeader(__("common.note_status")) !!}
                        <select class="form-control" required name="note_status">
                            <option value="">{{__("common.select")}}</option>
                            <option value="0"
                                    @if(old('note_status',isset($item)?$item->note_status:"")==0) selected @endif
                            >{{__("common.draft")}}</option>
                            <option value="1"
                                    @if(old('note_status',isset($item)?$item->note_status:"")==1) selected @endif
                            >{{__("common.publish")}}</option>
                        </select>
                        {!! CForm::inputGroupFooter() !!}
                        @error('note_status')
                        <div class="w-100">
                            @include('back.common.validation',
                        ['message' => $common::reformatErrorMsg($message),"cls_name" => "word-wrap"  ]) </div>@enderror
                    </div>
                    <div class="mb-2 col-12">
                        {!! CForm::inputGroupHeader(__("common.note_title")) !!}
                        <input type="text" class="form-control" name="note_title"
                               value="{{old("note_title",isset($item)?$item->note_title:"")}}"/>
                        {!! CForm::inputGroupFooter() !!}
                        @error('note_title')
                        <div class="w-100">
                            @include('back.common.validation',
                        ['message' => $common::reformatErrorMsg($message),"cls_name" => "word-wrap"  ]) </div>@enderror
                    </div>
                    <div class="mb-2 col-12">
                        {!! CForm::inputGroupHeader(__("common.note_desc"),"w-100","w-100") !!}
                        {!! CForm::inputGroupFooter() !!}
                        <textarea class="summernote_big"
                                  name="note_desc">{{old("note_desc",isset($item)?$item->note_desc:"")}}</textarea>
                        @error('note_desc')
                        <div class="w-100">
                            @include('back.common.validation',
                        ['message' => $common::reformatErrorMsg($message),"cls_name" => "word-wrap"  ]) </div>@enderror
                    </div>
                    <div class="mb-2 col-12">
                        {!! CForm::inputGroupHeader(__("common.attach_notes"),"w-100","w-100") !!}
                        <input type="file" name="file[]" class="form-control text-sm" multiple>
                        {!! CForm::inputGroupFooter() !!}

                        @error('file.*')
                        <div class="w-100">
                            @include('back.common.validation',
                        ['message' => $common::reformatErrorMsg($message),"cls_name" => "word-wrap"  ]) </div>@enderror
                    </div>
                    @if(old("files_attached",isset($item)?$item->files_attached:"") && count(old("files_attached",isset($item)?$item->files_attached:"")))
                        <div class="mb-2 col-12">
                            {!! CForm::inputGroupHeader(__("common.attached_notes"),"w-100","w-100") !!}
                            <ul class="list-group w-100">
                                @foreach(old("files_attached",isset($item)?$item->files_attached:[]) as $file)
                                    <li class="list-group-item f_{{$loop->index}}">{{intval($loop->index)+1}}
                                        ) {{$file}} <a
                                            class="btn btn-xs btn-dark ml-1"
                                            href="{{asset("uploads/".$file)}}"
                                            target="_blank"><i
                                                class="fas fa-external-link-alt"></i></a>
                                        <input type="hidden" name="files_attached[]" value="{{$file}}"
                                               class="f_{{$loop->index}}">
                                        <button type="button" class="btn btn-xs btn-danger"
                                                onclick="sure_file_del({{$loop->index}});"><i
                                                class="far fa-trash-alt"></i></button>
                                    </li>
                                @endforeach
                                @if(isset($item) && !count($item->files_attached))
                                    <li class="list-group-item">{{__("common.no_attached_file")}}</li>
                                @endif
                            </ul>
                            {!! CForm::inputGroupFooter() !!}
                        </div>
                    @endif
                    <div class="col-12">
                        <button class="btn btn-dark btn-sm" name="submit" type="submit"
                                value="save"><i
                                class="far fa-hdd mr-1"></i> @if($mode=="create"){{__("common.add_note")}}@else {{__("common.save_note")}} @endif
                        </button>

                        <button class="btn btn-dark btn-sm" name="submit" type="submit"
                                value="save_and_list"><i class="fas fa-list mr-1"></i>{{__("common.save_and_list")}}
                        </button>

                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section("css_loc")
    <link href="{{asset('plugins/summernote/summernote-bs4.css')}}" rel="stylesheet">
@endsection
@section("js_loc")
    <script src="{{asset('plugins/summernote/summernote-bs4.js')}}"></script>
    <script src="{{asset('js/note.js')}}"></script>
    <script>
        sure_file_del = function ($id) {
            sure("{{__("common.cnf_del")}}", function ($response) {
                if ($response) {
                    let element = $(".f_" + $id);
                    if (element.length) {
                        element.remove();
                    }
                }
            });
        }
    </script>
@endsection
