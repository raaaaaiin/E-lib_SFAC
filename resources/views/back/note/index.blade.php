@php
    /* @var \App\Facades\Util $util */
    /* @var \App\Facades\Common $common */
@endphp
@extends("back.common.master")
@section("page_name")
    {{__("common.note_management")}}
@endsection
@section("content")
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header blue"><span class="card-header-title">{{{__("common.mng_notes")}}}</span>
                    <a class="btn btn-dark btn-xs float-right"
                       href="{{route('notes-mng.create')}}"><i
                            class="fas fa-plus-circle mr-1"></i>{{__("common.add_note")}}</a>
                </div>
                <div class="card-body yellow">
                    <div class="row">
                        @if(\Illuminate\Support\Facades\Session::has("note_list") && \Illuminate\Support\Facades\Session::get("note_list"))

                            <div class="col-12">
                                @include("common.messages")
                            </div>

                        @endif
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-sm">
                                    <thead>
                                    <tr>
                                        <td>{{__("common.id")}}</td>
                                        <td>{{__("common.title")}}</td>
                                        <td>{{__("common.note_title")}}</td>
                                        <td>{{__("common.note_desc")}}</td>
                                        <td>{{__("common.attached_files")}}</td>
                                        <td>{{__("common.status")}}</td>
                                        <td style="width: 90px;">{{__("common.created_on")}}</td>
                                        <td style="width: 90px;">{{__("common.action")}}</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($items) && count($items))
                                        @foreach($items as $item)
                                            <tr class="data_holder">
                                                <td>{{$item->id}}</td>
                                                <td>{{$item->book->title}}</td>
                                                <td>{!! \Illuminate\Support\Str::limit($item->note_title,50) !!}</td>
                                                <td>{!! \Illuminate\Support\Str::limit($item->note_desc,100) !!}</td>
                                                @php
                                                    $links=[];
                                                    $files = $item->files_attached;
                                                    if($files){
                                                        foreach ($files as $filename){
                                                            array_push($links,"<a target='_blank' href='".asset('uploads/'.$filename)."'>".$filename."</a>",true);
                                                        }
                                                    }
                                                @endphp
                                                <td class="file_uploaded_td text-sm">{!!  $item->files_attached ? implode(",<br>",$links):"--" !!}</td>
                                                <td>{!!  !$item->note_status ? '<span class="badge badge-primary">'.__("common.draft").'</span>':
                                                    '<span class="badge badge-success">'.__("common.published").'</span>'!!}</td>
                                                <td>{{ $util::goodDate($item->created_at) }}</td>
                                                <td>
                                                    <a href="{{route("notes-mng.edit",$item->id)}}"
                                                       class="btn btn-dark cm_edit">
                                                        <i class="far fa-edit"></i>
                                                    </a>
                                                    <a
                                                        href="#"
                                                        onclick="make_sense({{$item->id}})"
                                                        class="btn btn-danger cm_del">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="100">
                                                <div class="alert alert-dark">{{__("common.no_note_exist")}}</div>
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            @if($items->hasPages())
                                {{$items->links()}}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("css_loc")
    <style>
        .file_uploaded_td {

            height: 100%;
            display: block;
            overflow-y: auto;
            width: 100%;
        }
    </style>
@endsection
@section("js_loc")
    <script>
        $(document).ready(function () {
            make_sense = function ($id) {
                $del_url = "{{route('notes-mng.delete',"")}}/" + $id;
                sure('{{__('common.cnf_del_note')}}', function ($response) {
                    if ($response) {
                        window.location = $del_url;
                    }
                });
            }
        });
    </script>
@endsection
