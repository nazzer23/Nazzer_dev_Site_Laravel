@props(['color' => '#80848e', 'label', 'activity' => null])

<div {{ $attributes->class(['status-pill']) }}>
    <span class="status-dot" style="background:{{ $color }}"></span>
    <span>{{ $label }}</span>
    @if($activity)
        <span class="status-activity">{!! $activity !!}</span>
    @endif
</div>
