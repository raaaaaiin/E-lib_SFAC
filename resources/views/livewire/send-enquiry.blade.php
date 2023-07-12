<div class="w-100">
    @php
        /* @var \App\Facades\Util $util */
        /* @var \App\Facades\Common $common */
    @endphp
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    @if(Session::has("frm_contact_us") && Session::get("frm_contact_us"))
    @include("common.messages")
    @endif
    <form id="contact-form" wire:submit.prevent="sendMessage">
        <div class="row">
            <div class="col-md-6">
                <div class="form-input mt-25">
                    <label>{{__("common.name")}}</label>
                    <div class="input-items default">
                        <input wire:model.derfer="name" required type="text" placeholder="{{__("common.name")}}">
                        <i class="lni lni-user"></i>
                    </div>
                    @error('name')
                    <div
                        class="error_holder"> @include('back.common.validation', ['message' =>  $message ]) </div> @enderror
                </div> <!-- form input -->
            </div>
            <div class="col-md-6">
                <div class="form-input mt-25">
                    <label>{{__("common.email")}}</label>
                    <div class="input-items default">
                        <input type="email" wire:model.defer="email" required placeholder="{{__("common.email")}}">
                        <i class="lni lni-envelope"></i>
                    </div>
                    @error('email')
                    <div
                        class="error_holder"> @include('back.common.validation', ['message' =>  $message ]) </div> @enderror
                </div> <!-- form input -->
            </div>
            <div class="col-md-12">
                <div class="form-input mt-25">
                    <label>{{__("common.subject")}}</label>
                    <div class="input-items default">
                        <input type="text" wire:model.defer="subject" required placeholder="{{__("common.subject")}}">
                        <i class="lni lni-pencil-alt"></i>
                    </div>
                    @error('subject')
                    <div
                        class="error_holder"> @include('back.common.validation', ['message' =>  $message ]) </div> @enderror
                </div> <!-- form input -->
            </div>
            <div class="col-md-12">
                <div class="form-input mt-25">
                    <label>{{__("common.message")}}</label>
                    <div class="input-items default">
                        <textarea wire:model.defer="message" required placeholder="{{__("common.message")}}"></textarea>
                        <i class="lni lni-mic"></i>
                    </div>
                    @error('message')
                    <div
                        class="error_holder"> @include('back.common.validation', ['message' =>  $message ]) </div> @enderror
                </div> <!-- form input -->
            </div>
            <p class="form-message"></p>
            <div class="col-md-12">
                <div class="form-input light-rounded-buttons mt-30">
                    <button type="submit" class="main-btn light-rounded-two">{{__("common.send_msg")}}</button>
                </div> <!-- form input -->
            </div>
        </div> <!-- row -->
    </form>
</div>
