<?php

namespace App\Enums;

enum ProjectStatus: string
{
    case Active = 'active';
    case Paused = 'paused';
    case Shipped = 'shipped';
    case Archived = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Paused => 'Paused',
            self::Shipped => 'Shipped',
            self::Archived => 'Archived',
        };
    }
}
