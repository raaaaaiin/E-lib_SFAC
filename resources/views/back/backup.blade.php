@php
    /* @var \App\Facades\Util $util */
    /* @var \App\Facades\Common $common */
@endphp
@extends("back.common.master")
@section("page_name") {{__("common.site_setting")}} @endsection
@section("content")
    @include("back.common.spinner")
    @php CForm::star_status('on'); @endphp
    <div class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-body yellow">
                    @if(session()->has('form_setting') && session()->get('form_setting'))
                        <div class="row">
                            <div class="col-12">
                                @include("common.messages")
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-12">


                            <div id="backup" class="tabcontent" style="    width: 100%!important;">
                                <h3 style="padding-top: 15px;">{{__("common.bck_res_db")}}</h3>
                                <p>{{__("common.pl_bck_db")}}</p>
                                <form method="post" action="{{route('file.db_mng')}}">
                                    @csrf
                                    <input name="do" type="hidden" value="backup">
                                    <input name="frm_name" type="hidden" value="backup">
                                    <button type="submit"
                                            class="btn btn-dark btn-sm mb-10"><i
                                            class="fas fa-cloud-upload-alt mr-1"></i>{{__("common.create_db_bck")}}
                                    </button>
                                </form>
                                <table class="table table-striped table-hover table-sm mt-2">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{__("common.db_file_name")}}</th>
                                        <th scope="col">{{__("common.file_size")}}</th>
                                        <th scope="col">{{__("common.created_on")}}</th>
                                        <th scope="col">{{__("common.action")}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $items = $util::getDbBackupFiles();
                                    @endphp
                                    @if(count($items))
                                        @php $count = 1; @endphp
                                        @foreach($items as $key=>$value)
                                            <tr>
                                                <td>{{$count}}</td>
                                                <td>{{$key}}</td>
                                                <td>{{$value[0]}}</td>
                                                <td>{{$value[1]}}</td>
                                                <td>
                                                    <form class="d-inline" method="post"
                                                          action="{{route('file.db_mng')}}">
                                                        @csrf
                                                        <input type="hidden" name="filename" value="{{$key}}">
                                                        <input type="hidden" name="do" value="restore">
                                                        <input name="frm_name" type="hidden" value="backup"/>
                                                        <button class="btn p-2" type="submit" data-toggle="tooltip"
                                                                data-placement="top"
                                                                title="{{__("common.restore_db")}}"><i
                                                                class="fas fa-sync"></i></button>
                                                    </form>
                                                    <form class="d-inline" method="post" id="delete_{{$count}}"
                                                          action="{{route('file.db_mng')}}">
                                                        @csrf
                                                        <input type="hidden" name="filename" value="{{$key}}">
                                                        <input type="hidden" name="do" value="delete">
                                                        <input name="frm_name" type="hidden" value="backup"/>
                                                        <button
                                                            onclick="confirm_then_submit('{{__("common.cnf_del")}}','delete_{{$count}}')"
                                                            class="btn p-2"
                                                            type="button" data-toggle="tooltip" data-placement="top"
                                                            title="{{__("common.del_this_bck")}}"><i
                                                                class="far fa-trash-alt"></i></button>
                                                    </form>
                                                </td>
                                                @php $count = $count+1; @endphp
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="100">
                                                <div
                                                    class="alert alert-dark col-12">{{__("common.no_bck_exist")}}</div>
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("css_loc")
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/setting.css')}}">
    <link href="{{asset('css/bootstrap-toggle.min.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/summernote/summernote-bs4.css')}}" rel="stylesheet">
@endsection
@section("js_loc")
    <script type="text/javascript" src="{{asset("js/select2.min.js")}}"></script>
    <script src="{{asset('js/bootstrap-toggle.min.js')}}"></script>
    <script src="{{asset('plugins/summernote/summernote-bs4.js')}}"></script>
    <script src="{{asset('js/setting.js')}}"></script>
@endsection
