<div wire:poll.15s>
    <div class="flex items-center tablet:flex-col space-x-4 rtl:space-x-reverse">
        <x-partials.discord-avatar image="https://cdn.discordapp.com/avatars/{{$discordId}}/{{$discordAvatar}}.png"
                                   color="{{$discordColor}}" alt="{{$discordName}} Avatar"/>
        <div class="space-y-1 font-medium w-full">
            <h1>{{$discordName}}</h1>
            <div class="text-sm text-primary-100 flex flex-col gap-1">
                @foreach($activities as $activityData)
                    <div class="border-t border-t-secondary-900 pt-2">
                        {!! $activityData !!}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
