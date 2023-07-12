<div>
    @php
        /* @var \App\Facades\Util $util */
        /* @var \App\Facades\Common $common */
    @endphp
    <div class="card" id="notice_holder">
        <div class="card-body yellow">

            @if(session()->has("form_notice") && session()->has("form_notice"))
                <div class="row">
                    <div class="col-12">
                        @include("common.messages")
                    </div>
                </div>
            @endif

            <form id="frm_notice" wire:submit.prevent="add_notice">
                @csrf
                <div class="form-row">
                    <input type="hidden" name="mode" wire:model="mode"/>
                    <input type="hidden" name="id" wire:model="selected_id"/>
                    <div class="col-md-12 col-12 mb-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{__("common.wrt_notice")}}</span>
                            </div>
                            <textarea wire:model.lazy="notice" class="form-control" name="notice"
                                      id="notice"
                                      rows="10"></textarea>
                        </div>
                    </div>

                    <div class="col-md-6 col-12 mb-2 {{$give_to_role_holder}}">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{__("common.ass_to_role")}}</span>
                            </div>
                            <select wire:ignore class="form-control select2-multiple"
                                    name="give_to_role[]"
                                    multiple="multiple" id="give_to_role">
                                @foreach($common::getAllRoles() as $role)
                                    <option
                                        value="{{$role->id}}"
                                        @if(in_array($role->id,$give_to_role)) selected @endif>{{Str::title($role->name)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 mb-2 {{$give_to_user_holder}}">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{__("common.ass_to_user")}}</span>
                            </div>
                            <select wire:ignore class="form-control select2-multiple"
                                    name="give_to_user[]"
                                    id="give_to_user" multiple="multiple">
                                @foreach($common::getAllUsers() as $user)
                                    <option
                                        value="{{$user->id}}"
                                        @if(in_array($user->id,$give_to_user)) selected @endif>{{Str::title($user->name)}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                                <span class="input-group-text">{{__("common.or")}} {{__("common.show_in")}} <i
                                                        class="fas fa-info-circle ml-1 mt-1" data-toggle="tooltip"
                                                        data-placement="top"
                                                        title="{{__('Show to all your website visitors.')}}"></i> </span>
                            </div>
                            <select wire:model="show_in" name=show_in" class="form-control">
                                <option value="back_end">{{__("common.backend")}}</option>
                                <option value="front_end">{{__("common.frontend")}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="input-group">
                            <button type="submit" class="btn btn-dark btn-sm">
                                <i class="fas fa-plus-circle mr-1"></i>{{__("common.push_notice")}}
                            </button>
                        </div>
                    </div>


                </div>
            </form>

        </div>
    </div>
    <div class="card">
        <div class="card-body yellow">
            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead>
                    <tr>
                        <th scope="col">{{__("common.id")}}</th>
                        <th scope="col" style="width: 70%;">{{__("common.notice")}} {{__("common.msg")}}</th>
                        <th scope="col">{{__("common.ass_to_role")}}</th>
                        <th scope="col">{{__("common.ass_to_user")}}</th>
                        <th style="width: 12%;" scope="col">{{__("common.action")}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($notices->total())
                        @foreach($notices as $notice)
                            <tr>
                                <td>{{$notice->id}}</td>
                                <td>{{$notice->notice}}</td>
                                <td>
                                    @if(count($notice->role_id))
                                        @foreach($notice->role_id as $role_id)
                                            <span
                                                class="badge bg-info text-dark">{{Str::title($common::getRoleName($role_id))}}</span>
                                        @endforeach
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(count($notice->user_id))
                                        @foreach($notice->user_id as $user_id)
                                            <span
                                                class="badge bg-dark">{{Str::title($common::getUserName($user_id))}}</span>
                                        @endforeach
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if($notice->active)
                                        <button title="{{__('common.active_and_visible')}}"
                                                class="btn btn-sm btn-primary action_btn float-left" type="button"
                                                wire:click="noticeStatus({{$notice->id}},0)"><i class="far fa-eye"></i>
                                        </button>
                                    @else
                                        <button title="{{__('common.deactive_and_visible')}}"
                                                class="btn btn-sm btn-primary action_btn float-left" type="button"
                                                wire:click="noticeStatus({{$notice->id}},1)"><i
                                                class="far fa-eye-slash"></i></button>
                                    @endif
                                    <button wire:click="editNotice({{$notice->id}})" type="button"
                                            class="btn btn-sm btn-dark btn_edit action_btn float-left">
                                        <i class="far fa-edit"></i>
                                    </button>
                                    

                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="100">
                                <div class="alert alert-dark">{{__("common.no_notice_exist")}}</div>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


