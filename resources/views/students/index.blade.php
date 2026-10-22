@extends('layouts.app')

@section('content')
<div class="space-y-4">
    {{-- Breadcrumbs Navigation --}}
    <nav class="flex px-5 py-3 text-gray-700 border border-gray-100 rounded-xl bg-white shadow-sm mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600">
                    🏠 Dashboard
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <span class="mx-2 text-gray-400">/</span>
                    <span class="text-sm font-medium text-indigo-600">Student Management</span>
                </div>
            </li>
        </ol>
    </nav>
    {{-- Header & Add Student Button --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">🎓 Student List</h2>
            <p class="text-sm text-gray-500">Manage all student records in the school.</p>
        </div>

        {{-- ADD button visible ONLY for Admin --}}
        @if(auth()->check() && auth()->user()->role === 'admin')
            <a href="{{ route('students.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition shadow-sm">
                ➕ Add Student
            </a>
        @endif
    </div>

    {{-- Student Data Table --}}
    <div class="overflow-x-auto bg-white rounded-xl shadow-sm border border-gray-100">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">NISN</th>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Class</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Join Date</th>
                    {{-- Actions column header visible ONLY for Admin --}}
                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <th class="px-6 py-3 text-right">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($students as $index => $student)
                    <tr class="hover:bg-gray-50/50 transition">
                        {{-- 1. Index Number --}}
                        <td class="px-6 py-4 text-gray-400 font-medium">
                            {{ $loop->iteration }}
                        </td>

                        {{-- 2. NISN --}}
                        <td class="px-6 py-4 font-mono text-xs text-gray-600">
                            {{ $student->nisn ?? '-' }}
                        </td>

                        {{-- 3. Student Name --}}
                        <td class="px-6 py-4 font-semibold text-gray-900">
                            {{ $student->name ?? $student->nama ?? ($student->user->name ?? '-') }}
                        </td>

                        {{-- 4. Class --}}
                        <td class="px-6 py-4">
                            @php
                                $className = $student->schoolClass->class_name ?? $student->class->class_name ?? $student->class_name ?? null;
                            @endphp

                            @if($className)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold text-indigo-700 bg-indigo-50 rounded-full">
                                    📚 {{ $className }}
                                </span>
                            @else
                                <span class="text-gray-400 font-medium">-</span>
                            @endif
                        </td>
                        {{-- 5. Status --}}
                        <td class="px-6 py-4">
                            @if(($student->status ?? 'active') === 'active')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold text-emerald-700 bg-emerald-50 rounded-full">
                                    🟢 Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold text-rose-700 bg-rose-50 rounded-full">
                                    🔴 Move
                                </span>
                            @endif
                        </td>

                        {{-- 6. Join Date (English Format: 03 October 2026) --}}
                        <td class="px-6 py-4 text-gray-600">
                            {{ \Carbon\Carbon::parse($student->created_at)->format('d F Y') }}
                        </td>

                        {{-- 7. EDIT & DELETE buttons visible ONLY for Admin --}}
                        @if(auth()->check() && auth()->user()->role === 'admin')
                            <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('students.edit', $student->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-amber-600 bg-amber-50 rounded-lg border border-amber-200 hover:bg-amber-100 transition">
                                    ✏️ Edit
                                </a>
                                
                                <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-rose-600 bg-rose-50 rounded-lg border border-rose-200 hover:bg-rose-100 transition" onclick="return confirm('Are you sure you want to delete this student record?')">
                                        🗑️ Delete
                                    </button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->check() && auth()->user()->role === 'admin' ? 7 : 6 }}" class="px-6 py-8 text-center text-gray-400">
                            📂 No student data available.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection