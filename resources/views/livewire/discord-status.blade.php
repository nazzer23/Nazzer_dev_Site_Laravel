<div wire:poll.15s>
    @if($discordStatus)
        <x-partials.status-pill
            color="{{ $discordColor }}"
            label="{{ $discordStatus }}"
            :activity="$activities[0] ?? null"
        />
    @endif
</div>
