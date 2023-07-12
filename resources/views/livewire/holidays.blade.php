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

                    <div class="col-md-3 col-12 mb-2 {{$give_to_role_holder}}">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Date</span>
                            </div>
                            <input wire:model="issue_date_tmp" class="form-control"
                                    name="issue_date_tmp"
                                    id="issue_date_tmp">

                            </input>
                        </div>
                    </div>
                    <div class="col-md-3 col-12 mb-2 {{$give_to_role_holder}}">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">To: *Leave blank if single date only</span>
                            </div>
                            <input wire:model="to_date" class="form-control"
                                    name="to_date"
                                    id="to_date">

                            </input>
                        </div>
                    </div>
                    <div class="col-md-3 col-12 mb-2 {{$give_to_user_holder}}">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Reason : Holiday Or Suspension</span>
                            </div>
                            <input wire:model.lazy="reason" class="form-control"
                                    id="reason" name="reason">


                            </input>
                        </div>
                    </div>
                    <div class="col-md-2 col-12 mb-2 {{$give_to_user_holder}}">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Coverage</span>
                            </div>
                            <Select wire:model="coverage" class="form-control"
                                    id="coverage" name="coverage">
                                    <option>--</option>
                                   <option>Yearly</option>
                                   <option>This Year</option>

                            </Select>
                        </div>
                    </div>

                    <div class="col-md-1 col-12">
                        <div class="input-group">
                         <div class="input-group-prepend">
                                <span class="input-group-text">Submit</span>
                            </div>
                            <button type="submit" class="btn btn-dark btn-sm">
                                <i class="fas fa-plus-circle mr-1"></i>Add Holiday
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
                        <th scope="col" style="width: 25%;">Date</th>
                        <th scope="col" style="width: 25%;">To Date</th>
                        <th scope="col" style="width: 30%;">Reason</th>

                        <th style="width: 12%;" scope="col">{{__("common.action")}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($notices->total())
                        @foreach($notices as $notice)
                            <tr>
                                <td>{{$notice->id}}</td>
                                <td>{{$notice->noticedate}}</td>
                                <td>{{$notice->noticetodate}}</td>
                                <td>
                                  {{$notice->notice}}
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
            {{$notices->links()}}
        </div>
    </div>

    <script src="{{asset('js/jquery-1.12.4.js')}}"></script>
<script src="{{asset('js/jquery-ui.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
    <script>
    let x;
    let y;
    $(document).ready(function() {
    $("#issue_date_tmp").datepicker({

            todayHighlight: false,
        dateFormat: 'mm/dd/yy',
        altField: "#issue_date",
        altFormat: 'mm/dd/yy',
        onSelect: function () {
         x =$("#issue_date_tmp").val();

     window.livewire.emit('data_manager', {"issue_date": x});


         $("#to_date").datepicker({

            todayHighlight: false,
        dateFormat: 'mm/dd/yy',
        minDate:x,
        altField: "#issue_date",
        altFormat: 'mm/dd/yy',
        onSelect: function () {
          y =$("#to_date").val();

    window.livewire.emit('data_manager', {"to_date": y});


         }
    }).datepicker();











         }
    }).datepicker("setDate", new Date());

});



    </script>
</div>


