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
                        <a href="{{route("course-year.create")}}"
                                                                           class="btn btn-sm btn-dark float-right">
                            <i class="fas fa-plus-circle mr-1"></i>{{__("course_year.add_cy")}}</a>
                    </div>
                    <div class="card-body yellow">

                        <div class="">
                            @include("common.messages")
                            <form method="post"
                                  action="{{$mode=="create" ? route("course-year.store") : route("course-year.update",$courseYear->id)}}">
                                @csrf
                                @if($mode!="create")
                                    <input type="hidden" name="_method" value="PUT">
                                @endif
                                <div class="mb-10">
                                    {!! CForm::completeTextBox(__("course_year.cy_name"),"year",$courseYear->year,__("course_year.pl_cy_name"),null,null,true,null) !!}
                                </div>

                                <div class=" form-group">
                                    <button type="submit" value="save" name="submit" class="btn btn-sm btn-dark">
                                        <i class="fas fa-save mr-1"></i>{{__("course_year.save_cy")}}
                                    </button>
                                    <button type="submit" value="save_and_add_more" name="submit"
                                            class="btn btn-sm btn-dark"><i class="fas fa-save mr-1"></i>{{__("course_year.save_cy_add_more")}}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
