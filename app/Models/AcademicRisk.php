<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcademicRisk extends Model
{
    protected $table = 'academic_risk';
    
    protected $fillable = [
        'student_id',
        'course_id',
        'attendance_percentage',
        'internal_marks',
        'external_marks',
        'risk_level',
        'risk_score',
        'risk_description',
        'recommendations',
        'prediction_date',
        'is_notified',
    ];

    protected $casts = [
        'prediction_date' => 'datetime',
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
