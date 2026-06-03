<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$guru = App\Models\User::firstOrCreate(
    ['email' => 'guru@smk-aisyiyah.com'],
    ['name' => 'Guru Pengawas', 'password' => Illuminate\Support\Facades\Hash::make('password123')]
);
if (!$guru->hasRole('guru')) {
    $guru->assignRole('guru');
}

$siswa = App\Models\User::firstOrCreate(
    ['email' => 'siswa@smk-aisyiyah.com'],
    ['name' => 'Siswa Teladan', 'password' => Illuminate\Support\Facades\Hash::make('password123')]
);
if (!$siswa->hasRole('siswa')) {
    $siswa->assignRole('siswa');
}

echo "Default users restored.\n";
