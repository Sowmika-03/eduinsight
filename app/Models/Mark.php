<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mark extends Model
{
    protected $fillable = [
        'student_id',
        'course_id',
        'internal_marks',
        'external_marks',
        'total_marks',
        'grade',
        'assessment_type',
        'mark_date',
        'feedback',
    ];

    protected $casts = [
        'mark_date' => 'date',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
