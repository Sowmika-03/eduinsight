<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alert extends Model
{
    protected $fillable = [
        'student_id',
        'course_id',
        'alert_type',
        'message',
        'severity',
        'is_read',
        'alert_date',
        'action_taken',
    ];

    protected $casts = [
        'alert_date' => 'date',
        'is_read' => 'boolean',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Email logs related to this alert
     */
    public function emailLogs()
    {
        return $this->morphMany(EmailLog::class, 'emailable');
    }
}
