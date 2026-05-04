<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number', 'building', 'capacity'
    ];

    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}