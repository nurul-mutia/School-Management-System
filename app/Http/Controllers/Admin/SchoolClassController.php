<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::withCount('students')->get();
        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        return view('classes.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_name' => 'required|string|max:255|unique:tbl_classes,class_name',
        ]);

        SchoolClass::create([
            'class_name' => $request->class_name,
        ]);

        return redirect()->route('classes.index')->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function edit(SchoolClass $class)
    {
        return view('classes.edit', compact('class'));
    }

    public function update(Request $request, SchoolClass $class)
    {
        $request->validate([
            'class_name' => 'required|string|max:255|unique:tbl_classes,class_name,' . $class->id,
        ]);

        $class->update([
            'class_name' => $request->class_name,
        ]);

        return redirect()->route('classes.index')->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy(SchoolClass $class)
    {
        $class->delete();
        return redirect()->route('classes.index')->with('success', 'Data kelas berhasil dihapus.');
    }
}