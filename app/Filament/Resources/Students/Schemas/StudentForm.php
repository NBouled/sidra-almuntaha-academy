<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('customer_id')
                    ->relationship('customer', 'id')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('gender')
                    ->required(),
                DatePicker::make('date_of_birth'),
            ]);
    }
}
