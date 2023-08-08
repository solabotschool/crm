@extends('layouts.app')

@section('content')
<div
    style="background:url(luna/src/assets/images/background/login-register.jpg) no-repeat center center; background-size: cover; padding-left: 10vw;">
    <div class="auth-wrapper d-flex no-block justify-content-start align-items-center">
        <div>
            <div class="row"><span class="text-center"><img src="luna/src/assets/images/logo-icon.png"
                        alt="logo" /></span></div>
            <div class="auth-box p-4 bg-white rounded" style="width: 500px;">
                <div id="loginform">
                    <div class="logo">
                        <h3 class="box-title mb-3">ログイン</h3>
                    </div>
                    <!-- Form -->
                    <div class="row">
                        <div class="col-12">
                            <form class="form-horizontal mt-3 form-material" id="loginform" method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="form-group mb-3">
                                    <div class="">                                        
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="メールアドレス">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert" style="display:block;">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <div class="">                                        
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="パスワード">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert" style="display:block;">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-5">
                                    <div class="d-flex">
                                        <div class="checkbox checkbox-info pt-0">
                                            <input id="checkbox-signup" type="checkbox" class="material-inputs chk-col-indigo" {{ old('remember') ? 'checked' : '' }}>
                                            <label for="checkbox-signup"> ログインしたままにする </label>
                                        </div>
                                        <!-- <div class="ms-auto">
                                            <a href="javascript:void(0)" id="to-recover" class="link font-weight-medium"><i class="fa fa-lock me-1"></i> Forgot pwd?</a>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="form-group text-center mt-5 mb-3">
                                    <div class="col-xs-12">
                                        <button class="btn btn-info d-block w-100 waves-effect waves-light"
                                            type="submit">ログイン</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 mt-2 text-center">
                                        <div class="social mb-3">
                                            <!-- <a href="javascript:void(0)" class="btn  btn-facebook" data-bs-toggle="tooltip" title="Login with Facebook"> <i aria-hidden="true" class="fab fa-facebook-f"></i> </a>
                                            <a href="javascript:void(0)" class="btn btn-googleplus" data-bs-toggle="tooltip" title="Login with Google"> <i aria-hidden="true" class="fab fa-google"></i> </a> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-0 mt-2">
                                    <div class="col-sm-12 justify-content-center d-flex">
                                        <p><a href="{{ route('register') }}"
                                                class="text-info font-weight-medium ms-1">新規登録はこちら</a></p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="recoverform">
                    <div class="logo">
                        <h3 class="font-weight-medium mb-3">Recover Password</h3>
                        <span class="text-muted">Enter your Email and instructions will be sent to you!</span>
                    </div>
                    <div class="row mt-3 form-material">
                        <!-- Form -->
                        <form class="col-12" action="index.html">
                            @csrf

                            <!-- email -->
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control" type="email" required="" placeholder="Username">
                                </div>
                            </div>
                            <!-- pwd -->
                            <div class="row mt-3">
                                <div class="col-12">
                                    <button class="btn d-block w-100 btn-primary text-uppercase" type="submit"
                                        name="action">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection