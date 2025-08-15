<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LessonCredit extends Model
{
    protected $fillable = [
        'customer_id',
        'student_id',
        'lesson_id',
        'description',
        'status',
        'used_at',
    ];

    protected $dates = [
        'used_at',
    ];


    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class);
    }

    public function student(): BelongsTo {
        return $this->belongsTo(Student::class);
    }

    public function lesson(): BelongsTo {
        return $this->belongsTo(Lesson::class);
    }

    // Beschikbare credits berekenen
    public static function availableCredits($customerId, $studentId = null): int {
        $query = self::where('customer_id', $customerId)
            ->where('status', 'active');

        if ($studentId) $query->where('student_id', $studentId);

        return $query->sum('credits_added') - $query->sum('credits_used');
    }

    // Credits gebruiken voor een les
    public static function useCredit(Customer $customer, array $studentIds = [], Lesson $lesson)
    {
        $credit = $customer->lessonCredits()->where('status', 'active')->first();
        if (!$credit) {
            throw new \Exception('No credits available');
        }
        $credit->update([
            'status' => 'used',
            'lesson_id' => $lesson->id,
            'student_id' => $studentIds[0] ?? null
        ]);
        return $credit;
    }

    // Credits herstellen bij annulering
    public static function restoreCredit(Lesson $lesson): void
    {
        $credit = self::where('lesson_id', $lesson->id)->first();
        if ($credit) {
            $credit->update([
                'status' => 'active',
                'lesson_id' => null,
                'student_id' => null,
            ]);
        }
    }
}
