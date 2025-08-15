<?php

namespace App\Livewire;

use App\Models\TeacherUnavailability;
use Carbon\CarbonPeriod;
use Filament\Notifications\Notification;
use Livewire\Component;
use Carbon\Carbon;
use App\Models\Lesson;


class TeacherWeekSchedule extends Component
{
    public $teacherId;
    public $weekDays = [];
    public $timeSlots = [];

    public $weekOffset = 0; // 0 = deze week, +1 = volgende week, -1 = vorige week

    public function mount($teacherId)
    {
        $this->teacherId = $teacherId;

        // Tijdsloten van 07:00 tot 24:00 met 1 uur tussen startpunten (55 min les)
        $this->timeSlots = collect(range(7, 23))->map(fn($hour) => sprintf('%02d:00:00', $hour));

        // De weekdagen van deze week
        $this->loadWeek();
    }



    public function loadWeek()
    {
        $start = now()->startOfWeek()->addWeeks($this->weekOffset);
        $end = now()->endOfWeek()->addWeeks($this->weekOffset);

        $this->weekDays = collect(CarbonPeriod::create($start, $end))->map(fn($date) => $date->format('Y-m-d'));
    }

    public function nextWeek()
    {
        $this->weekOffset++;
        $this->loadWeek();
    }

    public function previousWeek()
    {
        $this->weekOffset--;
        $this->loadWeek();
    }

    public function isSlotBooked($day, $slot)
    {
        return Lesson::where('teacher_id', $this->teacherId)
            ->whereDate('starts_at', $day)
            ->whereTime('starts_at', $slot)
            ->exists();
    }

    public function isSlotBlocked($day, $slot)
    {
        return TeacherUnavailability::where('teacher_id', $this->teacherId)
            ->where('date', $day)
            ->where('slot_start_time', $slot)
            ->exists();
    }

    public function toggleBlock($day, $slot)
    {

        // Check of er al een les is geboekt
        $exists = Lesson::where('teacher_id', $this->teacherId)
            ->whereDate('starts_at', $day)
            ->whereTime('starts_at', $slot)
            ->exists();

        if ($exists) {

            Notification::make()
                ->title('Slot booked')
                ->body('Cannot block this slot, lesson is already booked')
                ->danger()
                ->send();

            return;
        }




        $startDateTime = Carbon::parse($day . ' ' . $slot);

        // Check: binnen 24 uur
        if ($startDateTime->lessThan(now()->addDay())) {
            Notification::make()
                ->title('Cannot block slot')
                ->body('You cannot block a slot within the next 24 hours.')
                ->danger()
                ->send();

            return;
        }


        // Toggle blokkade
        $unavailability = TeacherUnavailability::where('teacher_id', $this->teacherId)
            ->where('date', $day)
            ->where('slot_start_time', $slot)
            ->first();

        if ($unavailability) {
            $unavailability->delete();

            Notification::make()
                ->title('Successfully unblocked slot')
                ->body($day . ' ' . $slot )
                ->success()
                ->send();
        } else {
            TeacherUnavailability::create([
                'teacher_id' => $this->teacherId,
                'date' => $day,
                'slot_start_time' => $slot,
            ]);

            Notification::make()
                ->title('Successfully blocked slot')
                ->body($day . ' ' . $slot )
                ->success()
                ->send();
        }


    }

    public function render()
    {
        return view('livewire.teacher-week-schedule');
    }
}

