<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    protected $guarded = [];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class);
    }

    public function lessonCredits() {
        return $this->hasMany(LessonCredit::class);
    }

    public function availableCredits(): int {
        return LessonCredit::availableCredits($this->customer_id, $this->id);
    }

    public function lessons(): BelongsToMany {
        return $this->belongsToMany(Lesson::class, 'lesson_students')
            ->using(LessonStudent::class)
            ->withPivot(['credit_txn_id', 'attendance'])
            ->withTimestamps();
    }

    public function notes(): HasMany {
        return $this->hasMany(StudentNote::class);
    }
}
