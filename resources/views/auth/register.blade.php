@php
    /* @var \App\Facades\Util $util */
    /* @var \App\Facades\Common $common */
@endphp
@extends('auth.master')
@section('content')
    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">{{ __("common.register")}}</p>
            @if(\Illuminate\Support\Facades\Session::has("register_form") && \Illuminate\Support\Facades\Session::get("register_form"))
                @include("common.messages")
            @endif
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                           value="{{ old('name') }}" required autocomplete="name" autofocus
                           placeholder="{{ __('common.name') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                           value="{{ old('email') }}" required autocomplete="email"
                           placeholder="{{ __('common.pl_email_address') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                           value="{{ old('phone') }}" required
                           placeholder="{{ __('common.phone') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-phone-alt"></span>
                        </div>
                    </div>
                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                @if($common::getSiteSettings("enable_reg_pg_shw_course_rest"))
                    <div class="input-group mb-3">


                        <select @if($common::getSiteSettings('enable_reg_pg_course_rest')) required
                                @endif name="sel_course"
                                class="form-control" style="border-right: 1px solid #ced4da;">
                            <option value="">--{{__("common.select")}}--</option>
                            @foreach($common::getAllCourses() as $course)
                                <option value="{{$course->id}}">{{$course->name}}</option>
                            @endforeach
                        </select>

                        <select @if($common::getSiteSettings('enable_reg_pg_course_rest'))required
                                @endif name="sel_year"
                                class="form-control" style="border-right: 1px solid #ced4da;">
                            <option value="">--{{__("common.select")}}--</option>
                            @foreach($common::getAllCourseYears() as $year)
                                <option value="{{$year->id}}">{{$year->year}}</option>
                            @endforeach
                        </select>

                    </div>
                @endif
                @if($common::getSiteSettings("enable_reg_pg_shw_photo_rest"))
                    <div class="input-group mb-3">
                        <div class="input-group b-lr-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{__("common.photo")}}</span>
                            </div>
                            <input accept=".jpg,.jpeg,.png"
                                   class="form-control text-sm"
                                   @if($common::getSiteSettings('enable_reg_pg_photo_rest'))required @endif name="photo"
                                   type="file">
                        </div>
                    </div>
                @endif
                @if($common::getSiteSettings("enable_reg_pg_shw_proof_rest"))
                    <div class="input-group mb-3">
                        <div class="input-group b-lr-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{__("common.proof")}}</span>
                            </div>
                            <input accept=".jpg,.jpeg,.png,.pdf"
                                   class="form-control text-sm"
                                   @if($common::getSiteSettings('enable_reg_pg_proof_rest')) required
                                   @endif name="proof" type="file">
                        </div>
                    </div>
                @endif

                <div class="input-group mb-3">
                    <input type="password" class="form-control"
                           class="form-control @error('password') is-invalid @enderror" name="password"
                           required autocomplete="new-password" placeholder="{{ __('common.password') }}">
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
                    <input type="password" class="form-control"
                           name="password_confirmation" required autocomplete="new-password"
                           placeholder="{{ __('common.confirm_password') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                            <label for="agreeTerms">
                                I agree to the <a href="#">terms</a>
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-sm btn-dark btn-block">{{ __('Register') }}</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            @if(request()->has("login"))
                <a href="{{route('login')}}" class="text-center">I already have a membership</a>
            @endif
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->









    {{--    <div class="container">--}}
    {{--        <div class="row justify-content-center">--}}
    {{--            <div class="col-md-8">--}}
    {{--                <div class="card">--}}
    {{--                    <div class="card-header blue">{{ __('Register') }}</div>--}}

    {{--                    <div class="card-body yellow">--}}
    {{--                        <form method="POST" action="{{ route('register') }}">--}}
    {{--                            @csrf--}}

    {{--                            <div class="form-group row">--}}
    {{--                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>--}}

    {{--                                <div class="col-md-6">--}}
    {{--                                    <input id="name" type="text"--}}
    {{--                                           class="form-control @error('name') is-invalid @enderror" name="name"--}}
    {{--                                           value="{{ old('name') }}" required autocomplete="name" autofocus>--}}

    {{--                                    @error('name')--}}
    {{--                                    <span class="invalid-feedback" role="alert">--}}
    {{--                                        <strong>{{ $message }}</strong>--}}
    {{--                                    </span>--}}
    {{--                                    @enderror--}}
    {{--                                </div>--}}
    {{--                            </div>--}}

    {{--                            <div class="form-group row">--}}
    {{--                                <label for="email"--}}
    {{--                                       class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}

    {{--                                <div class="col-md-6">--}}
    {{--                                    <input id="email" type="email"--}}
    {{--                                           class="form-control @error('email') is-invalid @enderror" name="email"--}}
    {{--                                           value="{{ old('email') }}" required autocomplete="email">--}}

    {{--                                    @error('email')--}}
    {{--                                    <span class="invalid-feedback" role="alert">--}}
    {{--                                        <strong>{{ $message }}</strong>--}}
    {{--                                    </span>--}}
    {{--                                    @enderror--}}
    {{--                                </div>--}}
    {{--                            </div>--}}

    {{--                            <div class="form-group row">--}}
    {{--                                <label for="password"--}}
    {{--                                       class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>--}}

    {{--                                <div class="col-md-6">--}}
    {{--                                    <input id="password" type="password"--}}
    {{--                                           class="form-control @error('password') is-invalid @enderror" name="password"--}}
    {{--                                           required autocomplete="new-password">--}}

    {{--                                    @error('password')--}}
    {{--                                    <span class="invalid-feedback" role="alert">--}}
    {{--                                        <strong>{{ $message }}</strong>--}}
    {{--                                    </span>--}}
    {{--                                    @enderror--}}
    {{--                                </div>--}}
    {{--                            </div>--}}

    {{--                            <div class="form-group row">--}}
    {{--                                <label for="password-confirm"--}}
    {{--                                       class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>--}}

    {{--                                <div class="col-md-6">--}}
    {{--                                    <input id="password-confirm" type="password" class="form-control"--}}
    {{--                                           name="password_confirmation" required autocomplete="new-password">--}}
    {{--                                </div>--}}
    {{--                            </div>--}}

    {{--                            <div class="form-group row mb-0">--}}
    {{--                                <div class="col-md-6 offset-md-4">--}}
    {{--                                    <button type="submit" class="btn btn-primary">--}}
    {{--                                        {{ __('Register') }}--}}
    {{--                                    </button>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </form>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
@endsection
