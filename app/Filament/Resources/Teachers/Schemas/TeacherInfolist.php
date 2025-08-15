<?php

namespace App\Filament\Resources\Teachers\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TeacherInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Rate limiting')
                    ->columns()
                    ->columnSpanFull()
                    ->schema([

                TextEntry::make('user.name')
                    ->numeric(),
                TextEntry::make('zoom_account'),
                TextEntry::make('bio'),
                TextEntry::make('profile_picture'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),

                        ])
            ]);
    }
}
