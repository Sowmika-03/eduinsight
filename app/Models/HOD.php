<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HOD extends Model
{
    use HasFactory;

    protected $table = 'hods';

    protected $fillable = [
        'user_id',
        'employee_id',
        'department',
        'specialization',
        'qualification',
        'experience_years',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function faculty(): HasMany
    {
        return $this->hasMany(Faculty::class, 'department_id', 'id');
    }

    public function affectedStudents(): HasMany
    {
        // Get all students in courses taught by faculty in this HOD's department
        return $this->hasMany(Student::class);
    }
}
