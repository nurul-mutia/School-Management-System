<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory;

    protected $table = 'tbl_students';

    protected $fillable = [
        'user_id',
        'class_id',
        'nisn',
        'name',
        'slug',
        'email',
        'status',
        'tuition_fee',
        'enrollment_date',
        'photo',
        'archived',
    ];

    // Relasi Database ke tbl_classes (JOIN)
    
    // Relasi utama ke tbl_classes
    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    // Tambahkan alias ini agar pemanggilan 'class' tidak error
    public function class(): BelongsTo
    {
        return $this->schoolClass();
    }
    // Relasi Database ke tbl_users
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // Global Scope untuk soft delete
    protected static function booted(): void
    {
        static::addGlobalScope('not_archived', function (Builder $builder) {
            $builder->where('archived', false);
        });
    }
}