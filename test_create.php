<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$plainPassword = "MYPASS";
$email = "testcreate" . rand(10,99);
$user = \App\Models\User::create([
    'name' => 'Test',
    'email' => $email,
    'password' => \Illuminate\Support\Facades\Hash::make($plainPassword),
]);

$attempt = \Illuminate\Support\Facades\Auth::attempt(['email' => $email, 'password' => $plainPassword]);
echo "Attempt with Hash::make: " . ($attempt ? "SUCCESS" : "FAIL") . "\n";
echo "Hash in DB: " . $user->password . "\n";
