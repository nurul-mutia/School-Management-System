<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\User;

class SchoolDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Kelas Dummy
        $kelas1 = SchoolClass::create(['class_name' => '10 IPA 1']);
        $kelas2 = SchoolClass::create(['class_name' => '11 IPS 2']);

        // 2. Buat Mapel Dummy
        Subject::firstOrcreate([
           'kode_mapel' => 'MTK',
           'subject_name' => 'Matematika',
        ]);

        Subject::firstOrcreate([
           'kode_mapel' => 'BIN',
           'subject_name' => 'Bahasa Indonesia',
        ]);

        // 3. Buat User + Siswa Dummy
        $userSiswa = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => bcrypt('password'),
        ]);

        Student::create([
            'user_id' => $userSiswa->id,
            'nisn' => 'STD-001',
            'school_class_id' => $kelas1->id,
            'status' => 'Aktif',
        ]);
    }
}