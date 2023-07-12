<div>
    @php
        /* @var \App\Facades\Util $util */
        /* @var \App\Facades\Common $common */

    @endphp
    @php
        use Spatie\Permission\Models\Role;
        use \App\Models\User;
        use \Illuminate\Support\Str;
    @endphp
    @include("back.common.spinner")
    <div class="row">
        <div class="card card-dark card-outline col-12">
            <div class="card-body pb-0">
                @if(session()->has("form_permission") && session()->get("form_permission"))
                    <div class="row">
                        <div class="col-12">
                            @include("common.messages")
                        </div>
                    </div>
                @endif
                <div class="row">

                    <div class="card col-md-6 col-12">
                        <div class="card-body yellow">
                            <form role="form" wire:submit.prevent="saveRole">
                                <div class="input-group">
                                    <input type="text" placeholder="{{__('common.ent_role_name')}}"
                                           wire:model.lazy="role_name"
                                           class="form-control"/>
                                    <div class="input-group-append">
                                        <button class="btn btn-sm btn-dark"
                                                type="submit"><i
                                                class="fas fa-save mr-1"></i>{{__($role_mode=="edit"?"common.update":"common.save")}} {{__("common.role")}}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">

                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label>{{__("common.select")}} {{__("common.role")}} : </label>
                                    <form role="form" wire:submit.prevent="deleteRole">
                                        <div class="input-group">
                                            <select class="custom-select" wire:model="role_id">
                                                <option value="">--{{__("common.select")}} {{__("common.role")}}--
                                                </option>
                                                @foreach($roles as $role_obj)
                                                    <option
                                                        value="{{$role_obj->id}}">{{Str::title($role_obj->name)}}</option>
                                                @endforeach
                                            </select>
                                            <div class="input-group-append">
                                                <button type="button" @if(in_array($role_id,$common::getListOfDefaultRoles(true))) disabled @endif
                                                        wire:click="editRoleName({{$role_id}})"
                                                        class="btn btn-sm btn-dark">
                                                    <i class="far fa-edit"></i>
                                                </button>

                                                <button
                                                    @if(in_array($role_id,$common::getListOfDefaultRoles(true))) disabled @endif
                                                    onclick="lv_confirm_then_submit(this,'{{__("common.cnf_del_role")}}','deleteRole','{\'id\':{{$role_id}}}')"
                                                    type="button"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="form-group col-6">
                                    <label class="d-none d-sm-block">{{__("common.chs_per_frm_here")}} </label>
                                    <label class="d-block d-sm-none">{{__("commonv2.chs_per_frm_here_small")}} </label>
                                    <form role="form" wire:submit.prevent="deletePermission">
                                        <div class="input-group">
                                            <select class="custom-select" wire:model="permission_id">
                                                <option value="">--{{__("common.select")}} {{__("common.permission")}}
                                                    --
                                                </option>
                                                @foreach($permissions as $permission_obj)
                                                    <option
                                                        value="{{$permission_obj->id}}">{{$permission_obj->name}}</option>
                                                @endforeach
                                            </select>
                                            <div class="input-group-append">
                                                <button type="button" @if(in_array($permission_id,$common::getListOfDefaultPermissions(true))) disabled @endif
                                                        wire:click="editPermissionName({{$permission_id}})"
                                                        class="btn btn-sm btn-dark">
                                                    <i class="far fa-edit"></i>
                                                </button>
                                                <button
                                                    type="button" @if(in_array($permission_id,$common::getListOfDefaultPermissions(true))) disabled @endif
                                                    onclick="lv_confirm_then_submit(this,'{{__("common.cnf_del_perm")}}','deletePermission','{\'id\':{{$permission_id}}}')"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <button type="button" wire:click="assignPermissionToRole"
                                            class="btn btn-sm btn-block btn-dark">{{__("common.assign_perm_role")}}
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card col-md-6 col-12">
                        <div class="card-body yellow">
                            <form role="form" wire:submit.prevent="savePermission">
                                <div class="input-group">
                                    <input type="text" placeholder="{{__('common.ent_perm_name')}}"
                                           wire:model.lazy="permission_name" class="form-control"/>
                                    <div class="input-group-append">
                                        <button class="btn btn-sm btn-dark"
                                                type="submit"><i
                                                class="fas fa-save mr-1"></i>{{__($permission_mode=="edit"?"common.update":"common.save")}} {{__("common.perm")}}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">
                            <form role="form" wire:submit.prevent="">
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label>{{__("common.select")}} {{__("common.user")}} : </label>
                                        <select class="custom-select" wire:model="user_id">
                                            <option value="">--{{__("common.select")}} {{__("common.user")}}--</option>
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">{{Str::title($user->name)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-6">
                                        <label class="d-none d-sm-block">{{__("common.chs_role_frm_here")}}</label>
                                        <label
                                            class="d-block d-sm-none">{{__("commonv2.chs_role_frm_here_small")}}</label>
                                        <select class="custom-select" wire:model="assigned_role_id">
                                            <option value="">--{{__("common.select")}} {{__("common.role")}}--</option>
                                            @foreach($roles as $role)
                                                <option value="{{$role->id}}">{{Str::title($role->name)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-12">
                                        <button type="button" wire:click="attachRoleToUser"
                                                class="btn btn-sm btn-block btn-dark">{{__("common.ass_role_to_usr")}}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer pt-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-sm mt-2">
                        <thead>
                        <tr>
                            <th scope="col">{{__("common.roles")}}</th>
                            <th scope="col">{{__("common.permissions")}}</th>
                            <th style="width: 20%;" scope="col">{{__("common.user_attached")}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td><span class="badge rounded-pill bg-danger">{{Str::title($role->name)}}</span>
                                </td>
                                <td>
                                    @php
                                        $items = Role::findById($role->id)->permissions
                                    @endphp

                                    @foreach($items as $item)

                                        <span class="badge rounded-pill badge-dark">
                                             {{$item->name}}

                                                 <button
                                                     onclick="lv_confirm_then_submit(this,'{{__("common.cnf_delete_perm_from_role")}}','detachPermissionFromRole','{\'id\':{{$item->id}},\'role_id\':{{$role->id}}}')"
                                                     type="button"
                                                     class="close no-outline">
                                                     <span aria-hidden="true">&times;</span>
                                                </button>

                                            </span>


                                        {{--                                            <li class="list-group-item d-flex justify-content-between align-items-center">--}}
                                        {{--                                                {{$item->name}}--}}
                                        {{--                                                <button--}}
                                        {{--                                                    onclick="confirm('{{__("role.dt_perm_frm_role")}}') || event.stopImmediatePropagation()"--}}
                                        {{--                                                    type="button"--}}
                                        {{--                                                    wire:click="detachPermissionFromRole({{$item->id}},{{$role->id}})"--}}
                                        {{--                                                    class="btn btn-sm btn-danger">--}}
                                        {{--                                                    <i class="fas fa-trash-alt"></i>--}}
                                        {{--                                                </button>--}}
                                        {{--                                            </li>--}}
                                    @endforeach

                                </td>
                                <td>

                                    @php
                                        $items = User::role($role->name)->get()
                                    @endphp
                                    {{--                                        <span class="badge bg-info text-dark">Info</span>--}}

                                    @foreach($items as $item)
                                        <span class="badge bg-info rounded-pill text-dark">
                                                {{$item->name}}
                                                <button
                                                    onclick="lv_confirm_then_submit(this,'{{__("common.cnf_dt_usr_frm_role")}}','detachUserFromRole','{\'id\':{{$item->id}},\'role_id\':{{$role->id}}}')"
                                                    type="button"
                                                    class="close no-outline" aria-label="Dismiss">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </span>
                                    @endforeach



                                    {{--                                        @foreach($items as $item)--}}
                                    {{--                                            <li class="list-group-item d-flex justify-content-between align-items-center">--}}
                                    {{--                                                {{$item->name}}--}}
                                    {{--                                                <button--}}
                                    {{--                                                    onclick="confirm('{{__("role.dt_usr_frm_role")}}') || event.stopImmediatePropagation()"--}}
                                    {{--                                                    type="button"--}}
                                    {{--                                                    wire:click="detachUserFromRole({{$item->id}},{{$role->id}})"--}}
                                    {{--                                                    class="btn btn-sm btn-danger">--}}
                                    {{--                                                    <i class="fas fa-trash-alt"></i>--}}
                                    {{--                                                </button>--}}
                                    {{--                                            </li>--}}
                                    {{--                                        @endforeach--}}

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
<style>
    /*.badge {*/
    /*    padding-left: 10px;*/
    /*    padding-top: 5px;*/
    /*    padding-bottom: 5px;*/
    /*    margin: 2px;*/
    /*    padding-right: 10px;*/
    /*}*/


    .badge .close {
        padding-right: 11px;
        padding-left: 5px;
        margin-right: -10px;
        font-size: inherit;
        color: inherit;
        text-shadow: none;
    }


</style>
