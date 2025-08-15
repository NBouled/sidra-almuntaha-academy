<?php

namespace App\Filament\Resources\Teachers\Pages;

use App\Filament\Resources\Teachers\TeacherResource;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class TeacherSchedule extends Page
{
    use InteractsWithRecord;

    protected static string $resource = TeacherResource::class;

    protected string $view = 'filament.resources.teachers.pages.teacher-schedule';

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }
}
