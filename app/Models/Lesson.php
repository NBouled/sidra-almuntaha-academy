<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lesson extends Model
{
    protected $guarded = [];


    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function teacher(): BelongsTo {
        return $this->belongsTo(Teacher::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'lesson_students')
            ->using(LessonStudent::class)
            ->withPivot(['credit_txn_id', 'attendance'])
            ->withTimestamps();
    }

    public function bookLesson(Customer $customer, array $studentIds)
    {
        // gebruik 1 credit per les
        LessonCredit::useCredit($customer, $studentIds, $this);

        $this->students()->sync($studentIds);
        $this->status = 'booked';
        $this->save();
    }


    public function cancelLesson()
    {
        LessonCredit::restoreCredit($this);
        $this->status = 'cancelled';
        $this->save();
    }


}
