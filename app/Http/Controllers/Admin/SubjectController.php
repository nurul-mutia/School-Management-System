<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SubjectController extends Controller implements HasMiddleware
{
    /**
     * Define middleware for the controller.
     * Restricts modification actions to users with the 'admin' role.
     */
    public static function middleware(): array
    {
        return [
            'auth', // All actions require authentication
            new Middleware('role:admin', except: ['index']), // Only admins can create, edit, store, update, destroy
        ];
    }

    /**
     * Display a listing of the subjects (accessible by all authenticated users).
     */
    public function index()
    {
        $subjects = Subject::latest()->paginate(10);

        return view('subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new subject (Admin only).
     */
    public function create()
    {
        return view('subjects.add');
    }

    /**
     * Store a newly created subject in storage (Admin only).
     */
    /**
     * Store a newly created subject in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Tentukan nama_kolom_database secara spesifik pada aturan unique:
            // unique:nama_tabel,nama_kolom_di_db
            'code' => 'required|string|max:20|unique:tbl_subjects,subject_code',
            'name' => 'required|string|max:100',
        ]);

        Subject::create([
            'subject_code' => $validated['code'],
            'subject_name' => $validated['name'],
        ]);

        return redirect()->route('subjects.index')
            ->with('success', '✨ Subject created successfully!');
    }

    /**
     * Update the specified subject in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            // unique:nama_tabel,nama_kolom_di_db,id_yang_diabaikan
            'code' => 'required|string|max:20|unique:tbl_subjects,subject_code,' . $subject->id,
            'name' => 'required|string|max:100',
        ]);

        $subject->update([
            'subject_code' => $validated['code'],
            'subject_name' => $validated['name'],
        ]);

        return redirect()->route('subjects.index')
            ->with('success', '🎉 Subject updated successfully!');
    }

    /**
     * Show the form for editing the specified subject (Admin only).
     */
    public function edit(Subject $subject)
    {
        return view('subjects.edit', compact('subject'));
    }

    /**
     * Update the specified subject in storage (Admin only).
     */

    /**
     * Remove the specified subject from storage (Admin only).
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()->route('subjects.index')
            ->with('success', '🗑️ Subject deleted successfully!');
    }
}