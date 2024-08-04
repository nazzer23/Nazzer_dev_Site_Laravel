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
    public $activities;

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
        $discordActivities = $responseData['activities'];

        foreach($discordActivities as $discordActivity) {
            $this->activities[] = $this->parseDiscordActivity($discordActivity);
        }

    }

    private function parseDiscordActivity($discordActivity) {
        $name = trim($discordActivity['name'] ?? "");
        $details = trim($discordActivity['details'] ?? "");
        $state = trim($discordActivity['state'] ?? "");

        if(strtolower($name) == "spotify") {
            $name = '<span class="spotify_color"><i class="fi fi-brands-spotify"></i></span>';
            $state = explode("; ", $state)[0];
        }

        $activity = $name;

        $values = [];
        if(!empty($state)) {
            $values[] = $state;
        }
        if(!empty($details)) {
            $values[] = $details;
        }
        if(!empty($values)) {
            $activity = "{$activity} | " . join(" - ", $values);
        }

        return $activity;
    }

    public function render()
    {
        // Reset activities
        $this->activities = [];

        $this->performDiscordRequest();
        return view('livewire.discord-status');
    }
}
