<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\CobitItem;
foreach (CobitItem::all() as $item) {
    echo $item->id . " | " . $item->nama_item . "\n";
}
