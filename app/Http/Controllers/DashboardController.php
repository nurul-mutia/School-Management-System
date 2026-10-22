<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\Subject;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total data
        $totalUsers    = User::count();
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalClasses  = SchoolClass::count();
        $totalSubjects = Subject::count();

        // Ambil 5 siswa terbaru beserta relasi kelas dan user
        $latestStudents = Student::with(['schoolClass', 'user'])->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalUsers',
            'totalStudents',
            'totalTeachers',
            'totalClasses',
            'totalSubjects',
            'latestStudents'
        ));
    }
}