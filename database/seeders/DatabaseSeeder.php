<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Student;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Data Kelas
        $kelas1 = SchoolClass::create(['class_name' => '10 IPA 1']);
        $kelas2 = SchoolClass::create(['class_name' => '10 IPS 1']);

        // 2. Data Mata Pelajaran
        $mapel1 = Subject::create(['subject_code' => 'MP-001', 'subject_name' => 'Matematika']);
        $mapel2 = Subject::create(['subject_code' => 'MP-002', 'subject_name' => 'Bahasa Indonesia']);

        // 3. Data User & Guru
        $userGuru = User::firstOrCreate(
            ['email' => 'guru@gmail.com'],
            [
                'name' => 'Budi Susanto, S.Pd',
                'password' => bcrypt('password'),
                'role' => 'guru',
            ]
        );

        Teacher::create([
            'user_id' => $userGuru->id,
            'nip' => '198501012010011001',
            'subject_id' => $mapel1->id
        ]);
        // Data User Admin (Full Access)
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );
        // 4. Data User & Siswa
        $userSiswa = User::firstOrCreate(
            ['email' => 'siswa@gmail.com'],
            [
                'name' => 'Budi Santoso',
                'password' => bcrypt('password'),
                'role' => 'siswa',
            ]
        );

        // Tambahkan semua kolom wajib di sini:
        Student::create([
            'user_id'         => $userSiswa->id,
            'class_id'        => $kelas1->id,
            'nisn'            => '0012345678',
            'name'            => 'Budi Santoso',
            'slug'            => 'budi-santoso',
            'email'           => 'budi.santoso@gmail.com',
            'tuition_fee'     => 500000,
            'enrollment_date' => now()->toDateString(),
        ]);
    }
}