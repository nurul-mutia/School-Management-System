@extends('layouts.app') {{-- Adapt to your master layout file name --}}

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 p-6">
        
        {{-- Header Section --}}
        <div class="flex items-center gap-3 pb-6 border-b border-gray-100 mb-6">
            <div class="p-3 bg-amber-50 text-amber-600 rounded-xl text-2xl">
                ✏️
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-800">Edit Teacher Profile</h3>
                <p class="text-sm text-gray-500">Update teacher information, academic assignment, and account status</p>
            </div>
        </div>

        {{-- Validation Error Alert --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-lg shadow-sm">
                <div class="flex items-center gap-2 text-rose-800 font-semibold text-sm mb-2">
                    <span>⚠️</span>
                    <span>Please fix the following errors:</span>
                </div>
                <ul class="list-disc list-inside text-xs text-rose-700 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Edit Teacher --}}
        <form action="{{ route('teachers.update', $teacher->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- 1. NIP (Employee Identification Number) --}}
                <div>
                    <label for="nip" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">
                        NIP (Employee ID Number)
                    </label>
                    <input type="text" 
                           name="nip" 
                           id="nip" 
                           value="{{ old('nip', $teacher->nip) }}" 
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-sm font-mono text-gray-800 transition-all placeholder-gray-400"
                           placeholder="e.g. 198501012010011001">
                    @error('nip')
                        <p class="text-rose-500 text-xs mt-1.5 flex items-center gap-1">
                            <span>❌</span> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- 2. Teacher Full Name --}}
                <div>
                    <label for="name" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">
                        Teacher Full Name <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $teacher->user->name ?? $teacher->name ?? '') }}" 
                           required 
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-sm font-medium text-gray-800 transition-all placeholder-gray-400"
                           placeholder="Enter teacher's full name with title">
                    @error('name')
                        <p class="text-rose-500 text-xs mt-1.5 flex items-center gap-1">
                            <span>❌</span> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- 3. Email Address (TAMBAHAN INPUT DITAMBAHKAN DI SINI) --}}
                <div>
                    <label for="email" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">
                        Email Address <span class="text-rose-500">*</span>
                    </label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           value="{{ old('email', $teacher->user->email ?? $teacher->email ?? '') }}" 
                           required 
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-sm text-gray-800 transition-all placeholder-gray-400"
                           placeholder="e.g. teacher@school.sch.id">
                    @error('email')
                        <p class="text-rose-500 text-xs mt-1.5 flex items-center gap-1">
                            <span>❌</span> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- 4. Subject Assignment --}}
                <div>
                    <label for="subject_id" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">
                        Subject Assignment
                    </label>
                    <select name="subject_id" 
                            id="subject_id" 
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-sm text-gray-800 transition-all bg-white">
                        <option value="">-- Select Subject --</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id', $teacher->subject_id) == $subject->id ? 'selected' : '' }}>
                                📚 {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <p class="text-rose-500 text-xs mt-1.5 flex items-center gap-1">
                            <span>❌</span> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- 5. Account Status --}}
                <div class="mb-4">
                    <label for="status" class="block text-xs font-bold text-gray-700 uppercase mb-2">Status Guru</label>
                    <select name="status" id="status" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500">
                        <option value="active" {{ old('status', $teacher->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $teacher->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            {{-- Form Action Buttons --}}
            <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                <a href="{{ route('teachers.index') }}" 
                   class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-gray-100 hover:bg-gray-200 active:bg-gray-300 text-gray-600 font-medium text-sm rounded-lg transition-all duration-150">
                    <span>🔙</span> Cancel
                </a>
                <button type="submit" 
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-medium text-sm rounded-lg shadow-sm transition-all duration-150 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <span>💾</span> Update Teacher
                </button>
            </div>
        </form>

    </div>
</div>
@endsection