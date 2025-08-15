<?php

namespace App\Models;

use App\Observers\TeacherUnavailabilityObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([TeacherUnavailabilityObserver::class])]
class TeacherUnavailability extends Model
{
    protected $fillable = [
        'teacher_id',
        'date',
        'slot_start_time',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
