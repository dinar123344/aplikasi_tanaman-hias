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

 $customer = \App\Models\Customer::updateOrCreate(
    ['user_id' => $user->id],
    [
        'name' => $user->name,
        'phone' => '081234567890',
        'address' => 'Jl Test',
    ]
);

echo $customer->phone . PHP_EOL;
