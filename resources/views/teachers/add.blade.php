@extends('layouts.app')

@section('content')
<div class="p-6 max-w-4xl mx-auto space-y-6">

    {{-- BREADCRUMBS NAVIGATION --}}
    <nav class="flex px-5 py-3 text-gray-700 border border-gray-100 rounded-xl bg-white shadow-sm" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600">
                    🏠 Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <span class="mx-2 text-gray-400">/</span>
                    <a href="{{ route('teachers.index') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600">
                        Teacher Management
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <span class="mx-2 text-gray-400">/</span>
                    <span class="text-sm font-medium text-indigo-600">Add Teacher</span>
                </div>
            </li>
        </ol>
    </nav>

    {{-- FORM HEADER --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                👩‍🏫 Add New Teacher
            </h1>
            <p class="text-xs text-gray-500">Fill in the details below to register a new teacher</p>
        </div>
        <a href="{{ route('teachers.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-xs font-semibold hover:bg-gray-200 transition">
            ← Back to List
        </a>
    </div>

    {{-- ERROR ALERT --}}
    @if ($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-sm">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM BODY --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <form action="{{ route('teachers.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- NIP FIELD (AUTOFOCUS DIPASANG DI SINI) --}}
                <div>
                    <label for="nip" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">NIP</label>
                    <input type="text" name="nip" id="nip" autofocus required value="{{ old('nip') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                           placeholder="Masukkan NIP guru...">
                </div>

                {{-- TEACHER NAME FIELD --}}
                <div>
                    <label for="name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">TEACHER NAME</label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                           placeholder="e.g. Ahmad Fauzi, S.Pd">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- SUBJECT ASSIGNMENT FIELD --}}
                <div>
                    <label for="subject_id" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">SUBJECT ASSIGNMENT</label>
                    <select name="subject_id" id="subject_id" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        <option value="">-- Select Subject --</option>
                        @foreach($subjects ?? [] as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->subject_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- TEACHER STATUS FIELD --}}
                <div>
                    <label for="status" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">TEACHER STATUS</label>
                    <select name="status" id="status" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>🟢 Active</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>🔴 Inactive</option>
                    </select>
                </div>
            </div>

            {{-- ACTION BUTTONS --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('teachers.index') }}" class="px-5 py-2.5 text-xs font-semibold text-gray-600 hover:text-gray-800 transition">
                    Cancel
                </a>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold transition shadow-sm">
                    💾 Save Teacher Data
                </button>
            </div>
        </form>
    </div>

</div>
@endsection