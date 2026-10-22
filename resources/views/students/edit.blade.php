@extends('layouts.app')

@section('content')
<div class="p-6 max-w-4xl mx-auto space-y-6">

    {{-- Form Header --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Edit Student Data ✏️</h1>
            <p class="text-xs text-gray-500">Update information for student {{ $student->name ?? $student->nama }}</p>
        </div>
        <a href="{{ route('students.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-xs font-semibold transition">
            ⬅️ Back to List
        </a>
    </div>

    {{-- Form Body --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <form action="{{ route('students.update', $student->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- NISN Field --}}
                <div>
                    <label for="nisn" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">NISN</label>
                    <input type="text" name="nisn" id="nisn" value="{{ old('nisn', $student->nisn) }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" required>
                    @error('nisn') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Student Name Field --}}
                <div>
                    <label for="name" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Student Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $student->name ?? $student->nama) }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" required>
                    @error('name') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Class Selection --}}
                <div>
                    <label for="class_id" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Class Assignment</label>
                    <select name="class_id" id="class_id" class="w-full px-4 py-2.5 border rounded-lg">
                        <option value="">-- Select Class --</option>
                        @if(isset($classes))
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" 
                                    {{ (old('class_id', $student->class_id) == $class->id) ? 'selected' : '' }}>
                                    {{ $class->class_name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('class_id') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Status Selection --}}
                <div>
                    <label for="status" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Student Status</label>
                    <select name="status" id="status" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" required>
                        <option value="active" {{ old('status', $student->status ?? 'active') === 'active' ? 'selected' : '' }}>🟢 Active</option>
                        <option value="move" {{ old('status', $student->status) === 'move' ? 'selected' : '' }}>🔴 Move</option>
                    </select>
                    @error('status') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Submit Buttons --}}
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                <a href="{{ route('students.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-xs font-semibold transition">
                    Cancel
                </a>
                <button type="submit" class="px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-semibold transition shadow-sm">
                    🔄 Update Student Data
                </button>
            </div>
        </form>
    </div>

</div>
@endsection