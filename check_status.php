<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$assessments = App\Models\Assessment::where('name', 'like', '%Lombok%')->get();
foreach($assessments as $a) {
    echo "Assessment: " . $a->id . ': ' . $a->name . ' [' . $a->status . '] ' . $a->progress . "%\n";
    foreach($a->items as $item) {
        echo "  - Item: " . $item->cobitItem->nama_item . " Progress: " . $item->progress_percentage . "%\n";
    }
}
