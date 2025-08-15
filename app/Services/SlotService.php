<?php

namespace App\Services;

use App\Models\TeacherUnavailability;
use App\Models\Lesson;
use Carbon\Carbon;

class SlotService
{
    public function getAvailableSlotsForDate($teacherId, $date)
    {
        $slots = [];
        $startHour = 7;
        $endHour = 23;
        $lessonMinutes = 55;

        $unavailable = TeacherUnavailability::where('teacher_id', $teacherId)
            ->where('date', $date)
            ->pluck('slot_start_time')
            ->toArray();

        $booked = Lesson::where('teacher_id', $teacherId)
            ->whereDate('start_time', $date)
            ->pluck('start_time')
            ->map(fn($time) => Carbon::parse($time)->format('H:i'))
            ->toArray();

        for ($hour = $startHour; $hour < $endHour; $hour++) {
            $startTime = sprintf('%02d:00', $hour);

            if (in_array($startTime, $unavailable) || in_array($startTime, $booked)) {
                continue;
            }

            $slots[] = [
                'start' => $startTime,
                'end' => Carbon::parse($startTime)->addMinutes($lessonMinutes)->format('H:i'),
            ];
        }

        return $slots;
    }
}
