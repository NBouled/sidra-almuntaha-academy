<?php

namespace App\Filament\Resources\Teachers\Pages;

use App\Filament\Resources\Teachers\TeacherResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTeacher extends ViewRecord
{
    protected static string $resource = TeacherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            Action::make('schedule')
                ->label('Availability')
                ->icon('heroicon-o-calendar') // voorbeeld icon, kan elk heroicon
                ->color('secondary') // kleur van de button
                ->url(fn (): string => TeacherSchedule::getUrl([
                    'record' => $this->record->getKey(),
                ]))
                ->openUrlInNewTab(false),
        ];
    }
}
