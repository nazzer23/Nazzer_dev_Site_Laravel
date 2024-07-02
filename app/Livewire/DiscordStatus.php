<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class DiscordStatus extends Component
{
    public $discordId;
    public $discordName;
    public $discordStatus;
    public $discordColor;
    public $discordAvatar;
    public $discordActivities = [];

    public function performDiscordRequest()
    {
        $request = Http::get("https://api.lanyard.rest/v1/users/" . env('DISCORD_ID', '165584933149081600'));
        $response = $request->json();

        if (!$response['success']) {
            return;
        }
        $responseData = $response['data'];
        $this->discordId = $responseData['discord_user']['id'];
        $this->discordName = $responseData['discord_user']['username'];
        $discordStatus = $responseData['discord_status'];
        $this->discordColor = match ($discordStatus) {
            'online' => "green",
            'dnd' => "red",
            "idle" => "orange",
            default => "#80848e",
        };

        $this->discordStatus = match ($discordStatus) {
            'online' => "Online",
            'dnd' => "Do not Disturb",
            'idle' => "Idle",
            default => "Offline"
        };

        $this->discordAvatar = $responseData['discord_user']['avatar'];
        $this->discordActivities = $responseData['activities'];
    }

    public function render()
    {
        $this->performDiscordRequest();
        return view('livewire.discord-status');
    }
}
