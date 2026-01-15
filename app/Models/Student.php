<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
     use HasFactory;

    protected $table = 'table_students';

     

    protected $fillable = [
        'user_id',
        'student_code',
        'first_name',
        'last_name',
        'gender',
        'dob',
        'nationality',
        'address',
        'university',
        'program',
        'level',
        'academic_year',
        'city',
        'passport_number',
        'cnib_number',
        'medical_history',
        'height',
        'weight',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


      public function documents()
    {
    return $this->hasMany(Document::class);
    }
}
