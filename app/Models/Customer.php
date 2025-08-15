<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
        protected $guarded = [];

        public function user(): BelongsTo {
            return $this->belongsTo(User::class);
        }

        public function students(): HasMany {
            return $this->hasMany(Student::class);
        }

        public function subscriptions(): HasMany {
            return $this->hasMany(Subscription::class);
        }

        public function lessonCredits($studentId = null)
        {
            return LessonCredit::availableCredits($this->id, $studentId);
        }

    public function addLessonCredit(Student $student = null, string $description = 'Credit added')
    {
        $this->lessonCredits()->create([
            'student_id' => $student?->id,
            'description' => $description,
            'status' => 'active',
        ]);
    }

    public function availableCredits(): int
    {
        return $this->lessonCredits()->where('status', 'active')->count();
    }
    }
