<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand active" aria-current="page" href="{{ route('posts') }}">
            <i class="bi bi-house-door-fill"></i>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @auth
                    <li class="nav-item dropdown">
                        <strong class="d-inline-block">
                            {{ __('Welcome, ') . Auth::user()->full_name }}!
                        </strong>
                    </li>
                @endauth
            </ul>

            @auth
                <div class="ml-3 text-end">
                    <a href="{{ route('user.logout') }}" class="btn btn-warning btn-sm ml-3 d-inline-block">
                        <i class="bi bi-sign-turn-left-fill"></i>
                        {{ __('Logout') }}
                    </a>
                </div>
            @endauth

            @guest
                <div class="ml-3">
                    @if (!request()->routeIs('user.login'))
                        <a href="{{ route('user.login') }}" class="btn btn-primary">
                            <i class="bi bi-box-arrow-in-right"></i> {{ __('Login') }}
                        </a>
                    @endif

                    @if (!request()->routeIs('user.signup'))
                        <a href="{{ route('user.signup') }}" class="btn btn-success">
                            <i class="bi bi-box-arrow-in-up"></i> {{ __('Signup') }}
                        </a>
                    @endif
                </div>
            @endguest
        </div>
    </div>
</nav>
