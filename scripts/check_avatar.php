<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = \App\Models\User::first();
if (! $user) {
    echo "No users in database\n";
    exit(1);
}

$avatar = $user->avatar ?? '(null)';
$storagePath = __DIR__ . '/../storage/app/public/' . ($avatar ? $avatar : '');
$fileExists = $avatar && file_exists($storagePath) ? 'yes' : 'no';

echo "User ID: {$user->id}\n";
echo "Avatar field: {$avatar}\n";
echo "Storage path: {$storagePath}\n";
echo "File exists in storage/app/public: {$fileExists}\n";

// Check public/storage symlink
$publicPath = __DIR__ . '/../public/storage/' . ($avatar ? $avatar : '');
$linkExists = file_exists(__DIR__ . '/../public/storage') ? 'yes' : 'no';
$publicFileExists = $avatar && file_exists($publicPath) ? 'yes' : 'no';

echo "public/storage symlink exists: {$linkExists}\n";
echo "Accessible via public/storage: {$publicFileExists}\n";
