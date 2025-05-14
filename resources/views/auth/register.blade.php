@extends('layouts.guest')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-4">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body p-3 text-start">
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
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group mb-2">
                                <label for="username"
                                >{{ __('Username') }}</label>
                                <input id="username" type="text"
                                       class="form-control @error('username') is-invalid @enderror" name="username"
                                       value="{{ old('username') }}" required autocomplete="username" autofocus>

                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="form-group mb-2">
                                <label for="email"
                                >{{ __('Email Address') }}</label>

                                <input id="email" type="email"
                                       class="form-control @error('email') is-invalid @enderror" name="email"
                                       value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="form-group mb-2">
                                <label for="name">{{ __('Full Name') }}</label>
                                <input id="name" type="text"
                                       class="form-control @error('name') is-invalid @enderror" name="name"
                                       value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                            <div class="form-group mb-2">
                                <label for="company">{{ __('Company') }}</label>
                                <input id="company" type="text" class="form-control @error('name') is-invalid @enderror"
                                       name="company" value="{{ old('company') }}" required autocomplete="name"
                                       autofocus>

                                @error('company')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-2">
                                <label for="email"
                                      >{{ __('Phone') }}</label>

                                <input id="phone" type="tel"
                                       class="form-control @error('phone') is-invalid @enderror" name="phone"
                                       value="{{ old('phone') }}" required autocomplete="phone">

                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-2">
                                <label for="password"
                                      >{{ __('Password') }}</label>

                                <input id="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror" name="password"
                                       required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-2">
                                <label for="password-confirm"
                                      >{{ __('Confirm Password') }}</label>

                                <input id="password-confirm" type="password" class="form-control"
                                       name="password_confirmation" required autocomplete="new-password">
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
