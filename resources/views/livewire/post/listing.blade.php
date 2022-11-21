<div class="posts-listing">
    <div class="row justify-content-between mt-3 mb-3">
        <div class="col-8 d-flex">
            <div class="flex-grow-1 hstack">
                <h4>{{ 'Posts Listing' }}</h4>
            </div>
            <div>
                <a href="{{ route('post.create') }}" class="btn btn-primary">
                    <i class="bi bi-pencil-fill"></i> {{ __('Create Post') }}
                </a>
            </div>
        </div>
        <div class="col-4">
            <form class="position-relative"" role="search">
                <input class="form-control me-2" type="text" name="search" wire:model="search"
                    placeholder="Search By Title and Hit Return" aria-label="Search" value="{{ $search }}">
            </form>
        </div>
    </div>
    <div class="row">
        <div class="posts col-12">
            @if ($this->posts->isNotEmpty())
                <div class="posts-wrap">
                    @foreach ($this->posts as $post)
                        @include('post.view')
                    @endforeach
                </div>
                <div aria-label="Page navigation">
                    {{ $this->posts->links('pagination::custom-pagination') }}
                </div>
            @else
                <div class="alert alert-warning">{{ __('No Post found') }}</div>
            @endif
        </div>
    </div>
</div>
