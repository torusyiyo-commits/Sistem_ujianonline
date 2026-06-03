<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$users = \App\Models\User::latest('id')->take(10)->get();
foreach($users as $u) {
    echo "ID: {$u->id} | Email: {$u->email} | Pass: {$u->password} \n";
}
