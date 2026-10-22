@extends('layouts.app')

@section('title', 'Edit Kelas')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header Kartu -->
    <div class="flex items-center gap-3 bg-white p-5 rounded-xl shadow-sm border border-gray-100">
        <span class="text-3xl">✏️️</span>
        <div>
            <h2 class="text-xl font-bold text-gray-800">Edit Data Kelas</h2>
            <p class="text-xs text-gray-500">Perbarui informasi data kelas yang dipilih</p>
        </div>
    </div>

    <!-- Form Edit Kelas -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('classes.update', $schoolClass->id ?? $class->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="class_name" class="block text-sm font-medium text-gray-700 mb-1">
                    Nama Kelas <span class="text-red-500">*</span>
                </label>
                <input type="text" name="class_name" id="class_name" value="{{ old('class_name', $schoolClass->class_name ?? $schoolClass->name ?? $class->class_name ?? $class->name ?? '') }}" required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition-colors @error('class_name') border-red-500 @enderror">
                
                @error('class_name')
                    <p class="mt-1 text-xs text-red-600 flex items-center gap-1">
                        <span>⚠️</span>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end items-center gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('classes.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center gap-2">
                    <span>💾</span>
                    <span>Perbarui Data Kelas</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection