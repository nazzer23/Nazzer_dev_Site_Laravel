@props(['update', 'deletable' => false])

<div class="border-t border-primary-800/40 pt-3 first:border-t-0 first:pt-0">
    <div class="flex items-center justify-between gap-3">
        @if($update->title)
            <span class="font-secondary font-bold text-primary-100">{{ $update->title }}</span>
        @endif
        <span class="text-xs text-primary-200/70">{{ $update->created_at->diffForHumans() }}</span>
    </div>
    <p class="repo-description mt-1">{{ $update->body }}</p>

    @if($update->images->isNotEmpty())
        <div class="dev-log-images">
            @foreach($update->images as $image)
                <div class="relative">
                    <a href="{{ $image->url() }}" target="_blank" rel="noreferrer">
                        <img src="{{ $image->url() }}" alt="" loading="lazy">
                    </a>
                    @if($deletable)
                        <button
                            type="button"
                            class="absolute top-1 right-1 w-6 h-6 grid place-items-center rounded-full bg-primary-950/80 text-white text-xs cursor-pointer hover:bg-primary-800"
                            wire:click="deleteUpdateImage({{ $image->id }})"
                            wire:confirm="Remove this image?"
                            aria-label="Remove image"
                        >
                            &times;
                        </button>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
