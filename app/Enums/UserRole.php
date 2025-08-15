<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum UserRole: string implements HasLabel
{
    case ADMIN = 'admin';
    case TEACHER = 'teacher';
    case CUSTOMER = 'customer';


    public function getLabel(): string|Htmlable|null
    {

        return match ($this) {
            self::ADMIN => 'Admin',
            self::TEACHER => 'Teacher',
            self::CUSTOMER => 'Customer',
        };
    }
}
