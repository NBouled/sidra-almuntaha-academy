<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
  protected $guarded = [];


    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function lessons(): HasMany {
        return $this->hasMany(Lesson::class);
    }

    public function availabilities(): HasMany {
        return $this->hasMany(TeacherAvailability::class);
    }

    public function homeworks(): HasMany {
        return $this->hasMany(Homework::class);
    }

    public function notes(): HasMany {
        return $this->hasMany(StudentNote::class);
    }
}
