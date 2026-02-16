<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
foreach (User::all() as $user) {
    echo $user->id . " | " . $user->role . " | " . $user->email . "\n";
}
