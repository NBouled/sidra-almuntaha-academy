<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum Gender: string implements HasLabel
{
    case MALE = 'male';
    case FEMALE = 'female';

    public function getLabel(): string|Htmlable|null
    {

        return match ($this) {
            self::MALE => 'Male',
            self::FEMALE => 'Female',
        };
    }

}
