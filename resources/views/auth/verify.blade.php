@extends('auth.master')

@section('content')
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">{{ __('You are only one step a way from your new password, recover your password now.') }}</p>
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif
            {{ __('Before proceeding, please check your email for a verification link.') }}
            {{ __('If you did not receive the email') }}, <a
                href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
        </div>
    </div>
@endsection







