<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat akun khusus Admin
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@smk-aisyiyah.com',
            'password' => bcrypt('password123'),
        ]);

        // Membuat akun khusus Guru
        User::factory()->create([
            'name' => 'Guru Pengawas',
            'email' => 'guru@smk-aisyiyah.com',
            'password' => bcrypt('password123'),
        ]);

        // Membuat akun khusus Siswa
        User::factory()->create([
            'name' => 'Siswa Teladan',
            'email' => 'siswa@smk-aisyiyah.com',
            'password' => bcrypt('password123'),
        ]);

        // Membuat akun khusus Kepala Sekolah
        User::factory()->create([
            'name' => 'Kepala Sekolah',
            'email' => 'kepsek@smk-aisyiyah.com',
            'password' => bcrypt('password123'),
        ]);

        // Membuat 10 user acak tambahan
        User::factory(10)->create();
    }
}
