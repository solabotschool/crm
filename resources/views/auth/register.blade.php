@extends('layouts.app')

@section('content')
<div style="background:url(luna/src/assets/images/background/login-register.jpg) no-repeat center center; background-size: cover; padding-left: 10vw;">
    <div class="auth-wrapper d-flex no-block justify-content-start align-items-center">
        <div>
            <div class="row"><span class="text-center"><img src="luna/src/assets/images/logo-icon.png" alt="logo" /></span></div>
            <div class="auth-box p-4 bg-white rounded" style="width: 500px;">
                <div>
                    <div class="logo text-center">
                        <h5 class="box-title mb-3 mt-1">新規会員登録</h5>
                    </div>
                    <!-- Form -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="form-floating mb-3">
                                    <input id="tb-rfname" type="text" class="form-control form-input-bg @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    <label for="tb-rfname">名前</label>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-floating mb-3">
                                    <input id="tb-remail" type="email" class="form-control form-input-bg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                    <label for="tb-remail">メールアドレス</label>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-floating mb-3">
                                    <input id="text-rpassword" type="password" class="form-control form-input-bg @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    <label for="text-rpassword">パスワード</label>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-floating mb-3">
                                    <input id="text-rcpassword" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    <label for="text-rcpassword">パスワード確認</label>
                                    <div class="invalid-feedback">
                                        Password is required
                                    </div>
                                </div>
                                <div class="checkbox checkbox-primary mb-3">
                                    <input id="checkbox-signup" type="checkbox" class="chk-col-indigo material-inputs">
                                    <label for="checkbox-signup" style="font-size: small;">内容に同意</label>
                                </div>
                                <div class="d-flex align-items-stretch">
                                    <button type="submit" class="btn btn-info d-block w-100">サインアップ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection