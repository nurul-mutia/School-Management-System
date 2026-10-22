<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subject;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'tbl_teachers';

    protected $fillable = [
        'user_id',
        'nip',
        'subject_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function learningActivities()
    {
        return $this->hasMany(LearningActivity::class, 'teacher_id');
    }
}