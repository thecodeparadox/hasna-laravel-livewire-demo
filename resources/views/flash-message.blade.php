@if (session('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <span>{{ __(session('info')) }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <span>{{ __(session('success')) }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <span>{{ __(session('waring')) }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error') || session('danger'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span>{{ __(session('error') ?? session('danger')) }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
