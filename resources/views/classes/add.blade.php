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
                    <a href="{{ route('classes.index') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600">
                        Class Management
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <span class="mx-2 text-gray-400">/</span>
                    <span class="text-sm font-medium text-indigo-600">Add Class</span>
                </div>
            </li>
        </ol>
    </nav>

    {{-- FORM HEADER --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                🏫 Add New Class
            </h1>
            <p class="text-xs text-gray-500">Fill in the details below to register a new class</p>
        </div>
        <a href="{{ route('classes.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-xs font-semibold hover:bg-gray-200 transition">
            ← Back to List
        </a>
    </div>

    {{-- FORM BODY --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <form action="{{ route('classes.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                {{-- CLASS NAME FIELD (AUTOFOCUS DIPASANG DI SINI) --}}
                <label for="class_name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">CLASS NAME</label>
                <input type="text" name="class_name" id="class_name" autofocus required value="{{ old('class_name') }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                       placeholder="e.g. 10 IPA 1">
            </div>

            {{-- ACTION BUTTONS --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('classes.index') }}" class="px-5 py-2.5 text-xs font-semibold text-gray-600 hover:text-gray-800 transition">
                    Cancel
                </a>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold transition shadow-sm">
                    💾 Save Class Data
                </button>
            </div>
        </form>
    </div>

</div>
@endsection