<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\Gender;
use App\Enums\UserRole;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('User Account')
                    ->columnSpanFull()
                    ->description('Prevent abuse by limiting the number of requests per period')
                    ->columns()
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required(),
                        Select::make('role')
                            ->options(UserRole::class)
                            ->required(),
                        TextInput::make('password')
                            ->password()
                            ->required(),
                    ])

            ]);
    }
}
