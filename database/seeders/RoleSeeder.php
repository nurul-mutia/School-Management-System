<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $guruRole = Role::create(['name' => 'guru']);
        $siswaRole = Role::create(['name' => 'siswa']);

        // User Admin Default
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@school.com',
            'password' => bcrypt('password123'),
        ]);
        
        $admin->assignRole($adminRole);
    }
}