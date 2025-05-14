@extends('layouts.guest')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-4 offset-md-3 offset-lg-4">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body text-start">
                        @if (session('error'))
                            <div class="alert-icon alert alert-danger" role="alert">
                                <i class="fa fa-times-circle-o"></i> {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert-icon alert alert-success" role="alert">
                                <i class="fa fa-check-circle-o"></i> {{ session('success') }}
                            </div>
                        @endif
                        @if (session('status'))
                            <div class="alert-icon alert alert-info" role="alert">
                                <i class="fa fa-info-circle"></i> {{ session('status') }}
                            </div>
                        @endif
                        @if (session('warning'))
                            <div class="alert-icon alert alert-warning" role="alert">
                                <i class="fa fa-warning"></i> {{ session('warning') }}
                            </div>
                        @endif
                        @if (session('verified'))
                            <div class="alert-icon alert alert-success" role="alert">
                                <i class="fa fa-check-circle-o"></i> {{__('Email address Verified.')}}
                                {{ __('Thank you for verifying your address.') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group mb-2">
                                <label for="username">{{ __('Username') }}</label>
                                <input id="username" type="text"
                                       class="form-control @error('username') is-invalid @enderror" name="username"
                                       value="{{ old('username') }}" autocomplete="username" autofocus
                                       required>

                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label for="password">{{ __('Password') }}</label>
                                <input id="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror" name="password"
                                       autocomplete="current-password" required>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" name="remember"
                                       id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                            <div class="form-group footer">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
