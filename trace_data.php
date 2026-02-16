$a = App\Models\Assessment::with('cobitItems')->find(4);
$s = new App\Services\UserProgressService();
$d = $s->getProgressData($a->user, $a->id);
$ids = $a->cobitItems->pluck('id')->toArray();
$filtered = $d->filter(function($item) use ($ids) {
    return in_array($item['id'], $ids);
});
echo "Total Cobit Items in Assessment: " . count($ids) . "\n";
echo "Total Items in Progress Data: " . $d->count() . "\n";
echo "Total Filtered Items: " . $filtered->count() . "\n";
foreach ($filtered as $f) {
    echo "- " . $f['nama_item'] . " (ID: " . $f['id'] . ")\n";
}
