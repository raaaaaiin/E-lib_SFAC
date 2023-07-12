<div>
    @php
        /* @var \App\Facades\Util $util */
        /* @var \App\Facades\Common $common */
    @endphp
    @php $loading_target = "photo,filter_name,selectAll,selected_course_id,selected_course_year_id";@endphp
    @include("back.common.spinner")

    @if($form_mode=="add"|| $form_mode=="edit")
        <div id="frm_user_mng_holder" class="card card-dark">
            <div class="card-header blue"><span class="card-header-title">{{__("common.add_update_user_details")}}</span>
                <button class="btn btn-sm float-right" type="button" wire:click="closeUserFormBtn"><i
                        class="text-white fas fa-times-circle"></i></button>
            </div>
            <div class="card-body yellow">
                @if(session()->has("form_user") && session()->get("form_user"))
                    <div class="row">
                        <div class="col-12">
                            @include("common.messages")
                        </div>
                    </div>
                @endif
                <div class="row mb-2">
                    <form class="col-12 p-0" role="form" wire:submit.prevent="saveUser">
                        @csrf
                        <input type="hidden" wire:model="mode"/>

                        <div class="form-row">
                            <div class="form-group col-md-3 col-12">
                                @if($photo && $photo->temporaryUrl())
                                    <img wire:ignore src="{{$photo->temporaryUrl()}}"
                                         class="img-thumbnail w-100"/>
                                @else
                                    <img src="{{asset("uploads/".$photo_link)}}" class="img-thumbnail w-100"/>
                                @endif
                                <br/>
                                <input type="file" class="form-control mt-2  text-sm" wire:model.lazy="photo">
                                @error('photo') @include('back.common.validation', ['message' =>  $message ]) @enderror
                            </div>
                            <div class="col-md-9 col-12">
                                <div class="form-row">
                                    <div class="col-md-3 mb-2">
                                        {!! CForm::inputGroupHeader(__("common.std_id")) !!}
                                        <input type="text" class="form-control"
                                               wire:model.defer="stdid"
                                               required>
                                        @error('stdid')
                                        <div
                                            class="error_holder">@include('back.common.validation', ['message' =>  $message ])</div> @enderror
                                        {!! CForm::inputGroupFooter() !!}
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        {!! CForm::inputGroupHeader(__("common.full_name")) !!}
                                        <input type="text" class="form-control"
                                               wire:model.defer="full_name"
                                               required>
                                        @error('full_name')
                                        <div
                                            class="error_holder">@include('back.common.validation', ['message' =>  $message ])</div> @enderror
                                        {!! CForm::inputGroupFooter() !!}
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        {!! CForm::inputGroupHeader(__("common.email")) !!}
                                        <input type="email" class="form-control"
                                               wire:model.lazy="email"
                                               required>
                                        @error('email')
                                        <div>
                                            class="error_holder">@include('back.common.validation', ['message' =>  $message ])</div> @enderror
                                        {!! CForm::inputGroupFooter() !!}
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        {!! CForm::inputGroupHeader("Gender") !!}
                                           <select wire:model.defer="gender" class="form-control">
                                                           <option value="MALE">Male</option>
                                                           <option value="FEMALE">Female</option>

                                            </select>
                                        @error('email')
                                        <div>
                                            class="error_holder">@include('back.common.validation', ['message' =>  $message ])</div> @enderror
                                        {!! CForm::inputGroupFooter() !!}
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 mb-2">
                                        {!! CForm::inputGroupHeader(__("common.password")) !!}
                                        <input type="password" @if($mode=="create") required
                                               @endif class="form-control" wire:model.defer="password">
                                        @error('password')
                                        <div
                                            class="error_holder">@include('back.common.validation', ['message' =>  $message ])</div> @enderror
                                        {!! CForm::inputGroupFooter() !!}
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        {!! CForm::inputGroupHeader(__("common.confirm_password")) !!}
                                        <input type="text" class="form-control" @if($mode=="create") required
                                               @endif wire:model.defer="password_confirmation">
                                        @error('password_confirmation')
                                        <div
                                            class="error_holder">@include('back.common.validation', ['message' =>  $message ])</div> @enderror
                                        {!! CForm::inputGroupFooter() !!}
                                    </div>
                                </div>
                                <div class="form-row">

                                    <div class="col-md-6 mb-2">
                                        {!! CForm::inputGroupHeader(__("course.course")) !!}
                                        <select wire:model="selcourse" class="form-control">
                                            <option value="">--{{__("common.select")}}--</option>
                                            @foreach($common::getAllCourses() as $course)
                                                <option value="{{$course->id}}">{{$course->name}}</option>
                                            @endforeach
                                        </select>
                                        {!! CForm::inputGroupFooter() !!}
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">{{__("course_year.cy")}}</span>
                                            </div>
                                            <select wire:model.defer="sel_year" class="form-control">
                                                <option value="">--{{__("common.select")}}--</option>
                                                 @foreach(\App\Models\Course_Year::where("course_id",$this->selcourse)->get() as $obj)
                                                    @if($obj->course_id)
                                                           <option value="{{$obj->course_year_id}}">{{$common::getCourseYearName($obj->course_year_id)}}</option>


                                                    @endif
                                                @endforeach
                                            </select>

                                            <div class="input-group-append">
                                                <button class="btn btn-sm btn-dark" type="button"
                                                        wire:click="assign">
                                                    <i class="far fa-plus-square"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <div class="form-row">
                                    <div class="col-md-12 mb-2">
                                        {!! CForm::inputGroupHeader(__("common.phone")) !!}
                                        <input type="text" class="form-control w-100"
                                               wire:model.defer="phone">
                                        @error('phone')
                                        <div
                                            class="error_holder">@include('back.common.validation', ['message' =>  $message ])</div> @enderror
                                        {!! CForm::inputGroupFooter() !!}
                                    </div>

                                </div>
                                <div class="form-row">
                                    <div class="col-md-12 mb-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span
                                                    class="input-group-text">{{__("common.attach")}} {{$mode=="edit"?"ed":""}} {{__("common.role")}}</span>
                                            </div>
                                            <div class="form-control" style="display: inline-table;">
                                                @foreach($roles as $role)
                                                    @if($role->name == "super admin") @continue @endif
                                                    <div
                                                        class="custom-control custom-checkbox custom-control-inline">
                                                        <input type="radio" id="chk_{{$role->id}}"
                                                               name="attached_role_ids"
                                                               class="custom-control-input"
                                                               wire:model.defer="attached_role_ids"
                                                               value="{{$role->id}}"
                                                               @if($mode=="edit" && gettype($attached_role_ids) == "object" && $attached_role_ids->contains($role->id)) checked @endif/>
                                                        <label for="chk_{{$role->id}}"
                                                               class="custom-control-label">{{Str::title($role->name)}}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12 mb-2">

                                        {!! CForm::inputGroupHeader(__("common.address")) !!}
                                        <textarea class="form-control"
                                                  wire:model.defer="address"></textarea>
                                        @error('address')
                                        <div
                                            class="error_holder">@include('back.common.validation', ['message' =>  $message ])</div> @enderror
                                        {!! CForm::inputGroupFooter() !!}
                                    </div>
                                    <div class="col-md-6 col-12 mb-2">

                                        {!! CForm::inputGroupHeader(__("common.about_me")) !!}
                                        <textarea class="form-control"
                                                  wire:model.defer="about_me"></textarea>
                                        @error('about_me')
                                        <div
                                            class="error_holder">@include('back.common.validation', ['message' =>  $message ])</div> @enderror
                                        {!! CForm::inputGroupFooter() !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row mt-2">
                            <table class="table table-hover table-sm">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{__("course.course")}}</th>
                                    <th scope="col">{{__("common.course_year")}}</th>
                                    <th scope="col">{{__("common.action")}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($assigned_to)
                                    @php $cnt = 1 ; @endphp
                                    @foreach($assigned_to as $index => $course_year)
                                        @foreach($course_year as $course=>$year)
                                            <tr>
                                                <td>{{print_r($cnt)}}</td>
                                                <td>{{$common::getCourseName($course)}}</td>
                                                <td>{{$common::getCourseYearName($year)}}</td>
                                                <td>
                                                    <button
                                                        onclick="lv_confirm_then_submit(this,'{{__("common.cnf_del")}}','deleteThisEntry','{\'cs_id\':{{$course}},\'cy_id\':{{$year}}}')"
                                                        type="button"
                                                        class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @php $cnt = $cnt + 1; @endphp
                                        @endforeach
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="100">
                                            <div class="alert alert-dark">{{__("common.no_data_exist")}}</div>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="form-row">
                            <button class="btn btn-sm btn-dark" @if(!$submit_status) disabled @endif
                            type="submit"><i
                                    class="fas fa-save mr-1"></i>{{__($mode=="create"? "common.create" : "common.update")}} {{__("common.user")}}
                            </button>
                            <button class="btn btn-sm btn-danger ml-1" data-toggle="tooltip" data-placement="top"
                                    title="{{__("common.clear_form")}}"
                                    wire:click="clearAll">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    @endif
    <div class="card">
        <div class="card-header blue">
            @if($page_mode=="promotion")
                <span class="card-header-title">{{__("commonv2.mng_promotion")}}</span>
                @if($selectAll)
                    <small style="padding-left: 2%;">{{__("commonv2.select_stud_cnt",["cnt"=>count($sel_uid)])}}</small>
                @endif
            @else
                <span class="card-header-title">{{__("common.mng_users")}}</span>
            @endif
            <button type="button" wire:click="addUserBtn" class="btn btn-sm btn-dark float-right"><i
                    class="fas fa-plus-circle mr-1"></i>{{__("common.add_user")}}</button>
        </div>
        <div class="card-body yellow">
            @if($page_mode=="promotion")
                <div class="form-row">
                    <div class="form-group col-md-5 col-12 mb-2">
                        <label>{{__("commonv2.select_course")}}</label>
                        <select class="form-control" wire:model="selected_course_id">
                            <option value="">{{__("common.select")}}</option>
                            @foreach($all_courses as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-5 col-12 mb-2">
                        <label>{{__("commonv2.select_year")}}</label>
                        <select class="form-control" wire:model="selected_course_year_id">
                            <option value="">{{__("common.select")}}</option>
                            @foreach($all_course_years as $item)
                                <option
                                    value="{{$item->course_year_id}}">{{$common::getCourseYearName($item->course_year_id)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-2 col-12 mb-2">
                        <label class="d-block">-</label>
                        <button type="button" wire:click="promoteUsers()" class="btn btn-sm btn-dark mb-3"
                                style="height: 37px;">
                            <i class="far fa-id-card mr-1"></i>{{__("commonv2.promote_user")}}
                        </button>
                    </div>

                </div>
            @endif
            <div class="form-row">
                <div class="form-group col-md-8 col-12">
                    <label>{{__("common.advanced_filter")}}</label>
                    <input type="text" class="form-control" wire:model.lazy="filter_keyword"
                           placeholder="{{__("common.ty_and_tab")}}"/>
                </div>
                <div class="form-group col-md-4 col-12">
                    <label>{{__("common.filter_by_role")}}</label>
                    <select class="form-control" wire:model="filter_role">
                        <option value="" selected>--{{__("common.select")}}--</option>
                        <option value="in_active">{{__("common.show_non_activated_users")}}</option>
                        @foreach(\Spatie\Permission\Models\Role::all() as $rl)
                            <option value="{{$rl->name}}"> {{Str::title($rl->name)}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-12">
                    {{--                    wire:click="confirm('deleteBulk','sel_uid');"--}}
                    <button type="button" onclick="confirm_and_submit(this,'deleteBulk')"
                            class="btn btn-sm btn-dark mb-3"><i
                            class="far fa-trash-alt mr-1"></i>{{__("common.del_user")}}
                    </button>
                    <button type="button" wire:click="toggleUserStatus()" class="btn btn-sm btn-dark mb-3"><i
                            class="fas fa-sort mr-1"></i>{{__("common.toggle_stats")}}
                    </button>
                    <button type="button" wire:click="printIdCards()" class="btn btn-sm btn-dark mb-3 d-none"><i
                            class="far fa-id-card mr-1"></i>{{__("commonv2.print_id_cards")}}
                    </button>

                    <form method="post" class="float-right mb-3" action="{{route('users.import')}}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="d-inline">
                            {!! CForm::inputGroupHeader(__('common.imp_users')) !!}
                            <input type="file" name="file" class="form-control text-sm">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-sm btn-dark mr-1"><i
                                        class="fas fa-upload mr-1"></i>{{__("common.import_usr")}}
                                </button>
                                <a href="{{asset('uploads/users_list.csv')}}" style="padding-top: 7px;"
                                   data-toggle="tooltip" data-placement="left"
                                   title="{{__("common.download_template")}}" href="{{asset('uploads/users_list.csv')}}"
                                   class="btn btn-sm btn-dark"><i class="fas fa-download"></i>
                                </a>
                            </div>
                            {!! CForm::inputGroupFooter() !!}
                        </div>
                    </form>

                </div>
                @if(session()->has("form_list") && session()->get("form_list"))
                    <div class="form-group col-12">
                        @include("common.messages")
                    </div>
                @endif
                <div class="form-group col-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-sm mt-1">
                            <thead>
                            <tr>
                                <th scope="col"><input type="checkbox" wire:model="selectAll"></th>
                                <th scope="col">{{__("common.uid")}}</th>
                                <th scope="col">{{__("common.img")}}</th>

                                <th scope="col">{{__("common.name")}}</th>
                                <th scope="col">{{__("common.email")}}</th>
                                <th scope="col">{{__("common.role")}}</th>
                                <th scope="col">{{__("common.created_on")}}</th>
                                <th scope="col">{{__("common.action")}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                use App\Models\UserMeta;
                                use Illuminate\Support\Facades\Auth;
                            @endphp
                            @if(($users instanceof \Illuminate\Pagination\LengthAwarePaginator && $users->total()) or count($users))
                                @foreach($users as $user)
                                    <tr>

                                        <td><input type="checkbox" wire:model.defer="sel_uid" ,
                                                   value="{{$user->id}}"></td>
                                        <td>{{$user->id}}</td>

                                        <td class="text-center"><img style="width: 50px;"
                                                                     src="{{asset("uploads/".$user->get_user_image())}}"
                                                                     class="rounded-lg"/></td>

                                        <td>{{Str::title($user->name)}}
                                            @php $proof = $user->get_proof() @endphp
                                            @if($proof && !empty($proof))
                                                <a target="_blank" href="{{asset('uploads/'.$proof)}}"
                                                   class="btn btn-link ml-1"><i class="fas fa-paperclip"></i></a> @endif
                                        </td>
                                        <td>{{$user->email}}</td>
                                        <td>
                                            @foreach($user->roles as $role)
                                                <span
                                                    class="badge badge-dark">{{Str::title($role->name)}}</span>
                                            @endforeach
                                            @php
                                                $user_meta = UserMeta::where("user_id",$user->id)->first();
                                                $assigned_on = null;
                                                if($user_meta){
                                                    $assigned_on = json_decode($user_meta->get_assign());
                                                }
                                            @endphp
                                            @if(is_countable($assigned_on))
                                                @foreach($assigned_on as $items)
                                                    @foreach($items as $course=>$year)
                                                        <span
                                                            class="badge badge-dark">
                                                         {{$common::getCourseName($course)}} | {{$common::getCourseYearName($year)}}
                                                    </span>
                                                        <br/>
                                                    @endforeach
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>{{$user->created_at}}</td>
                                        <td>

                                            <button data-toggle="tooltip" data-placement="top"
                                                    title="{{__("common.pl_click_to_a_d")}}"
                                                    @if(in_array("super admin",$user->roles->pluck('name')->toArray())) disabled
                                                    @endif
                                                    onclick="lv_confirm_then_submit(this,'@if($user->active) {{__("common.pl_click_deactive")}} @else {{__("common.cnf_admin_this_user")}} @endif'
                                                        ,'changeUserStatus','{\'id\':{{$user->id}}}')"
                                                    type="button"
                                                    class="btn btn-sm  @if($user->active) btn-success @else btn-warning @endif float-left action_btn">
                                                @if($user->active)
                                                    <i class="far fa-thumbs-up"></i>
                                                @else
                                                    <i class="far fa-thumbs-down"></i>
                                                @endif
                                            </button>

                                            <button type="button" wire:click="editUser('{{$user->id}}')"
                                                    class="btn btn-sm btn-dark float-left action_btn">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <button
                                                @if(in_array("super admin",$user->roles->pluck('name')->toArray())) disabled
                                                @endif
                                                onclick="lv_confirm_then_submit(this,'{{__("common.cnf_del")}}'
                                                    ,'deleteUser','{\'id\':{{$user->id}}}')" type="button"
                                                class="btn btn-sm btn-danger float-left action_btn">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>

                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="100">
                                        <div class="alert alert-dark">{{__("common.no_data_exist")}}</div>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        @if($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            {{$users->links()}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
