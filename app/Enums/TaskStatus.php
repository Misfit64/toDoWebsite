<?php

namespace App\Enums;

enum TaskStatus: int
{
    case PENDING = 0;
    case COMPLETED = 1;

    public function label() : string
    {
        return match ($this) {
            self::PENDING => "Pending",
            self::COMPLETED => "Completed",
        };
    }
}
