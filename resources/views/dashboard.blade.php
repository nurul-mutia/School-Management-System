@extends('layouts.app') {{-- Ganti dengan nama layout Anda, misal: layouts.admin / layouts.main --}}

@section('content')
<div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

    {{-- 1. STATISTIC CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        
        {{-- Card 1: Users --}}
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm border-l-4 border-l-indigo-500 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">USERS (PENGGUNA)</p>
                <h3 class="text-2xl font-extrabold text-gray-900 mt-1">{{ number_format($totalUsers ?? 0) }}</h3>
            </div>
            <div class="w-12 h-12 bg-indigo-50 rounded-full flex items-center justify-center text-indigo-600 text-xl">
                👥
            </div>
        </div>

        {{-- Card 2: Students --}}
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm border-l-4 border-l-blue-500 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">STUDENTS (SISWA)</p>
                <h3 class="text-2xl font-extrabold text-gray-900 mt-1">{{ number_format($totalStudents ?? 0) }}</h3>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 text-xl">
                🎓
            </div>
        </div>

        {{-- Card 3: Teachers --}}
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm border-l-4 border-l-emerald-500 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">TEACHERS (GURU)</p>
                <h3 class="text-2xl font-extrabold text-gray-900 mt-1">{{ number_format($totalTeachers ?? 0) }}</h3>
            </div>
            <div class="w-12 h-12 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-600 text-xl">
                👨‍🏫
            </div>
        </div>

        {{-- Card 4: Classes --}}
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm border-l-4 border-l-amber-500 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">CLASSES (KELAS)</p>
                <h3 class="text-2xl font-extrabold text-gray-900 mt-1">{{ number_format($totalClasses ?? 0) }}</h3>
            </div>
            <div class="w-12 h-12 bg-amber-50 rounded-full flex items-center justify-center text-amber-600 text-xl">
                🏫
            </div>
        </div>

        {{-- Card 5: Subjects --}}
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm border-l-4 border-l-rose-500 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">SUBJECTS (MAPEL)</p>
                <h3 class="text-2xl font-extrabold text-gray-900 mt-1">{{ number_format($totalSubjects ?? 0) }}</h3>
            </div>
            <div class="w-12 h-12 bg-rose-50 rounded-full flex items-center justify-center text-rose-600 text-xl">
                📖
            </div>
        </div>

    </div>

    {{-- 2. LATEST STUDENT DATA TABLE --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-800">🎓 Latest Student Data</h3>
                <p class="text-xs text-gray-500">Recent student registrations and class assignments</p>
            </div>
            <a href="{{ route('students.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition">
                See All →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-xs text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-3">ID / NISN</th>
                        <th class="px-6 py-3">STUDENT NAME</th>
                        <th class="px-6 py-3">CLASS</th>
                        <th class="px-6 py-3">STATUS</th>
                        <th class="px-6 py-3">JOIN DATE</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($latestStudents ?? [] as $student)
                        <tr class="hover:bg-gray-50/50 transition">
                            {{-- 1. NISN --}}
                            <td class="px-6 py-4 font-mono text-xs text-gray-500">
                                {{ $student->nisn ?? 'STD-'.str_pad($student->id, 3, '0', STR_PAD_LEFT) }}
                            </td>

                            {{-- 2. Student Name --}}
                            <td class="px-6 py-4 font-semibold text-gray-900">
                                {{ $student->name ?? $student->nama ?? ($student->user->name ?? '-') }}
                            </td>

                            {{-- 3. Class (Eager Loading schoolClass -> class_name) --}}
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

                            {{-- 4. Status --}}
                            <td class="px-6 py-4">
                                @if(($student->status ?? 'active') === 'active')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold text-emerald-700 bg-emerald-50 rounded-full">
                                        🟢 Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold text-rose-700 bg-rose-50 rounded-full">
                                        🔴 Inactive
                                    </span>
                                @endif
                            </td>

                            {{-- 5. Join Date --}}
                            <td class="px-6 py-4 text-gray-500">
                                {{ \Carbon\Carbon::parse($student->created_at)->format('d M Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                📂 No student records available.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection