<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// HAPUS baris "use App\Models\Student;" jika ada di bagian atas ini!

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'tbl_classes';

    protected $fillable = [
        'class_name',
    ];

    public function students()
    {
        // Langsung panggil Student::class tanpa perlu panggil namespace lagi
        return $this->hasMany(Student::class, 'class_id');
    }
}