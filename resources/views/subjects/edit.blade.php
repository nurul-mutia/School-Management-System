@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6 max-w-4xl mx-auto">
    {{-- Header Section --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">✏️ Edit Subject</h1>
            <p class="text-sm text-gray-500">Update subject details for {{ $subject->name }} (Admin Only).</p>
        </div>
        <a href="{{ route('subjects.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium text-sm rounded-lg transition">
            ⬅️ Back to List
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('subjects.update', $subject->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

    {{-- Subject Code --}}
    <div>
        <label for="code" class="block text-sm font-semibold text-gray-700 mb-1">
           🏷️ Subject Code <span class="text-red-500">*</span>
        </label>
        <input type="text" name="code" id="code" value="{{ old('code', $subject->code) }}" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm @error('code') border-red-500 @enderror" required>
        @error('code')
           <p class="mt-1 text-xs text-red-600">⚠️ {{ $message }}</p>
        @enderror
    </div>

    {{-- Subject Name --}}
    <div>
        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">
           📖 Subject Name <span class="text-red-500">*</span>
        </label>
        <input type="text" name="name" id="name" value="{{ old('name', $subject->name) }}" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm @error('name') border-red-500 @enderror" required>
        @error('name')
           <p class="mt-1 text-xs text-red-600">⚠️ {{ $message }}</p>
        @enderror
        </div>
            {{-- Form Actions --}}
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                <a href="{{ route('subjects.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium text-sm rounded-lg transition">
                    ❌ Cancel
                </a>
                <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-lg shadow-sm transition">
                    🔄 Update Subject
                </button>
            </div>
        </form>
    </div>
</div>
@endsection