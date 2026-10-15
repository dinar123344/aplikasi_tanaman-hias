<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@tanaman.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $customerUser = User::firstOrCreate(
            ['email' => 'customer@tanaman.com'],
            [
                'name' => 'Customer Demo',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]
        );

        $customerUser->customer()->firstOrCreate(
            ['user_id' => $customerUser->id],
            [
                'name' => 'Customer Demo',
                'phone' => '081234567890',
                'address' => 'Jl. Contoh No. 1, Jakarta',
            ]
        );

        $categories = [
            ['name' => 'Tanaman Hias Daun', 'description' => 'Tanaman dengan keindahan pada daunnya seperti Monstera, Aglonema, dll.'],
            ['name' => 'Tanaman Hias Bunga', 'description' => 'Tanaman dengan bunga indah seperti Mawar, Anggrek, Melati, dll.'],
            ['name' => 'Kaktus & Sukulen', 'description' => 'Tanaman kaktus dan sukulen yang mudah dirawat.'],
            ['name' => 'Tanaman Gantung', 'description' => 'Tanaman yang cocok digantung seperti String of Pearls, Pothos, dll.'],
            ['name' => 'Tanaman Indoor', 'description' => 'Tanaman yang cocok untuk di dalam ruangan.'],
            ['name' => 'Perlengkapan Tanaman', 'description' => 'Pot, pupuk, media tanam, dan perlengkapan lainnya.'],
            ['name' => 'Tanaman Outdoor', 'description' => 'Tanaman yang cocok untuk taman, halaman, teras, dan area luar ruangan.'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category['name']], $category);
        }

        // Buat dummy products
        $dummyProducts = [
            [
                'category_id' => 1,
                'name' => 'Monstera Deliciosa',
                'description' => 'Tanaman hias populer dengan daun lebar berlubang yang sangat estetik untuk ruangan minimalis.',
                'price' => 150000,
                'stock' => 15,
                'image' => 'https://images.unsplash.com/photo-1586201375761-83865001e52c?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 1,
                'name' => 'Aglonema Red Ruby',
                'description' => 'Tanaman dengan corak daun merah merona yang cantik. Mudah perawatannya dan tahan lama.',
                'price' => 85000,
                'stock' => 20,
                'image' => 'https://images.unsplash.com/photo-1591871931604-3b2f6b07e241?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 2,
                'name' => 'Anggrek Bulan Putih',
                'description' => 'Bunga anggrek premium berwarna putih elegan. Cocok untuk hadiah atau dekorasi ruang tamu.',
                'price' => 250000,
                'stock' => 5,
                'image' => 'https://images.unsplash.com/photo-1529070538774-1843cb3265df?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 3,
                'name' => 'Kaktus Mini Koboi',
                'description' => 'Kaktus indoor lucu yang tidak membutuhkan banyak air. Sangat cocok diletakkan di meja kerja.',
                'price' => 35000,
                'stock' => 50,
                'image' => 'https://images.unsplash.com/photo-1518552782678-5c9f91cf9d1f?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 4,
                'name' => 'String of Pearls',
                'description' => 'Tanaman gantung berbentuk seperti untaian mutiara hijau. Menambah kesan fresh pada teras.',
                'price' => 60000,
                'stock' => 10,
                'image' => 'https://images.unsplash.com/photo-1587300003388-59208cc962cb?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 5,
                'name' => 'Sansevieria (Lidah Mertua)',
                'description' => 'Tanaman pembersih udara alami yang tangguh dan bisa hidup dengan pencahayaan minim.',
                'price' => 45000,
                'stock' => 30,
                'image' => 'https://images.unsplash.com/photo-1493810329803-51b1a0e129a1?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 6,
                'name' => 'Pot Terakota Estetik',
                'description' => 'Pot tanah liat berdesain minimalis ukuran diameter 15cm. Ada lubang drainase.',
                'price' => 25000,
                'stock' => 100,
                'image' => 'https://images.unsplash.com/photo-1515353476870-51c9d83b7b72?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 6,
                'name' => 'Pupuk Organik Cair 500ml',
                'description' => 'Nutrisi lengkap untuk mempercepat pertumbuhan daun dan bunga pada tanaman hias kesayangan.',
                'price' => 40000,
                'stock' => 45,
                'image' => 'https://images.unsplash.com/photo-1545239795-8c7c8f4b70af?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 1,
                'name' => 'Philodendron Birkin',
                'description' => 'Daun putih pada Philodendron ini membuat sudut ruangan terlihat mewah dan elegan.',
                'price' => 120000,
                'stock' => 22,
                'image' => 'https://images.unsplash.com/photo-1523828262278-1b6924c4b4f6?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 1,
                'name' => 'Calathea Orbifolia',
                'description' => 'Daun bundar besar dengan pola garis yang menawan, cocok untuk interior bergaya alami.',
                'price' => 180000,
                'stock' => 12,
                'image' => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 2,
                'name' => 'Mawar Mini Pink',
                'description' => 'Setangkai mawar mini berwarna pink cerah, cocok sebagai hadiah atau dekorasi meja.',
                'price' => 90000,
                'stock' => 18,
                'image' => 'https://images.unsplash.com/photo-1499428665502-503f6fe6ef59?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 2,
                'name' => 'Lili Casablanca',
                'description' => 'Bunga putih besar dengan aroma harum lembut untuk mempercantik ruang tamu.',
                'price' => 220000,
                'stock' => 8,
                'image' => 'https://images.unsplash.com/photo-1465391444155-65b55b0b50a8?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 3,
                'name' => 'Sukulen Echeveria',
                'description' => 'Sukulen berdaun tebal yang mudah dirawat dan tampil cantik di rak atau meja kerja.',
                'price' => 30000,
                'stock' => 40,
                'image' => 'https://images.unsplash.com/photo-1511895426328-dc8714191300?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 3,
                'name' => 'Kaktus Bintang',
                'description' => 'Kaktus kecil dengan bentuk unik seperti bintang, sangat cocok untuk koleksi pemula.',
                'price' => 45000,
                'stock' => 35,
                'image' => 'https://images.unsplash.com/photo-1532548966447-0f579a4a2f0c?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 4,
                'name' => 'Pothos Marble Queen',
                'description' => 'Tanaman gantung dengan daun putih bercorak hijau yang indah dan mudah dirawat.',
                'price' => 75000,
                'stock' => 20,
                'image' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 4,
                'name' => 'Hoya Rope',
                'description' => 'Tanaman gantung dengan daun kecil dan rantai panjang, ideal untuk pot gantung dekoratif.',
                'price' => 85000,
                'stock' => 14,
                'image' => 'https://images.unsplash.com/photo-1494492516451-44e1f6aa58d9?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 5,
                'name' => 'Zamioculcas Zamiifolia',
                'description' => 'Tanaman indoor tahan naungan yang populer karena daya hidupnya tinggi dan perawatannya mudah.',
                'price' => 95000,
                'stock' => 25,
                'image' => 'https://images.unsplash.com/photo-1486748714218-9f27e6f34f8f?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 5,
                'name' => 'Peace Lily',
                'description' => 'Tanaman indoor dengan bunga putih yang elegan, menyegarkan ruangan sekaligus membersihkan udara.',
                'price' => 85000,
                'stock' => 16,
                'image' => 'https://images.unsplash.com/photo-1518365651910-40becd611c4b?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 6,
                'name' => 'Sekop Tanam Mini',
                'description' => 'Sekop kecil untuk memindahkan media tanam dan merawat tanaman indoor dengan mudah.',
                'price' => 15000,
                'stock' => 80,
                'image' => 'https://images.unsplash.com/photo-1492674040365-1a06e469cfae?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 6,
                'name' => 'Sprayer Air Halus',
                'description' => 'Semprotan halus untuk menyemprot daun tanaman dan menjaga kelembaban tanpa merusak daun.',
                'price' => 30000,
                'stock' => 60,
                'image' => 'https://images.unsplash.com/photo-1470770841072-f978cf4d019e?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 1,
                'name' => 'Ficus Lyrata (Fiddle Leaf)',
                'description' => 'Tanaman berdaun besar yang cocok untuk dekorasi sudut ruang tamu.',
                'price' => 250000,
                'stock' => 10,
                'image' => 'https://images.unsplash.com/photo-1501004318647-8e0a6b0b5b9a?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 1,
                'name' => 'Rubber Plant (Ficus Elastica)',
                'description' => 'Daun tebal dan mengkilap, tanaman indoor yang tahan lama.',
                'price' => 175000,
                'stock' => 12,
                'image' => 'https://images.unsplash.com/photo-1523413651479-597eb2da0ad6?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 5,
                'name' => 'Dracaena Marginata',
                'description' => 'Tanaman tinggi ramping untuk sudut ruangan atau kantor.',
                'price' => 90000,
                'stock' => 18,
                'image' => 'https://images.unsplash.com/photo-1501004318642-6b8f4e9b65f5?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 5,
                'name' => 'Bird of Paradise',
                'description' => 'Tanaman besar dengan daun tropis, memberi nuansa eksotis pada ruangan.',
                'price' => 320000,
                'stock' => 6,
                'image' => 'https://images.unsplash.com/photo-1501004318643-5f9b2d3c3f1a?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 3,
                'name' => 'Jade Plant (Crassula Ovata)',
                'description' => 'Sukulen klasik yang mudah dirawat dan cocok untuk meja.',
                'price' => 40000,
                'stock' => 30,
                'image' => 'https://images.unsplash.com/photo-1524594154901-1b1f2bf9053d?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 4,
                'name' => 'String of Hearts',
                'description' => 'Tanaman gantung kecil dengan daun berbentuk hati.',
                'price' => 65000,
                'stock' => 14,
                'image' => 'https://images.unsplash.com/photo-1501004318644-3b2f6b07e241?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 2,
                'name' => 'Anthurium Merah',
                'description' => 'Bunga berwarna merah cerah yang tahan lama, cocok untuk hiasan meja.',
                'price' => 140000,
                'stock' => 9,
                'image' => 'https://images.unsplash.com/photo-1501004318645-1c7d2e7bb2c3?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 2,
                'name' => 'Begonia Maculata',
                'description' => 'Begonia dengan motif bintik putih yang unik pada daun.',
                'price' => 160000,
                'stock' => 11,
                'image' => 'https://images.unsplash.com/photo-1501004318646-6b39e6451bec6?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 1,
                'name' => 'Alocasia Polly',
                'description' => 'Daun berwarna gelap dengan urat kontras, sangat atraktif.',
                'price' => 130000,
                'stock' => 13,
                'image' => 'https://images.unsplash.com/photo-1501004318648-9f27e6f34f8f?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 3,
                'name' => 'Euphorbia Tirucalli (Pencil Cactus)',
                'description' => 'Kaktus silindris unik, mudah dirawat untuk koleksi sukulen.',
                'price' => 55000,
                'stock' => 22,
                'image' => 'https://images.unsplash.com/photo-1501004318650-8c7c8f4b70af?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 4,
                'name' => 'Hanging Basket Mix',
                'description' => 'Campuran tanaman gantung kecil, siap pakai untuk dekor teras.',
                'price' => 98000,
                'stock' => 20,
                'image' => 'https://images.unsplash.com/photo-1501004318651-51c9d83b7b72?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 5,
                'name' => 'ZZ Plant Petite',
                'description' => 'Varian kecil Zamioculcas untuk rak dan meja kerja.',
                'price' => 85000,
                'stock' => 17,
                'image' => 'https://images.unsplash.com/photo-1501004318652-3cd6a7d3f89f?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 2,
                'name' => 'Orchid Mini Mix',
                'description' => 'Paket anggrek mini warna-warni, cantik sebagai hadiah.',
                'price' => 195000,
                'stock' => 7,
                'image' => 'https://images.unsplash.com/photo-1501004318653-dc8714191300?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 6,
                'name' => 'Soil Mix Premium 5L',
                'description' => 'Media tanam khusus untuk tanaman hias, kaya nutrisi dan drainase baik.',
                'price' => 65000,
                'stock' => 40,
                'image' => 'https://images.unsplash.com/photo-1501004318654-b39e6451bec6?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 6,
                'name' => 'Nutrient Tablet 20pcs',
                'description' => 'Tablet nutrisi untuk suplemen tanaman dalam pot kecil.',
                'price' => 30000,
                'stock' => 120,
                'image' => 'https://images.unsplash.com/photo-1501004318655-503f6fe6ef59?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 1,
                'name' => 'Monstera Thai Constellation',
                'description' => 'Varietas Monstera dengan bintik putih unik pada daun.',
                'price' => 420000,
                'stock' => 4,
                'image' => 'https://images.unsplash.com/photo-1501004318656-51b1a0e129a1?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 7,
                'name' => 'Bougenville Merah',
                'description' => 'Tanaman outdoor berbunga cerah yang sangat cocok untuk taman dan pagar.',
                'price' => 95000,
                'stock' => 18,
                'image' => 'https://images.unsplash.com/photo-1501004318641-f39f2d7f8f0f?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 7,
                'name' => 'Adenium Desert Rose',
                'description' => 'Tanaman outdoor unik dengan bunga cantik dan batang tebal yang kuat.',
                'price' => 110000,
                'stock' => 14,
                'image' => 'https://images.unsplash.com/photo-1487077705737-d5f0f0e2d6d7?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 7,
                'name' => 'Palm Queen',
                'description' => 'Tanaman outdoor tropis dengan daun rindang untuk halaman dan area teras.',
                'price' => 180000,
                'stock' => 9,
                'image' => 'https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 7,
                'name' => 'Melati Gambir',
                'description' => 'Tanaman outdoor harum yang cocok ditanam di pot atau pagar.',
                'price' => 70000,
                'stock' => 22,
                'image' => 'https://images.unsplash.com/photo-1501004318642-b1b56f4c0b5d?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 7,
                'name' => 'Lavender',
                'description' => 'Tanaman outdoor wangi yang ideal untuk taman mini dan area dekoratif.',
                'price' => 60000,
                'stock' => 20,
                'image' => 'https://images.unsplash.com/photo-1501004318643-f1e1d52d5f6c?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 7,
                'name' => 'Hibiscus Rosa-Sinensis',
                'description' => 'Tanaman outdoor berbunga besar dengan warna mencolok dan tahan panas.',
                'price' => 125000,
                'stock' => 12,
                'image' => 'https://images.unsplash.com/photo-1501004318644-1f1f1d6d6e1e?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 7,
                'name' => 'Jasmine Jepang',
                'description' => 'Tanaman outdoor merambat yang harum dan cocok untuk pagar atau dinding.',
                'price' => 80000,
                'stock' => 16,
                'image' => 'https://images.unsplash.com/photo-1501004318645-6d3f0d3a2f2f?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 7,
                'name' => 'Bungur',
                'description' => 'Tanaman outdoor pohon kecil yang cantik untuk pembatas taman dan halaman.',
                'price' => 220000,
                'stock' => 7,
                'image' => 'https://images.unsplash.com/photo-1501004318646-4b4c4d4d4a4a?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 7,
                'name' => 'Portulaca',
                'description' => 'Tanaman outdoor tahan panas yang cocok dipakai sebagai penutup tanah.',
                'price' => 45000,
                'stock' => 30,
                'image' => 'https://images.unsplash.com/photo-1501004318647-c843b4d4d4d4?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 7,
                'name' => 'Codiaeum Variegatum',
                'description' => 'Tanaman outdoor berdaun warna-warni yang memukau untuk halaman depan.',
                'price' => 90000,
                'stock' => 13,
                'image' => 'https://images.unsplash.com/photo-1501004318648-8c3f6f0e6c5f?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 6,
                'name' => 'Pot Beton Minimalis 30cm',
                'description' => 'Pot outdoor kuat dan elegan untuk tanaman besar atau tanaman hias.',
                'price' => 85000,
                'stock' => 40,
                'image' => 'https://images.unsplash.com/photo-1512428813834-c702c7702b78?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 6,
                'name' => 'Pupuk Kompos Organik 5kg',
                'description' => 'Pupuk organik untuk memperbaiki tanah dan menunjang pertumbuhan tanaman outdoor.',
                'price' => 55000,
                'stock' => 25,
                'image' => 'https://images.unsplash.com/photo-1464226184884-fa280b87c399?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 6,
                'name' => 'Saringan Air Tanaman',
                'description' => 'Alat penyiram praktis untuk merawat tanaman outdoor dan indoor dengan lebih rapi.',
                'price' => 32000,
                'stock' => 35,
                'image' => 'https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 1,
                'name' => 'Pilea Peperomioides',
                'description' => 'Tanaman daun bulat yang sedang populer untuk meja kerja dan sudut ruangan.',
                'price' => 110000,
                'stock' => 15,
                'image' => 'https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 2,
                'name' => 'Rafflesia Mini',
                'description' => 'Tanaman bunga eksotis dengan bentuk unik, cocok untuk koleksi pecinta tanaman.',
                'price' => 170000,
                'stock' => 8,
                'image' => 'https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 3,
                'name' => 'Sukulen Panda',
                'description' => 'Sukulen lucu dengan bentuk daun tebal dan warna hijau lembut.',
                'price' => 38000,
                'stock' => 24,
                'image' => 'https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 4,
                'name' => 'Philodendron Brasil',
                'description' => 'Tanaman gantung dengan daun hijau mengkilap bercorak kuning keemasan.',
                'price' => 95000,
                'stock' => 16,
                'image' => 'https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 5,
                'name' => 'Aglaonema Sipit',
                'description' => 'Tanaman indoor dengan warna daun hijau dan putih yang elegan.',
                'price' => 98000,
                'stock' => 18,
                'image' => 'https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 6,
                'name' => 'Tray Pot Kecil',
                'description' => 'Wadah tanaman kecil yang praktis untuk dekorasi meja dan rak.',
                'price' => 22000,
                'stock' => 50,
                'image' => 'https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 7,
                'name' => 'Yucca Gloriosa',
                'description' => 'Tanaman outdoor dengan daun tajam dan bentuk kokoh untuk halaman depan.',
                'price' => 135000,
                'stock' => 11,
                'image' => 'https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 7,
                'name' => 'Coleus',
                'description' => 'Tanaman outdoor berdaun warna-warni yang cocok untuk taman sempit.',
                'price' => 50000,
                'stock' => 21,
                'image' => 'https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 7,
                'name' => 'Gardenia',
                'description' => 'Tanaman outdoor harum dengan bunga putih yang elegant untuk dekorasi taman.',
                'price' => 145000,
                'stock' => 10,
                'image' => 'https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 6,
                'name' => 'Kawat Penyangga Tanaman',
                'description' => 'Alat bantu untuk menopang tanaman merambat dan tanaman tinggi.',
                'price' => 28000,
                'stock' => 32,
                'image' => 'https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ],
            [
                'category_id' => 7,
                'name' => 'Aloe Vera',
                'description' => 'Tanaman outdoor dan indoor yang tahan kekeringan dan cocok untuk dekorasi meja.',
                'price' => 42000,
                'stock' => 27,
                'image' => 'https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?auto=format&fit=crop&w=600&q=80',
                'status' => 'aktif'
            ]
        ];

        foreach ($dummyProducts as $product) {
            $productData = $product;
            if (!isset($productData['category_id']) && isset($productData['category'])) {
                $productData['category_id'] = Category::where('name', $productData['category'])->value('id');
            }

            if (empty($productData['category_id'])) {
                continue;
            }

            \App\Models\Product::firstOrCreate(
                ['name' => $productData['name']],
                $productData
            );
        }
    }
}
