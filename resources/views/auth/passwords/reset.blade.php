@php
    /* @var \App\Facades\Util $util */
    /* @var \App\Facades\Common $common */
@endphp
@extends('auth.master')
@section('content')
    <div class="container">
        <div class="col-12">
            <!-- /.login-logo -->
            <div style="margin-top: 5% !important;" class="card col-md-4 m-auto">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">{{ __('You are only one step a way from your new password, recover your password now.')}}</p>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token"
                               value="{{$util::getFileNameFromUrl(request()->url(),false)}}"/>
                        <div class="input-group mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ $util::getIfNotEmpty($email) ?? old('email') }}" required
                                   autocomplete="email" autofocus>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope-o"></span>
                                </div>
                            </div>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   name="password"
                                   required autocomplete="new-password" placeholder="{{ __('Password') }}">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" name="password_confirmation" required
                                   autocomplete="new-password" placeholder="{{ __('Confirm Password') }}">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit"
                                        class="btn btn-dark btn-sm btn-block"> {{ __('Reset Password') }}</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                    @if(request()->has("login"))
                        <p class="mt-3 mb-1">
                            <a href="{{route('login')}}">Login</a>
                        </p>
                    @endif
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
    </div>
@endsection
