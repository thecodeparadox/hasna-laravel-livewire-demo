<div class="card">
    <div class="card-header text-end">
        @include('post.partials.actions', ['edit' => false])
    </div>
    <form class="card-body row content" wire:submit.prevent="savePost">
        @csrf
        <div class="mb-2">
            <label for="title" class="form-label">{{ __('Title') }}</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                aria-describedby="title" maxlength="255" value="{{ $title }}" required wire:model="title"
                wire:keyup="updateSlug">
            @error('title')
                <div class="invalid-feedback">{{ __($message) }}</div>
            @enderror
        </div>
        <div class="mt-2 mb-3 @error('title') text-danger @else text-success @enderror">
            <strong>Slug: </strong> {{ $slug }}
            <input type="hidden" name="slug" value="{{ $slug }}" required maxlength="255">
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">{{ __('Content') }}</label>
            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content"
                aria-describedby="content" required rows="10" wire:model="content">{{ $content }}</textarea>
            @error('content')
                <div class="invalid-feedback">{{ __($message) }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">{{ __('Status') }}</label>
            @foreach ($postStatuses as $index => $s)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" id="status-{{ $index }}"
                        value="{{ $s }}" @if ($s === $status) checked @endif
                        wire:model="status">
                    <label class="form-check-label" for="status-{{ $index }}">{{ ucfirst($s) }}</label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </form>
</div>
