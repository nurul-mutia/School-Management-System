<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    // Tambahkan method index ini
   public function index()
   {
        // Mengambil data teacher beserta relasi user dan subject
        $teachers = Teacher::with(['user', 'subject'])->latest()->paginate(10);
   
        return view('teachers.index', compact('teachers'));
    }

    // ... method create, store, edit, update lainnya

    // Restriksi di level Controller:
    public function create()
    {
        if (auth()->user()->role !== 'admin') {
             abort(403, 'Unauthorized action.');
        }
        $subjects = Subject::all();

       return view('teachers.add', compact('subjects'));
    }

    public function edit($id)
    {
        if (auth()->user()->role !== 'admin') {
             abort(403, 'Unauthorized action.');
        }
        $teacher = Teacher::with('user')->findOrFail($id);
    
        // Load relasi user dan subject agar datanya tersedia di form edit
        $teacher->load(['user', 'subject']);
    
        // Ambil semua daftar mata pelajaran untuk dropdown
        $subjects = \App\Models\Subject::all();

        return view('teachers.edit', compact('teacher', 'subjects'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
             abort(403, 'Unauthorized action.');
        }
        // 1. Validasi Input dari Form
        $request->validate([
            'nip'        => 'required|unique:tbl_teachers,nip',
            'name'       => 'required|string|max:255',
            'subject_id' => 'required',
            'status'     => 'required',
        ]);

        // 2. Transaksi Simpan Data Ke Database
        DB::transaction(function () use ($request) {
        
            // Buat email otomatis jika tidak diinput dari form (misal: sitirahma@school.com)
            $email = $request->email ?? strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $request->name)) . '@school.com';

            // 1. Simpan ke tabel users
            $user = User::create([
                'name'     => $request->name,
                'email'    => $email, // <--- Pastikan email terisi
                'password' => bcrypt('password123'), // Password bawaan/default
                'role'     => 'teacher',
            ]);

            // 2. Simpan ke tabel teachers
            Teacher::create([
                'user_id'    => $user->id,
                'nip'        => $request->nip,
                'name'       => $request->name,
                'subject_id' => $request->subject_id,
                'status'     => $request->status,
            ]);
        });

        return redirect()->route('teachers.index')->with('success', 'Data guru berhasil disimpan!');
    }
    public function update(Request $request, $id)
    {
    
        if (auth()->user()->role !== 'admin') {
             abort(403, 'Unauthorized action.');
        }

        // Cari Data Teacher dan User terkait
        $teacher = Teacher::findOrFail($id);
        $user    = User::findOrFail($teacher->user_id);

        // 2. Validasi Data Input
        $request->validate([
            'nip'        => ['nullable', 'string', Rule::unique('tbl_teachers', 'nip')->ignore($teacher->id)],
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'max:255', Rule::unique('tbl_users', 'email')->ignore($user->id)],
            'subject_id' => ['nullable', 'exists:tbl_subjects,id'],
            'status'     => ['required', 'in:active,inactive'],
            'password'   => ['nullable', 'string', 'min:6'],
        ]);

        // 3. Update Data User (Tabel tbl_users - termasuk name, email, dan status)
        $userData = [
            'name'   => $request->name,
            'email'  => $request->email,
            'status' => $request->status, // <-- Status disimpan di tabel users
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        // 4. Update Data Teacher (Tabel tbl_teachers - hapus 'status' dari sini)
        $teacher->update([
            'nip'        => $request->nip,
            'subject_id' => $request->subject_id,
        ]);

        return redirect()->route('teachers.index')->with('success', 'Teacher profile updated successfully!');
    }

    // Tambahkan method ini di dalam class TeacherController
    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
             abort(403, 'Unauthorized action.');
        }

        DB::transaction(function () use ($id) {
            // Cari data guru berdasarkan ID
            $teacher = Teacher::findOrFail($id);

            // Hapus akun user terkait (jika ada relasi user_id)
            if ($teacher->user_id) {
                User::where('id', $teacher->user_id)->delete();
            }

            // Hapus data guru
            $teacher->delete();
        });

        return redirect()->route('teachers.index')->with('success', 'Data guru berhasil dihapus!');
    }
    
}