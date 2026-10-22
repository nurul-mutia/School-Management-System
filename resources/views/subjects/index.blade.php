@extends('layouts.app')

@section('content')
<div class="space-y-4">
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
                    <span class="text-sm font-medium text-indigo-600">Subject Management</span>
                </div>
            </li>
        </ol>
    </nav>
    {{-- Header & Add Subject Button --}}
    <div class="flex items-center justify-between bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center gap-3">
            <div class="p-3 bg-indigo-50 text-2xl rounded-xl">
                📚
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800">Subject Management</h2>
                <p class="text-sm text-gray-500">Manage all curriculum subjects and course details.</p>
            </div>
        </div>

        {{-- Tombol ADD HANYA tampil untuk Admin --}}
        @if(auth()->check() && auth()->user()->role === 'admin')
            <a href="{{ route('subjects.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition shadow-sm">
                ➕ Add Subject
            </a>
        @endif
    </div>

    {{-- Subject Data Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100">
            <h3 class="text-base font-bold text-gray-800 flex items-center gap-2">
                📋 All Subjects List
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-xs text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-3">#</th>
                        <th class="px-6 py-3">SUBJECT CODE</th>
                        <th class="px-6 py-3">SUBJECT NAME</th>
                        
                        {{-- Header ACTIONS HANYA tampil untuk Admin --}}
                        @if(auth()->check() && auth()->user()->role === 'admin')
                            <th class="px-6 py-3 text-right">ACTIONS</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($subjects as $index => $subject)
                        <tr class="hover:bg-gray-50/50 transition">
                            {{-- 1. Number --}}
                            <td class="px-6 py-4 text-gray-400 font-medium">
                                {{ $loop->iteration }}
                            </td>

                            {{-- 2. Subject Code --}}
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-xs font-mono font-semibold text-indigo-700 bg-indigo-50 rounded-md">
                                    {{ $subject->code ?? $subject->subject_code ?? 'MP-'.str_pad($subject->id, 3, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>

                            {{-- 3. Subject Name --}}
                            <td class="px-6 py-4 font-bold text-gray-900">
                                {{ $subject->name ?? $subject->subject_name ?? '-' }}
                            </td>

                            {{-- 4. Tombol EDIT & DELETE HANYA tampil untuk Admin --}}
                            @if(auth()->check() && auth()->user()->role === 'admin')
                                <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                    <a href="{{ route('subjects.edit', $subject->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-amber-600 bg-amber-50 rounded-lg border border-amber-200 hover:bg-amber-100 transition">
                                        ✏️ Edit
                                    </a>
                                    
                                    <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-rose-600 bg-rose-50 rounded-lg border border-rose-200 hover:bg-rose-100 transition" onclick="return confirm('Are you sure you want to delete this subject?')">
                                            🗑️ Delete
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->check() && auth()->user()->role === 'admin' ? 4 : 3 }}" class="px-6 py-8 text-center text-gray-400">
                                📂 No subjects available.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection