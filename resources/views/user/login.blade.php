@extends('layouts.app')

@section('content')
    <div class="container card">
        <form class="card-body row" method="POST" action="{{ route('user.login') }}">
            <h4>{{ __('Login') }}</h4>
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email address') }}</label>
                <input type="email" class="form-control" id="email" aria-describedby="email" name="email"
                    @error('email') is-invalid @enderror" value="{{ old('email') }}">
            </div>
            <div class="mb-3">
                <label for="pass" class="form-label">{{ __('Password') }}</label>
                <input type="password" class="form-control" id="pass" required minlength="2" name="password"
                    @error('email') is-invalid @enderror>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="rem" name="remember_me"
                    @if (old('remember_me') == 'on') checked @endif">
                <label class="form-check-label" for="rem">{{ __('Remember Me') }}</label>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
        </form>
        <hr>
        <div class="alert alert-primary">
            {{ __('For register, please') }} <a href="{{ route('user.signup') }}">{{ __('Sign up') }}
            </a>
        </div>
    </div>
@endsection
