<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        // Mengambil data user yang belum di-archive (soft delete)
        $users = User::where('archived', false)->latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:tbl_users,email',
            'password' => 'required|string|min:8',
            'role'     => 'required|string',
            'photo'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photoName = null;

        // 2. Upload Foto
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $cleanFileName = str_replace(' ', '-', $file->getClientOriginalName());
            $photoName = date('YmdHis') . '-' . $cleanFileName;
            
            $file->move(public_path('uploads/users'), $photoName);
        }

        // 3. Buat User Baru
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'photo'    => $photoName,
            'archived' => false,
        ]);

        // 4. Assign Role dari Spatie (Dijalankan SETELAH $user berhasil dibuat)
        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        // 1. Validasi Input (Hanya berisi aturan validasi)
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:tbl_users,email,' . $user->id,
            'role'  => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ];

        // 2. Update Password jika diisi
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8']);
            $data['password'] = Hash::make($request->password);
        }

        // 3. Upload & Ganti Foto
        if ($request->hasFile('photo')) {
            if ($user->photo && File::exists(public_path('uploads/users/' . $user->photo))) {
                File::delete(public_path('uploads/users/' . $user->photo));
            }

            $file = $request->file('photo');
            $cleanFileName = str_replace(' ', '-', $file->getClientOriginalName());
            $photoName = date('YmdHis') . '-' . $cleanFileName;
            
            $file->move(public_path('uploads/users'), $photoName);
            $data['photo'] = $photoName;
        }

        // 4. Update Data User
        $user->update($data);

        // 5. Sync Role Spatie (Dipanggil SETELAH data user berhasil di-update)
        $user->syncRoles([$request->role]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }
    /**
     * Soft delete user using 'archived' field.
     */
    public function destroy(User $user)
    {
        // Poin 10: Aturan Soft Delete menggunakan field archived
        $user->update(['archived' => true]);

        return redirect()->route('users.index')->with('success', 'User archived successfully.');
    }
}