<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;

$map = [
    1 => 'products/monstera_deliciosa.png',
    2 => 'products/aglonema_red_ruby.png',
    3 => 'products/anggrek_bulan_putih.png',
    4 => 'products/kaktus_mini.png',
    5 => 'products/string_of_pearls.png',
    6 => 'products/sansevieria.png',
    7 => 'products/pot_terakota.svg',
    8 => 'products/pupuk_organik.svg'
];

foreach ($map as $id => $img) {
    Product::where('id', $id)->update(['image' => $img]);
    echo "Updated product $id to $img\n";
}
