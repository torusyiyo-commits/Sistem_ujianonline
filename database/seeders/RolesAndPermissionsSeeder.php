<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat role dasar
        $roleAdmin = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);
        $roleKepsek = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'kepala_sekolah']);
        $roleGuru = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'guru']);
        $roleSiswa = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'siswa']);

        // Dapatkan semua user dan mapping ke rolenya berdasarkan email atau kondisi
        $users = \App\Models\User::all();
        foreach ($users as $user) {
            if ($user->email === 'admin@smk-aisyiyah.com') {
                $user->assignRole($roleAdmin);
            } elseif ($user->email === 'kepsek@smk-aisyiyah.com') {
                $user->assignRole($roleKepsek);
            } elseif ($user->email === 'guru@smk-aisyiyah.com') {
                $user->assignRole($roleGuru);
            } elseif ($user->email === 'siswa@smk-aisyiyah.com') {
                $user->assignRole($roleSiswa);
            } else {
                // Default fallback jika ada user lain (bisa disesuaikan)
                $user->assignRole($roleSiswa);
            }
        }
    }
}
