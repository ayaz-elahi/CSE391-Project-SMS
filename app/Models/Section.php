<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 'faculty_id', 'classroom_id', 'section_name', 
        'max_students', 'enrolled_students', 'semester', 'year'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function faculty()
    {
        return $this->belongsTo(User::class, 'faculty_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function approvedEnrollments()
    {
        return $this->hasMany(Enrollment::class)->where('status', 'approved');
    }

    public function getRemainingSeatsAttribute()
    {
        return $this->max_students - $this->enrolled_students;
    }
}