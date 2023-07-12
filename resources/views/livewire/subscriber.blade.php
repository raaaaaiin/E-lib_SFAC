<div>
    @php
        /* @var \App\Facades\Util $util */
        /* @var \App\Facades\Common $common */
    @endphp
    <div class="card">
        <div class="card-header blue">
            <a href="{{route('subscriber-mng.exportSubs')}}" class="btn btn-dark btn-sm"><i
                    class="fas fa-download mr-1"></i>{{__("common.export_subscriber")}}</a> | <a
                href="{{route('subscriber-mng.exportSubs')}}?active=1" class="btn btn-dark btn-sm"><i
                    class="fas fa-download mr-1"></i>{{__("common.export_active_subscriber")}}</a></div>
        <div class="card-body yellow">
            @if(session()->has("form_subscriber") && session()->has("form_subscriber"))
                <div class="row">
                    <div class="col-12">
                        @include("common.messages")
                    </div>
                </div>
            @endif

            <form class="col-12" role="form" wire:submit.prevent="">
                <div class="form-row">

                    <div class="col-12 mb-2">
                        <div class="input-group">
                            <div class="input-group-prepend"><span
                                    class="input-group-text">{{__("common.subscriber_email")}}</span></div>
                            <div class="form-control border-0 p-0">
                                <input type="email" class="form-control"
                                       wire:model.debounce.1000ms="email">
                            </div>
                            <div class="input-group-append">
                                <input type="checkbox" class="form-control email_status" data-toggle="toggle"
                                       data-on="Active" data-off="InActive" wire:model="email_status"/>
                            </div>
                        </div>
                        <div
                            class="w-100">@error('email') @include('back.common.validation', ['message' =>  $message ]) @enderror</div>
                    </div>


                    <div class="col-12">
                        <button wire:click="saveSubscriber"
                                class="btn btn-sm btn-dark btn-block">
                            @if($mode=="create")
                                <i class="fas fa-plus-circle"></i>
                                {{__("common.create")}}
                            @else
                                <i class="fas fa-save"></i>
                                {{__("common.update")}}
                            @endif
                            {{__("common.subs")}}
                        </button>
                    </div>
                </div>
            </form>
            <div class="col-12 mt-2">
                <table class="table table-hover table-sm">
                    <thead>
                    <tr>
                        <th scope="col">{{__("common.id")}}</th>
                        <th scope="col">{{__("common.subs")}}</th>
                        <th scope="col">{{__("common.status")}}</th>
                        <th scope="col">{{__("common.action")}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($subscribers->total())
                        @foreach($subscribers as $subscriber)
                            <tr>
                                <td>{{$subscriber->id}}</td>
                                <td>{{$subscriber->email}}</td>
                                <td>
                                    <input class="list_chk" type="checkbox"
                                           {{$subscriber->active ? "checked" : ""}} disabled data-toggle="toggle"
                                           data-on="Active" data-off="InActive">
                                </td>
                                <td>


                                    <button type="button" wire:click="editSubscriber({{$subscriber->id}})"
                                            class="btn float-left btn-sm btn-dark action_btn">
                                        <i class="far fa-edit"></i>
                                    </button>
                                    <button
                                        onclick="lv_confirm_then_submit(this,'{{__("common.cnf_del")}}','deleteSubscriber','{\'id\':{{$subscriber->id}}}')"
                                        type="button"
                                        class="btn float-left btn-sm btn-danger action_btn">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>

                                </td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4">
                                <div class="alert alert-dark">{{__("common.no_subs")}}</div>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                {{$subscribers->links()}}
            </div>
        </div>
    </div>
</div>

