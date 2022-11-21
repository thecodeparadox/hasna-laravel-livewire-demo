@extends('layout')

@section('content')
    <section class="home">
        @auth
            <div class="bg-dark text-light p-5">
                <div class="bg-dark p-5">
                    <h1 class="display-4">
                        {{ __('Welcome,' . Auth::user()->full_name . '!') }}
                    </h1>
                    <hr>
                    <a href="{{ route('posts.listing') }}" class="btn btn-primary">
                        {{ __('Go to Posts') }}
                    </a>
                </div>
            </div>
        @endauth

        @guest
            <div class="bg-dark text-light p-5">
                <div class="bg-dark p-5">
                    <h1 class="display-4">{{ __('Welcome, Guest!!!') }}</h1>
                </div>
            </div>
        @endguest
    </section>
@endsection
