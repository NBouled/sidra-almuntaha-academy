<?php

namespace App\Filament\Resources\Teachers\Schemas;

use App\Enums\Gender;
use App\Enums\UserRole;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Operation;
use Illuminate\Database\Eloquent\Builder;

class TeacherForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Rate limiting')
                    ->columns()
                    ->columnSpanFull()
                    ->schema([
                        Select::make('user_id')
                            ->hiddenOn(Operation::Edit)
                            ->relationship('user', 'name',        modifyQueryUsing: fn (Builder $query) => $query
                                ->where('role', UserRole::TEACHER)
                                ->doesntHave('teacher'))
                            ->required(),

                        Radio::make('gender')
                            ->inline()
                            ->required()
                            ->options(Gender::class),

                        TextInput::make('zoom_account'),
                        RichEditor::make('bio'),
                        FileUpload::make('profile_picture')
                    ])



            ]);
    }
}
