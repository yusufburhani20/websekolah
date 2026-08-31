<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$t = App\Models\Teacher::where('nama', 'like', '%Yusuf%')->first();
echo "Foto DB: " . $t->foto . "\n";
echo "Storage path: " . storage_path('app/public/' . $t->foto) . "\n";
echo "File exists: " . (file_exists(storage_path('app/public/' . $t->foto)) ? 'YES' : 'NO') . "\n";
echo "URL: " . $t->foto_url . "\n";
