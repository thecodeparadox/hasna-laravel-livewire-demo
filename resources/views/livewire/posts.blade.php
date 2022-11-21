<main class="container">
    @if (session('error') || session('danger'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span>{{ __(session('error') ?? session('danger')) }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($opMode !== 'listing')
        <div class="d-flex mt-2 mb-3 ">
            <div class="flex-grow-1">
                <h4>{{ __($componentTitle) }}</h4>
            </div>
            <div class="text-end">
                <a class="btn btn-info btn-sm" href="{{ route('posts') }}">
                    <i class="bi bi-arrow-left-circle"></i> {{ __('Back to Listing') }}
                </a>
            </div>
        </div>
    @endif

    @if ($opMode === 'create' || $opMode === 'update')
        @include('post.upsert')
    @endif

    @if ($opMode === 'view')
        @include('post.view', ['showFullContent' => true])
    @endif

    @if ($opMode === 'listing')
        @include('post.listing', ['posts' => $this->posts])
    @endif
</main>
