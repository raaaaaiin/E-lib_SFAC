@php
    /* @var \App\Facades\Util $util */
    /* @var \App\Facades\Common $common */
@endphp
@extends("back.common.master")
@section("page_name")
    {{__("course.cs_mng")}}
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header blue"><span class="card-header-title">{{__("course.mng_cy")}}</span>
                        <a href="{{route("course.create")}}" class="btn btn-sm btn-dark float-right"><i
                                class="fas fa-plus-circle mr-1"></i>{{__("course.add_cs")}}</a></div>
                    <div class="card-body pt-1">
                        <div class="row mt-2">
                            <div class="col-12">
                                @include("common.messages")
                            </div>
                        </div>

                        <div class="table-responsive mt-2">
                            <table class="table table-hover table-sm">
                                <thead>
                                <tr>
                                    <th>{{__("common.id")}}</th>
                                    <th>{{__("course.course")}}</th>
                                    <th>{{__("course_year.cy")}}</th>
                                    <th>{{__("common.action")}}</th>
                                </tr>
                                </thead>

                                <tbody>

                                @if(!$courses || $courses->count()==0)
                                    <tr>
                                        <td colspan="4">
                                            <div class="alert alert-dark">{{__("course.no_cy_exist")}}</div>
                                        </td>
                                    </tr>
                                @endif


                                @foreach($courses as $course)
                                    <tr>
                                        <td>{{$course->id}}</td>
                                        <td>{{$course->name}}</td>
                                        <td>
                                            <ul class="list-group">
                                                @foreach(\App\Models\Course_Year::where("course_id",$course->id)->get() as $obj)
                                                    @if($obj->course_id)
                                                        <li class="list-group-item">
                                                            {{$common::getCourseYearName($obj->course_year_id)}}
                                                            <a href="{{route('user-mng.index')}}?page_mode=promotion&course_id={{$course->id}}&course_year={{$obj->course_year_id}}" style="font-size: 15px;float: right;"
                                                               data-toggle="tooltip" data-placement="top"
                                                               title="Promote the users to the next academic year Or Archive them">
                                                                <i class="fab fa-accessible-icon"></i> Promotions</a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </td>

                                        <td>
                                            <div class="input-group">
                                                <a href="{{ route('course.edit', $course->id) }}"
                                                   class="btn btn-sm btn-dark action_btn"><i
                                                        class="fas fa-pencil-alt"></i></a>
                                                {{ Form::open([ 'method'  => 'delete',
                                    "id"=>"standard_delete_".$course->id,
                                     'route' => [ 'course.destroy', $course->id ] ]) }}
                                                <button class="btn btn-sm btn-danger action_btn" type="button"
                                                        onclick="confirm_then_submit('{{__("common.cnf_del")}}','standard_delete_{{$course->id}}')">
                                                    <i
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

