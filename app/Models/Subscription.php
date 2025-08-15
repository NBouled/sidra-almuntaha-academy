<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'customer_id',
        'stripe_subscription_id',
        'type', // 'single' = 1 leraar - 1 student, 'duo' = 1 leraar - 2 studenten
        'price', // 8 of 10 euro exclusief btw
        'status', // active, canceled, past_due
        'start_date',
        'end_date',
    ];

    protected $dates = [
        'start_date',
        'end_date',
    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function lessonCredits()
    {
        return $this->hasMany(LessonCredit::class);
    }

    public function allocateMonthlyCredits(): void
    {
        $creditsPerMonth = $this->type === 'duo' ? 2 : 1;

        foreach ($this->customer->students as $student) {
            for ($i = 0; $i < $creditsPerMonth; $i++) {
                $this->lessonCredits()->create([
                    'student_id' => $student->id,
                    'description' => 'Monthly subscription credit',
                    'status' => 'active',
                ]);
            }
        }
    }


}

