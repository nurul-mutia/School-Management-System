<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="flex flex-col space-y-2">

                <!-- Menu Umum -->
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link>

                <!-- Menu Khusus ADMIN -->
                @hasrole('admin')
                    <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                        {{ __('Data Pengguna') }}
                    </x-nav-link>

                    <x-nav-link :href="route('students.index')" :active="request()->routeIs('students.*')">
                        {{ __('Data Siswa') }}
                    </x-nav-link>

                    <x-nav-link :href="route('teachers.index')" :active="request()->routeIs('teachers.*')">
                        {{ __('Data Guru') }}
                    </x-nav-link>

                    <x-nav-link :href="route('classes.index')" :active="request()->routeIs('classes.*')">
                        {{ __('Data Kelas') }}
                    </x-nav-link>

                    <x-nav-link :href="route('subjects.index')" :active="request()->routeIs('subjects.*')">
                        {{ __('Mata Pelajaran') }}
                    </x-nav-link>
                @endhasrole

                <!-- Menu Khusus SISWA -->
                @hasrole('siswa')
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Jadwal Pelajaran') }}
                    </x-nav-link>
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Nilai Saya') }}
                    </x-nav-link>
                @endhasrole
            </div>
            <!-- Form Logout -->
            <form method="POST" action="{{ route('logout') }}" class="inline-flex items-center">
                @csrf
                <button type="submit" class="px-3 py-2 text-sm font-medium text-red-600 hover:text-red-800 transition">
                    🚪 Logout
                </button>
            </form>
        </div> <!-- Penutup div flex -->
    </div> <!-- Penutup div container max-w-7xl -->
</nav> <!-- Penutup tag nav utama -->