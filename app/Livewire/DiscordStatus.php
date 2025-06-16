<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class DiscordStatus extends Component
{
    public ?string $discordId;
    public ?string $discordName;
    public ?string $discordStatus;
    public ?string $discordColor;
    public ?string $discordAvatar;
    /**
     * @var array<string>
     */
    public array $activities;

    public function performDiscordRequest(): void
    {
        $this->activities = [];
        $request = Http::get("https://api.lanyard.rest/v1/users/" . ((string)config('discord.discord_id')));

        /** @var array<string, mixed> $response */
        $response = (array)$request->json();

        if (empty($response) || !$response['success']) {
            return;
        }
        $responseData = (array)$response['data'];
        $this->discordId = (string)$responseData['discord_user']['id'];
        $this->discordName = (string)$responseData['discord_user']['username'];
        $discordStatus = (string)$responseData['discord_status'];
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

        /** @var array<string, mixed> $discordActivity */
        foreach ($discordActivities as $discordActivity) {
            $this->activities[] = $this->parseDiscordActivity($discordActivity);
        }

        // Check for duplicate and empty activities
        $this->activities = array_filter(/**
         * @param $activity
         * @return bool
         */ array_unique($this->activities), fn($activity) => !empty($activity));

    }

    /**
     * @param array<string, mixed> $discordActivity
     * @return string
     */
    private function parseDiscordActivity(array $discordActivity): string
    {
        $name = trim($discordActivity['name'] ?? "");
        $type = trim($discordActivity['type'] ?? "");
        $details = trim($discordActivity['details'] ?? "");
        $state = trim($discordActivity['state'] ?? "");

        if (strtolower($name) === "spotify") {
            $name = '<span class="spotify_color discord_icon"><i class="fi fi-brands-spotify"></i></span>';
            $state = explode("; ", $state)[0];
        }

        if ((int)$type === 4) {

            // Get avatar emoji data
            $avatarEmoji = $discordActivity['emoji'] ?? [];
            if (empty($avatarEmoji)) {
                return '';
            }
            $avatarEmojiId = $avatarEmoji['id'] ?? '';
            if (empty($avatarEmojiId)) {
                return '';
            }

            $discordAvatarUrl = "https://cdn.discordapp.com/emojis/{$avatarEmojiId}.gif?size=24";
            $name = '<img src="' . $discordAvatarUrl . '" class="discord_icon">';
        }

        $activity = $name;

        $values = [];
        if (!empty($state)) {
            $values[] = $state;
        }
        if (!empty($details)) {
            $values[] = $details;
        }
        if (!empty($values)) {
            $activity = "<span>{$activity}&nbsp;|&nbsp;" . join(" - ", $values) . "</span>";
        }

        return $activity;
    }

    public function render(): object
    {
        // Reset activities
        $this->activities = [];

        $this->performDiscordRequest();
        return view('livewire.discord-status');
    }
}
