@extends('layouts.auth')

@section('login')
    <div class="register-box">

        <div class="register-box-body">

            <div class="login-logo">
                <a href="{{ url('/') }}">

                </a>
            </div>

            <div class="card-body">

                <p class="login-box-msg">Register a new User

                </p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group has-feedback @error('name') has-error @enderror">
                        <input type="text" name="name" class="form-control" placeholder="Name" required
                            value="{{ old('name') }}" autofocus>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        @error('name')
                            <span class="help-block">{{ $message }}</span>
                        @else
                            <span class="help-block with-errors"></span>
                        @enderror
                    </div>
                    <div class="form-group has-feedback @error('email') has-error @enderror">
                        <input type="email" name="email" class="form-control" placeholder="Email" required
                            value="{{ old('email') }}" autofocus>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @error('email')
                            <span class="help-block">{{ $message }}</span>
                        @else
                            <span class="help-block with-errors"></span>
                        @enderror
                    </div>
                    <div class="form-group has-feedback @error('password') has-error @enderror">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" placeholder="Password" required autocomplete="new-password"> <span
                            class="glyphicon glyphicon-lock form-control-feedback"></span>
                        @error('password')
                            <span class="help-block">{{ $message }}</span>
                        @else
                            <span class="help-block with-errors"></span>
                        @enderror
                    </div>
                    <div class="form-group has-feedback @error('password') has-error @enderror">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            placeholder="Confirm password" required autocomplete="new-password"> <span
                            class="glyphicon glyphicon-lock form-control-feedback"></span>
                        @error('password')
                            <span class="help-block">{{ $message }}</span>
                        @else
                            <span class="help-block with-errors"></span>
                        @enderror
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Register') }}
                        </button>
                    </div>
                    <!-- /.col -->
                    <div>
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </div>
            </div>

            </form>

            <!-- /.form-box -->
        </div><!-- /.card -->

    </div>
    <!-- /.register-box -->
    </div>
    <!-- /.login-box -->
@endsection
