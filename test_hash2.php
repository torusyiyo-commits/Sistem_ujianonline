<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = \App\Models\User::latest('id')->first();
if ($user) {
    echo "User: " . $user->email . "\n";
    $plainPassword = substr(str_shuffle("23456789ABCDEFGHJKLMNPQRSTUVWXYZ"), 0, 6);
    $user->password = \Illuminate\Support\Facades\Hash::make($plainPassword);
    $user->save();
    
    $attempt = \Illuminate\Support\Facades\Auth::attempt(['email' => $user->email, 'password' => $plainPassword]);
    echo "Attempt with Hash::make: " . ($attempt ? "SUCCESS" : "FAIL") . "\n";
    
    // Now try without Hash::make, let the cast handle it
    $plainPassword2 = "ABCDEF";
    $user->password = $plainPassword2;
    $user->save();
    
    $attempt2 = \Illuminate\Support\Facades\Auth::attempt(['email' => $user->email, 'password' => $plainPassword2]);
    echo "Attempt without Hash::make: " . ($attempt2 ? "SUCCESS" : "FAIL") . "\n";
} else {
    echo "No users found.";
}
