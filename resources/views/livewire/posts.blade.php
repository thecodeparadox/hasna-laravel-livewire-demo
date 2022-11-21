<main class="container">
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
