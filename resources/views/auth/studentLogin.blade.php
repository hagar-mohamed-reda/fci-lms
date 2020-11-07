@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="login-box" style="width: 360px; margin: 7% auto; margin-top: 10px;">
                <div class="login-logo" style="text-align: center;">
                    <img src="{{ asset('dashboard/images/login/159102060235552.png') }}" class="w3-center w3-round"  width="90px" >
                    <br>
                    <h1 style="color: #fff"  class="w3-text-white" ><b> @lang('site.hioac')  </b></h1>
                </div>

                <div class="login-box">

                    <div class="login-box-body">

                            <p class="login-box-msg">@lang('site.regist-on-your-dashboard')</p>
                            <br>
                            <p class="login-box-msg" style="color: red">@lang('site.login-not2')</p>
                            <br>
                            <p class="login-box-msg">@lang('site.login-not3')</p>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                    <div class="form-group has-feedback">
                                        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="@lang('site.phone')">
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>


                                    <div class="form-group has-feedback">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="@lang('site.password')">
                                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>


                                        <button type="submit" class="btn btn-primary btn-block btn-flat">
                                            {{-- {{ __('Login') }} --}} @lang('site.sign-in')
                                        </button>

                                        <div class="social-auth-links text-center mb-3">
                                            <a href="#" class="btn btn-block btn-success btn-flat">
                                               @lang('site.register')
                                            </a>

                                          </div>

                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="#{{-- route('password.request') --}}">
                                                {{-- {{ __('Forgot Your Password?') }} --}}
                                                @lang('site.forgot-password')
                                            </a>
                                        @endif
                            </form>
                            <br>

                                <p class="login-box-msg" style="color: red;font-size:17px">@lang('site.login-not4') <i class="fa fa-frown-o" style="padding: 5px"></i> </p>

                    </div>
                </div><!--end card -->

                {{-- <div class="card">
                    <div class="card-body login-card-body">
                        <p class="login-box-msg">@lang('site.regist-on-your-dashboard')</p>

                      <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="input-group mb-3">
                          <input type="text" class="form-control" placeholder="@lang('site.phone')">
                          <div class="input-group-append">
                            <div class="input-group-text">
                              <span class="fas fa-envelope"></span>
                            </div>
                          </div>
                        </div>
                        <div class="input-group mb-3">
                          <input type="password" class="form-control" placeholder="@lang('site.password')">
                          <div class="input-group-append">
                            <div class="input-group-text">
                              <span class="fas fa-lock"></span>
                            </div>
                          </div>
                        </div>

                          <!-- /.col -->

                            <button type="submit" class="btn btn-primary btn-block btn-flat">@lang('site.sign-in')</button>
                          <!-- /.col -->
                      </form>

                      <div class="social-auth-links text-center mb-3">
                        <a href="#" class="btn btn-block btn-success btn-flat">
                           @lang('site.register')
                        </a>

                      </div>
                      <!-- /.social-auth-links -->

                      <p class="mb-1">
                        <a href="#">@lang('site.forgot-password')</a>
                      </p>

                    </div>
                    <!-- /.login-card-body -->
                  </div>

                </div> --}}

        </div>
    </div>
</div>
@endsection





