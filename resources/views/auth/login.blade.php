@extends('auth.master')

@section('content')

    <div class="card">
        <div class="card-body login-card-body yellow">
        <div class="login-logo @if(request()->is('register')) register-logo @endif">

        <a href="#">SFAC LIBRARY</a>
    </div>
            <p class="login-box-msg">{{ __('common.sign_in_to_start_session')}}</p>
            @if(\Illuminate\Support\Facades\Session::has("login_form") && \Illuminate\Support\Facades\Session::get("login_form"))
                @include("common.messages")
            @endif
            <br>
            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf
                <div class="input-group mb-3">

                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror " name="email" " autofocus
                           placeholder="{{ __('Student ID') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">

                        </div>
                    </div>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                           required autocomplete="current-password" placeholder="{{ __('Password') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">

                        </div>
                    </div>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                @if (Route::has('password.request'))
                <p class="mb-1">
                   <br>
                </p>
            @endif
            @if (Route::has('register'))
                <p class="mb-0">
                    <a href="{{route('register')}}" class="text-center">Register</a>
                </p>
            @endif
                <br><br><br>

            <!-- /.social-auth-links -->

                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-sm btn-dark btn-block">Sign In</button>
                    </div>

                    <!-- /.col -->
                </div>
            </form>


        </div>
        <!-- /.login-card-body -->
    </div>
@endsection
