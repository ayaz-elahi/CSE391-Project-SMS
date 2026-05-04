<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'student_id', 'faculty_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isFaculty()
    {
        return $this->role === 'faculty';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }

    // Faculty relationships
    public function sections()
    {
        return $this->hasMany(Section::class, 'faculty_id');
    }

    // Student relationships
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }
}