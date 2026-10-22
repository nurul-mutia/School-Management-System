<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'tbl_subjects';

    protected $fillable = [
    'subject_code',
    'subject_name',
    ];

    // Relasi ke Model Teacher
    public function teachers()
    {
        return $this->hasMany(Teacher::class, 'subject_id');
    }
    
    public function getCodeAttribute()
    {
        return $this->attributes['subject_code'] 
            ?? $this->attributes['code'] 
            ?? null;
    }

    /**
     * Accessor untuk $subject->name
     * Mendukung pemanggilan $subject->name jika nama kolom di database adalah subject_name / name
     */
    public function getNameAttribute()
    {
        return $this->attributes['subject_name'] 
            ?? $this->attributes['name'] 
            ?? null;
    }
  
}