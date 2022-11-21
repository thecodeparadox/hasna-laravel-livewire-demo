@extends('layouts.app')

@section('content')
    <div class="container card">
        <form class="card-body row" method="POST" action="{{ route('user.store') }}">
            @csrf
            <h4>{{ __('Sign up') }}</h4>
            <div class="mb-3">
                <label for="fname" class="form-label">{{ __('First Name') }}</label>
                <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="fname"
                    name="first_name" aria-describedby="firstName" maxlength="40" value="{{ old('first_name') }}" required>
                @error('first_name')
                    <div class="invalid-feedback">{{ __($message) }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="lname" class="form-label">{{ __('Last Name') }}</label>
                <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="lname"
                    name="last_name" aria-describedby="firstName" maxlength="40" value="{{ old('last_name') }}" required>
                @error('last_name')
                    <div class="invalid-feedback">{{ __($message) }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email address') }}</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                    aria-describedby="emailHelp" name="email" value="{{ old('email') }}" requried>
                @error('email')
                @enderror
            </div>
            <div class="mb-3">
                <label for="pass" class="form-label">{{ __('Password') }}</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="pass" required
                    minlength="1" name="password">
                @error('password')
                    <div class="invalid-feedback">{{ __($message) }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="cpass" class="form-label">{{ __('Confirm Password') }}</label>
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                    id="password_confirmation" name="password_confirmation" minlength="2">

                @error('password_confirmation')
                    <div class="invalid-feedback">{{ __($message) }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
        </form>
        <hr>
        <div class="alert alert-primary">
            {{ __('Already a member? Please') }} <a href="{{ route('user.login') }}">
                {{ __('Login') }}
            </a>
        </div>
    </div>
@endsection
