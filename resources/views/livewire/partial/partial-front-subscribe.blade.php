<div>
    @php
        /* @var \App\Facades\Util $util */
        /* @var \App\Facades\Common $common */
    @endphp
    <form wire:submit.prevent="save_sub">
        @error('sub_email') @include('back.common.validation', ['message' =>  $message ]) @enderror
        @if(session()->has('form_front_subs') && session()->get('form_front_subs'))
            @include("common.messages")
        @endif
        <div class="input-group">
            <input type="email" class="form-control br-50px mt-8" wire:model="sub_email" required/>
            <span class="btn_sub_holder">
                <button type="submit"
                        class="btn btn-sm font-size-14px btn-black mt-5 br-50px">{{__("common.subscribe")}}</button></span>

        </div>
    </form>
    <style>
        .badge-danger {
            background-color: red;
        }

        .mt-8 {
            margin-top: 8px;
        }

        .btn-cust:hover {
            color: #f9f9f9;;
            text-decoration: none;
        }

        .font-size-14px {
            font-size: 14px;
        }

        .br-50px {
            border-radius: 50px !important;
        }

        .btn_sub_holder {
            float: right;
            position: relative;
            left: 37px;
            top: -41px;
        }

        .btn-black {
            background: rgb(0 0 0) !important;
            color: white !important;
        }

        .btn_sub_holder button {
            padding: 8px !important;
            border-radius: 50px !important;
            font-size: 13px;
        }
    </style>
</div>

