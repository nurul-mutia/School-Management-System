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
                    <a href="{{ route('subjects.index') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600">
                        Subject Management
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <span class="mx-2 text-gray-400">/</span>
                    <span class="text-sm font-medium text-indigo-600">Add Subject</span>
                </div>
            </li>
        </ol>
    </nav>

    {{-- FORM HEADER --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                📚 Add New Subject
            </h1>
            <p class="text-xs text-gray-500">Fill in the details below to add a new subject</p>
        </div>
        <a href="{{ route('subjects.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-xs font-semibold hover:bg-gray-200 transition">
            ← Back to List
        </a>
    </div>

    {{-- FORM BODY --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <form action="{{ route('subjects.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- SUBJECT CODE FIELD (AUTOFOCUS DIPASANG DI SINI) --}}
                <div>
                    <label for="subject_code" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">SUBJECT CODE</label>
                    <input type="text" name="subject_code" id="subject_code" autofocus required value="{{ old('subject_code') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                           placeholder="e.g. MP-001">
                </div>

                {{-- SUBJECT NAME FIELD --}}
                <div>
                    <label for="subject_name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">SUBJECT NAME</label>
                    <input type="text" name="subject_name" id="subject_name" required value="{{ old('subject_name') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                           placeholder="e.g. Matematika">
                </div>
            </div>

            {{-- ACTION BUTTONS --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('subjects.index') }}" class="px-5 py-2.5 text-xs font-semibold text-gray-600 hover:text-gray-800 transition">
                    Cancel
                </a>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold transition shadow-sm">
                    💾 Save Subject Data
                </button>
            </div>
        </form>
    </div>

</div>
@endsection