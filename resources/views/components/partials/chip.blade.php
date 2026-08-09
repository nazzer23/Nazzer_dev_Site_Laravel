@props(['icon' => null, 'color' => null])

<span class="chip">
    @if($icon)
        <span class="chip-mark" @if($color) style="color:{{ $color }}" @endif>{{ $icon }}</span>
    @endif
    {{ $slot }}
</span>
