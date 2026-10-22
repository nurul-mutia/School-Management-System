<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'School Management System')</title>

    <!-- FontAwesome Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="flex min-h-screen">
        <!-- SIDEBAR KIRI -->
        <aside class="w-60 bg-[#252a37] text-white flex flex-col shrink-0 min-h-screen justify-between">
            <div>
                <!-- Brand / Logo -->
                <div class="p-5 font-bold text-lg tracking-wider border-b border-slate-700 flex items-center gap-2">
                    <i class="fa-solid fa-graduation-cap text-blue-400 text-xl"></i>
                    <span>School System</span>
                </div>

                <!-- Navigation Links -->
                <nav class="mt-4 space-y-1">
                    <!-- Dashboard (Active State) -->
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-4 px-5 py-3 bg-[#32394a] text-blue-400 font-medium border-l-4 border-blue-500 transition">
                        <i class="fa-solid fa-gauge-high text-lg"></i>
                        <span>Dashboard</span>
                    </a>

                    <!-- Data Pengguna -->
                    <a href="{{ route('users.index') }}" class="flex items-center gap-4 px-5 py-3...">
                        <i class="fa-solid fa-users text-lg"></i>
                        <span>Users</span>
                    </a>

                    <!-- Data Siswa -->
                    <a href="{{ route('students.index') }}" class="flex items-center gap-4 px-5 py-3 hover:bg-gray-700 rounded-lg transition-colors">
                        <i class="fa-solid fa-user-graduate text-lg"></i>
                        <span>Students</span>
                    </a>

                    <!-- Data Guru -->
                    <a href="{{ route('teachers.index') }}" class="flex items-center gap-4 px-5 py-3 hover:bg-gray-700 rounded-lg transition-colors">
                        <i class="fa-solid fa-chalkboard-user text-lg"></i>
                        <span>Teachers</span>
                    </a>

                    <!-- Data Kelas -->
                    <a href="{{ route('classes.index') }}" class="flex items-center gap-4 px-5 py-3 hover:bg-gray-700 rounded-lg transition-colors">
                        <i class="fa-solid fa-school text-lg"></i>
                        <span>Classes</span>
                    </a>

                    <!-- Mata Pelajaran -->
                    <a href="{{ route('subjects.index') }}" class="flex items-center gap-4 px-5 py-3 hover:bg-gray-700 rounded-lg transition-colors">
                        <i class="fa-solid fa-book-open text-lg"></i>
                        <span>Subjects</span>
                    </a>
                </nav>
            </div>

            <!-- Tombol Logout -->
            <div class="p-4 border-t border-slate-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 bg-red-600/20 text-red-400 hover:bg-red-600 hover:text-white rounded-lg text-sm font-medium transition">
                        <i class="fa-solid fa-right-from-bracket text-lg"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- KONTEN UTAMA (KANAN) -->
        <main class="flex-1 p-8 overflow-y-auto">
            @yield('content')
        </main>
    </div>

</body>
</html>