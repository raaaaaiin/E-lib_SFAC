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
                        <a href="{{route("course.create")}}"
                           class="btn btn-sm btn-dark float-right"><i class="fas fa-plus-circle mr-1"></i>{{__("course.add_cs")}}</a></div>
                    <div class="card-body pt-1">
                        <div class="row mb-0 mt-3">
                            <div class="col-12">
                                @include("common.messages")
                            </div>
                        </div>

                        <div class="mt-2">
                            <form method="post"
                                  action="{{$mode=="create" ? route("course.store") : route("course.update",$course->id)}}">
                                @csrf
                                @if($mode!="create")
                                    <input type="hidden" name="_method" value="PUT">
                                @endif
                                <input type="hidden" name="id" value="{{$course? $course->id:""}}">

                                <div class="mb-2">
                                    {!! CForm::completeTextBox(__("course.cs_name"),"name",$course->name,__("course.pl_cs_name"),null,null,true,null) !!}
                                </div>

                                <div class="mb-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span
                                                class="input-group-text">{{__("course.att_cy")}} {!! CForm::generateStar() !!}</span>
                                        </div>
                                        <div class="form-control @error("course_year") border-danger @enderror h-auto">
                                            @php $count = 1 ;@endphp
                                            @foreach($course_years as $cy)
                                                <div class="custom-control custom-checkbox custom-control-inline">
                                                    <input type="checkbox" class="custom-control-input"
                                                           name="course_year[]"
                                                           id="customCheck{{$count}}" value="{{$cy->id}}"
                                                           @if($mode=="edit")
                                                           <?php $look_in = \App\Models\Course_Year::where("course_id", $course->id)->get()->pluck("course_year_id")->toArray(); ?>
                                                           @if(in_array($cy->id,$look_in))
                                                           checked
                                                        @endif
                                                        @endif>
                                                    <label class="custom-control-label"
                                                           for="customCheck{{$count}}">{{$cy->year}}</label>
                                                </div>

                                                @php $count = $count + 1 ;@endphp
                                            @endforeach
                                        </div>
                                    </div>
                                </div>



                                <div class="mb-2">

                                    <div class="input-group">
                                        <button type="submit" value="save" name="submit"
                                                class="btn btn-sm btn-dark"><i class="fas fa-save mr-1"></i>{{__("course.save_cs")}}
                                        </button>

                                        <button type="submit" value="save_and_add_more" name="submit"
                                                class="btn btn-sm btn-dark ml-1"><i class="fas fa-save mr-1"></i>{{__("course.save_cs_add_more")}}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

