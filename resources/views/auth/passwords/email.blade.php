@extends('auth.master')

@section('content')

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">{{ __('Fill in your email id a reset link will be sent to your email id.') }}</p>
            @if (session('status'))
                {!! CForm::calloutSuccess(session('status')) !!}
            @endif
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="input-group mb-3">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                           placeholder="{{__('Enter Email Id To Receive Reset Link')}}">
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


                <div class="row">
                    <div class="col-12">
                        <button type="submit"
                                class="btn btn-dark btn-block"> {{ __('Send Password Reset Link') }}</button>
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



@endsection
