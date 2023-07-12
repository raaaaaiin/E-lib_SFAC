@php
    /* @var \App\Facades\Util $util */
    /* @var \App\Facades\Common $common */
@endphp
@extends("back.common.master")
@section("page_name")
    {{__("course_year.cy_mng")}}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header blue"><span class="card-header-title">{{__("course_year.mng_cy")}}</span>
                        <a href="{{route("course-year.create")}}" class="btn btn-sm btn-dark float-right"><i
                                class="fas fa-plus-circle mr-1"></i>{{__("course_year.add_cy")}}</a></div>
                    <div class="card-body pt-1">

                        <div class="row margin_top_2p">
                            <div class="col-12 mt-2">
                                @include("common.messages")
                            </div>
                        </div>
                        <div class="table-responsive mt-2">
                            <table class="table table-hover table-sm">
                                <thead>
                                <tr>
                                    <th>{{__("common.id")}}</th>
                                    <th>{{__("course_year.cy")}}</th>
                                    <th>{{__("common.action")}}</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if(!$courseYear || $courseYear->count()==0)
                                    <tr>
                                        <td colspan="3">
                                            <div class="alert alert-dark">{{__("course_year.no_cy_exist")}}!</div>
                                        </td>
                                    </tr>
                                @endif
                                @foreach($courseYear as $cy)
                                    <tr>
                                        <td>{{$cy->id}}</td>
                                        <td>{{$cy->year}}</td>
                                        <td>
                                            <div class="input-group">
                                                <a href="{{ route('course-year.edit', $cy->id) }}"
                                                   class="btn btn-sm btn-dark action_btn"><i
                                                        class="fas fa-pencil-alt"></i></a>
                                                {{ Form::open([ 'method'  => 'delete',
                                                "id"=>"division_delete_".$cy->id,'route' => [ 'course-year.destroy', $cy->id ] ]) }}
                                                <button class="btn btn-sm btn-danger action_btn" type="button"
                                                        onclick="confirm_then_submit('{{__("common.cnf_del")}}'
                                                            ,'division_delete_{{$cy->id}}')"><i
                                                        class="fa fa-trash"></i></button>
                                                {{ Form::close() }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
