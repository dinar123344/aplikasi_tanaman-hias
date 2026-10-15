<?php

if (!function_exists('get_setting')) {
    function get_setting($key, $default = null) {
        $path = storage_path('app/settings.json');
        
        $defaults = [
            'store_name' => 'Toko Tanaman Hias Premium',
            'store_slogan' => 'Menghadirkan keindahan alam ke dalam ruangan Anda.',
            'store_whatsapp' => '081234567890',
            'store_email' => 'kontak@tokotanaman.com',
            'store_address' => 'Jl. Kebagusan Indah Raya No. 42, Kebayoran Baru, Jakarta Selatan, 12130',
            'default_shipping_fee' => 15000,
            'currency' => 'IDR'
        ];

        if (!file_exists($path)) {
            return $defaults[$key] ?? $default;
        }

        $settings = json_decode(file_get_contents($path), true);
        if (!is_array($settings)) {
            return $defaults[$key] ?? $default;
        }

        return array_key_exists($key, $settings) ? $settings[$key] : ($defaults[$key] ?? $default);
    }
}

if (!function_exists('update_settings')) {
    function update_settings(array $newSettings) {
        $path = storage_path('app/settings.json');
        
        $defaults = [
            'store_name' => 'Toko Tanaman Hias Premium',
            'store_slogan' => 'Menghadirkan keindahan alam ke dalam ruangan Anda.',
            'store_whatsapp' => '081234567890',
            'store_email' => 'kontak@tokotanaman.com',
            'store_address' => 'Jl. Kebagusan Indah Raya No. 42, Kebayoran Baru, Jakarta Selatan, 12130',
            'default_shipping_fee' => 15000,
            'currency' => 'IDR'
        ];

        $current = [];
        if (file_exists($path)) {
            $current = json_decode(file_get_contents($path), true);
            if (!is_array($current)) {
                $current = [];
            }
        }

        $settings = array_merge($defaults, $current, $newSettings);
        
        $dir = dirname($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        file_put_contents($path, json_encode($settings, JSON_PRETTY_PRINT));
        return $settings;
    }
}
