<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Gunakan 'schoolClass', bukan 'class'
        $students = Student::with(['schoolClass', 'user'])->latest()->get();

        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = SchoolClass::all();
        return view('students.add', compact('classes'));
    }

    public function edit($id)
    {
        // Ambil data siswa yang akan diedit
        $student = Student::findOrFail($id);

        // Ambil semua data kelas
        $classes = SchoolClass::all();

        // Kirim $student dan $classes ke view edit
        return view('students.edit', compact('student', 'classes'));
    }
    // Tambahkan juga method update() untuk proses simpan perubahannya
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        // 1. Validasi Input
        $request->validate([
            'nisn'     => 'required|unique:tbl_students,nisn,' . $student->id,
            'name'     => 'required|string|max:255',
            'class_id' => 'required|exists:tbl_classes,id',
            'status'   => 'nullable|string',
        ]);

        // 2. Update Data Student
        $student->update([
            'nisn'     => $request->nisn,
            'name'     => $request->name,
            'class_id' => $request->class_id,
            'status'   => $request->status,
            'slug'     => Str::slug($request->name),
        ]);

        // 3. Update nama pada User terkait (jika ada relasi user)
        if ($student->user) {
            $student->user->update([
                'name' => $request->name,
            ]);
        }

        return redirect()->route('students.index')->with('success', 'Student data updated successfully!');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi hanya field yang ada di form
        $request->validate([
            'nisn'     => 'required|unique:tbl_students,nisn',
            'name'     => 'required|string|max:255',
            'class_id' => 'required|exists:tbl_classes,id',
        ]);

        // 2. Buat Email dan Password Default/Otomatis
        $email = $request->nisn . '@student.com'; // Contoh email berbasis NISN
        $password = Hash::make('password123');    // Password default

        // 3. Buat Akun User
        $user = User::create([
            'name'     => $request->name,
            'email'    => $email,
            'password' => $password,
            'role'     => 'student',
        ]);

        // 4. Simpan Student
        Student::create([
            'user_id'         => $user->id,
            'class_id'        => $request->class_id,
            'nisn'            => $request->nisn,
            'name'            => $request->name,
            'email'           => $email,
            'slug'            => Str::slug($request->name),
            'enrollment_date' => now(),
            'archived'        => 0,
        ]);

        return redirect()->route('students.index')->with('success', 'Student created successfully!');
    }

    // Tambahkan method destroy ini di dalam class StudentController
    public function destroy($id)
    {
        // 1. Pengecekan role Admin (Opsional)
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya Admin yang dapat menghapus data siswa.');
        }

        // 2. Eksekusi Hapus Data
        DB::transaction(function () use ($id) {
            // Cari data siswa berdasarkan ID
            $student = Student::findOrFail($id);

            // Hapus akun user terkait di tbl_users (jika ada relasi user_id)
            if ($student->user_id) {
                User::where('id', $student->user_id)->delete();
            }

            // Hapus data siswa di tbl_students
            $student->delete();
        });

        // 3. Redirect kembali ke halaman utama siswa dengan pesan sukses
        return redirect()->route('students.index')->with('success', 'Data siswa berhasil dihapus!');
    }
}