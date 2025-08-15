<?php

namespace App\Observers;

use App\Models\Lesson;
use App\Models\TeacherUnavailability;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class TeacherUnavailabilityObserver
{


    public function creating(TeacherUnavailability $unavailability)
    {
        $startDateTime = Carbon::parse($unavailability->date . ' ' . $unavailability->slot_start_time);

        // 1️⃣ Check of de slot binnen 24 uur ligt
        if ($startDateTime->lessThan(Carbon::now()->addDay())) {
            throw ValidationException::withMessages([
                'slot_start_time' => 'You cannot block a slot within the next 24 hours.',
            ]);
        }

        // 2️⃣ Check of er al een les geboekt is op dat tijdstip
        $exists = Lesson::where('teacher_id', $unavailability->teacher_id)
            ->where('starts_at', $startDateTime)
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'slot_start_time' => 'Cannot block this slot, a lesson is already booked by a student.',
            ]);
        }
    }


    /**
     * Handle the TeacherUnavailability "created" event.
     */
    public function created(TeacherUnavailability $teacherUnavailability): void
    {
        //
    }

    /**
     * Handle the TeacherUnavailability "updated" event.
     */
    public function updated(TeacherUnavailability $teacherUnavailability): void
    {
        //
    }

    /**
     * Handle the TeacherUnavailability "deleted" event.
     */
    public function deleted(TeacherUnavailability $teacherUnavailability): void
    {
        //
    }

    /**
     * Handle the TeacherUnavailability "restored" event.
     */
    public function restored(TeacherUnavailability $teacherUnavailability): void
    {
        //
    }

    /**
     * Handle the TeacherUnavailability "force deleted" event.
     */
    public function forceDeleted(TeacherUnavailability $teacherUnavailability): void
    {
        //
    }
}
