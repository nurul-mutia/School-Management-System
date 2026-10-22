@extends('layouts.app') {{-- Sesuaikan dengan nama file layout utama Anda, misal: layouts.admin atau layouts.app --}}

@section('content')
<div class="space-y-4">
    {{-- Letakkan di dalam @section('content') bagian paling atas --}}
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
                    <span class="text-sm font-medium text-indigo-600">Teacher Management</span>
                </div>
            </li>
        </ol>
    </nav>
    {{-- Header & Add Teacher Button --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">👨‍🏫🏫 Teachers Management</h2>
            <p class="text-sm text-gray-500">Manage teacher profiles, NIP, subject assignments, and status</p>
        </div>

        {{-- Tombol ADD HANYA tampil untuk Admin --}}
        @if(auth()->check() && auth()->user()->role === 'admin')
            <a href="{{ route('teachers.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition shadow-sm">
                ➕ Add Teacher
            </a>
        @endif
    </div>

    {{-- Teacher Data Table --}}
    <div class="overflow-x-auto bg-white rounded-xl shadow-sm border border-gray-100">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">NIP</th>
                    <th class="px-6 py-3">Teacher Name</th>
                    <th class="px-6 py-3">Subject</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Join Date</th>
                    
                    {{-- Header ACTIONS HANYA tampil untuk Admin --}}
                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <th class="px-6 py-3 text-right">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($teachers as $index => $teacher)
                    <tr class="hover:bg-gray-50/50 transition">
                        {{-- 1. Number --}}
                        <td class="px-6 py-4 text-gray-400 font-medium">
                            {{ $loop->iteration }}
                        </td>

                        {{-- 2. NIP --}}
                        <td class="px-6 py-4 font-mono text-xs text-gray-600">
                            {{ $teacher->nip ?? '-' }}
                        </td>

                        {{-- 3. Teacher Name & Email --}}
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-900">{{ $teacher->name ?? $teacher->user->name ?? '-' }}</div>
                            <div class="text-xs text-gray-400 flex items-center gap-1">
                                ✉️ {{ $teacher->email ?? $teacher->user->email ?? '-' }}
                            </div>
                        </td>

                        {{-- 4. Subject --}}
                        <td class="px-6 py-4">
                            @php
                                $subjectName = $teacher->subject->name ?? $teacher->subject_name ?? null;
                            @endphp

                            @if($subjectName)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold text-indigo-700 bg-indigo-50 rounded-full">
                                    📚 {{ $subjectName }}
                                </span>
                            @else
                                <span class="text-gray-400 font-medium">-</span>
                            @endif
                        </td>

                        {{-- 5. Status --}}
                        <td class="px-6 py-4">
                            @if(($teacher->status ?? 'active') === 'active')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold text-emerald-700 bg-emerald-50 rounded-full">
                                    🟢 Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold text-rose-700 bg-rose-50 rounded-full">
                                    🔴 Inactive
                                </span>
                            @endif
                        </td>

                        {{-- 6. Join Date --}}
                        <td class="px-6 py-4 text-gray-600">
                            {{ \Carbon\Carbon::parse($teacher->created_at)->format('d M Y') }}
                        </td>

                        {{-- 7. Tombol EDIT & DELETE HANYA tampil untuk Admin --}}
                        @if(auth()->check() && auth()->user()->role === 'admin')
                            <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('teachers.edit', $teacher->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-amber-600 bg-amber-50 rounded-lg border border-amber-200 hover:bg-amber-100 transition">
                                    ✏️ Edit
                                </a>
                                
                                <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-rose-600 bg-rose-50 rounded-lg border border-rose-200 hover:bg-rose-100 transition" onclick="return confirm('Are you sure you want to delete this teacher record?')">
                                        🗑️ Delete
                                    </button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->check() && auth()->user()->role === 'admin' ? 7 : 6 }}" class="px-6 py-8 text-center text-gray-400">
                            📂 No teacher data available.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection