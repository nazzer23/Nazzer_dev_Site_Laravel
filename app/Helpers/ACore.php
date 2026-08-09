<?php

namespace App\Helpers;

use App\Enums\NotifyOnStatus;
use App\Models\Core\AppSetting;
use App\Models\Core\NotificationType;
use App\Models\Core\QueuedTask;
use App\Models\Resellers\ResellerSetting;
use App\Models\Runlist\RunlistService;
use App\Models\Settings\MonitorType;
use App\Models\TeamServices\TeamContact;
use App\Models\TeamServices\TeamService;
use App\Models\TeamServices\TeamServiceContact;
use App\Models\TeamServices\TeamServiceIncident;
use App\Models\TeamServices\TeamServiceIncidentLog;
use App\Models\TeamServices\TeamServiceNotifyHistory;
use Carbon\Carbon;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ACore
{
    /**
     * @throws ConnectionException
     */
    public static function handleException(\Throwable $exception): void
    {
        Log::error($exception);

        // Local dev and automated test runs should never fire the real Discord webhook.
        if (config('app.env') === 'local' || app()->runningUnitTests() || empty(config('discord.webhook'))) {
            return;
        }

        $payload = [
            "username" => "Exception Handler",
            "embeds" => [
                [
                    "author" => [
                        "name" => "" . config('app.name'),
                    ],
                    "title" => config('app.name') . " Exception",
                    "description" => $exception->getMessage() . PHP_EOL . $exception->getTraceAsString(),
                    "color" => 13369344,
                    "fields" => [
                        [
                            "name" => "Environment",
                            "value" => config('app.env', 'production'),
                        ]
                    ],
                    "footer" => [
                        "text" => "Reported on"
                    ],
                    "timestamp" => Carbon::now(),
                ]
            ],
            "attachments" => []
        ];

        ACore::sendDiscordNotification($payload);
    }

    /**
     * @param array<string, mixed>|null $payload
     * @param string|null $sLocation
     * @param string|null $sMessage
     * @param array<array<string, mixed>> $aFields
     * @param int $iColor
     */
    public static function sendDiscordNotification(?array $payload = null, ?string $sLocation = '', ?string $sMessage = '', array $aFields = [], int $iColor = 5305012): void
    {
        if (empty(config('discord.webhook'))) {
            return;
        }

        if (empty($payload)) {
            $payload = [
                "username" => config('app.name'),
                "embeds" => [
                    [
                        "author" => [
                            "name" => "" . config('app.name'),
                        ],
                        "title" => config('app.name') . " - " . $sLocation,
                        "description" => $sMessage,
                        "color" => $iColor,
                        "fields" => [...$aFields,
                            [
                                "name" => "Environment",
                                "value" => config('app.env', 'production'),
                            ]
                        ],
                        "footer" => [
                            "text" => "Sent at"
                        ],
                        "timestamp" => Carbon::now(),
                    ]
                ],
                "attachments" => []
            ];
        }

        try {
            Http::withBody((string)json_encode($payload), "application/json")->withOptions(['verify' => false])->post(config('discord.webhook'));
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

}
