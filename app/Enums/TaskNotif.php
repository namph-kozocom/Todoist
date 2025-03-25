<?php

namespace App\Enums;

enum TaskNotif: string
{
    case ASSIGNED = 'assigned';
    case CHANGE = 'change';

    /**
     * Get all possible values.
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
