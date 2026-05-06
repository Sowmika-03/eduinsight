<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Faculty extends Model
{
    protected $table = 'faculty';
    
    protected $fillable = [
        'user_id',
        'employee_id',
        'department',
        'specialization',
        'qualification',
        'experience_years',
        'approval_status',
        'max_students',
        'rejection_reason',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function assignedStudents(): BelongsToMany
    {
        return $this->belongsToMany(
            Student::class,
            'faculty_students',
            'faculty_id',
            'student_id'
        )->withTimestamps();
    }

    public function hod(): BelongsTo
    {
        return $this->belongsTo(HOD::class, 'department_id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Get count of assigned students
    public function getAssignedStudentCount()
    {
        return $this->assignedStudents()->count();
    }

    // Check if faculty can accept more students
    public function canAcceptMoreStudents()
    {
        return $this->getAssignedStudentCount() < $this->max_students;
    }

    // Check if faculty is approved
    public function isApproved()
    {
        return $this->approval_status === 'approved';
    }
}
