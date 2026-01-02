<?php

/**
 * Quick script to manually activate subscription for a user
 * Run with: php activate_subscription.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Package;

echo "=== Manual Subscription Activation ===\n\n";

// Get user email
echo "Enter user email: ";
$email = trim(fgets(STDIN));

$user = User::where('email', $email)->first();

if (!$user) {
    echo "❌ User not found with email: $email\n";
    exit(1);
}

echo "✓ Found user: {$user->name} (ID: {$user->id})\n\n";

// Show available packages
$packages = Package::all();
echo "Available packages:\n";
foreach ($packages as $package) {
    echo "  [{$package->id}] {$package->name} - Rp " . number_format($package->price, 0, ',', '.') . " ({$package->duration_days} days)\n";
}

echo "\nEnter package ID: ";
$packageId = trim(fgets(STDIN));

$package = Package::find($packageId);

if (!$package) {
    echo "❌ Package not found with ID: $packageId\n";
    exit(1);
}

echo "✓ Selected package: {$package->name}\n\n";

// Activate subscription
$user->subscription_status = 'active';
$user->subscription_start = now();
$user->subscription_end = now()->addDays($package->duration_days);
$user->save();

echo "✅ Subscription activated successfully!\n";
echo "   Status: {$user->subscription_status}\n";
echo "   Start: {$user->subscription_start}\n";
echo "   End: {$user->subscription_end}\n";
echo "\nUser can now access the Audit system.\n";
