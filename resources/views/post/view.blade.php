<div class="card mb-3">
    <div class="d-flex card-header">
        <div class="flex-grow-1">
            <x-post-badge :post="$post" />
        </div>
        <div class="actions">
            @auth
                @include('post.partials.actions')
            @endauth
        </div>
    </div>

    <div class="card-body">
        <h4 class="card-title">
            {{ $post->title }}
        </h4>
        <p class="cart-text">
            @if (isset($showFullContent) && $showFullContent)
                {{ __($post->content) }}
            @else
                <p>
                    {{ __($post->short_content) }}
                    <a href="{{ route('post.view', ['id' => $post->id]) }}" class="btn btn-sm text-primary"
                        title="View More">
                        <i class="bi bi-eye-fill"></i>
                    </a>
                </p>
            @endif
        </p>
    </div>

    <div class="card-footer p-2">
        <div class="row">
            <div class="col-12 col-sm-12 col-xs-12 text-end">
                <div>
                    <small>
                        <em>{{ $post->updated_at->toDayDateTimeString() }}</em>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
