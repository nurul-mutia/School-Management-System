@extends('layouts.app')

@section('title', 'Data Kelas')

@section('content')
<div class="space-y-6">
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
                    <span class="text-sm font-medium text-indigo-600">Class Management</span>
                </div>
            </li>
        </ol>
    </nav>
    <!-- Header Card -->
    <div class="flex justify-between items-center bg-white p-5 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center gap-3">
            <span class="text-3xl">🏫</span>
            <div>
                <h2 class="text-xl font-bold text-gray-800">Manajemen Classes (Kelas)</h2>
                <p class="text-xs text-gray-500">Manage class lists and number of enrolled students</p>
            </div>
        </div>

        @if(Auth::user()->role === 'admin')
            <a href="{{ route('classes.create') }}" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors font-medium text-sm flex items-center gap-2 shadow-sm">
                <span>+</span>
                <span>Add Class</span>
            </a>
        @endif
    </div>

    <!-- Alert Notifikasi Sukses -->
    @if(session('success'))
        <div class="p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg flex items-center gap-2 text-sm shadow-sm">
            <span>✅</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Alert Notifikasi Error -->
    @if(session('error'))
        <div class="p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg flex items-center gap-2 text-sm shadow-sm">
            <span>⚠️</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Tabel Data Kelas -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b bg-gray-50 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <th class="py-3.5 px-4">#</th>
                        <th class="py-3.5 px-4">STUDENT NAME</th>
                        <th class="py-3.5 px-4">NUMBER OF STUDENTS</th>
                        @if(Auth::user()->role === 'admin')
                            <th class="py-3.5 px-4 text-center">ACTION</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($classes as $index => $class)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-3.5 px-4 text-gray-500">{{ $index + 1 }}</td>
                            <td class="py-3.5 px-4 font-semibold text-gray-800">
                                {{ $class->class_name ?? $class->name ?? '-' }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 bg-indigo-50 text-indigo-700 rounded-md text-xs font-medium border border-indigo-100">
                                    👨‍🎓 {{ $class->students_count ?? $class->students->count() ?? 0 }} Siswa
                                </span>
                            </td>

                            <!-- Tombol Edit & Hapus (Khusus Admin) -->
                            @if(Auth::user()->role === 'admin')
                                <td class="py-3.5 px-4">
                                    <div class="flex justify-center items-center gap-2">
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('classes.edit', $class->id) }}" class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 rounded-lg text-xs font-medium transition-colors flex items-center gap-1">
                                            <span>✏️</span>
                                            <span>Edit</span>
                                        </a>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('classes.destroy', $class->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-700 border border-red-200 rounded-lg text-xs font-medium transition-colors flex items-center gap-1">
                                                <span>🗑️</span>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ Auth::user()->role === 'admin' ? 4 : 3 }}" class="py-8 text-center text-gray-400">
                                <div class="flex flex-col items-center gap-2">
                                    <span class="text-3xl">📭</span>
                                    <span>Belum ada data kelas.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection