<?php

namespace App\Livewire;

use Livewire\Component;

class DiscordActivity extends Component
{
    public $name;
    public $state;
    public $details;

    public $output;

    public $activityJson;

    public function mount($activityJson)
    {
        $this->activityJson = $activityJson;

        $this->name = trim($activityJson['name'] ?? "");
        $this->details = trim($activityJson['details'] ?? "");
        $this->state = trim($activityJson['state'] ?? "");

        if(strtolower($this->name) == "spotify") {
            $this->name = '<span class="text-[#1DB954]"><i class="fi fi-brands-spotify"></i></span>';
            $this->state = explode("; ", $this->state)[0];
        }


        $values = [];
        if (!empty($this->state)) {
            $values[] = $this->state;
        }
        if (!empty($this->details)) {
            $values[] = $this->details;
        }

        $this->output = $this->name;
        if (!empty($values)) {
            $this->output .= " | " . join(" - ", $values);
        }
    }

    public function render()
    {
        return view('livewire.discord-activity');
    }
}
