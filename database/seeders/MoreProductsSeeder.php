<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class MoreProductsSeeder extends Seeder
{
    public function run()
    {
        $products = [
            ['name' => 'Basreng Pedas Daun Jeruk', 'price' => 15000, 'category' => 'keripik', 'description' => 'Bakso goreng renyah dengan bumbu pedas daun jeruk yang harum.'],
            ['name' => 'Makaroni Bantet', 'price' => 10000, 'category' => 'keripik', 'description' => 'Makaroni bantet super renyah dengan varian rasa pedas dan asin.'],
            ['name' => 'Kerupuk Seblak Kering', 'price' => 12000, 'category' => 'keripik', 'description' => 'Kerupuk seblak dengan kencur yang terasa nendang.'],
            ['name' => 'Usus Crispy', 'price' => 18000, 'category' => 'keripik', 'description' => 'Usus ayam goreng tepung yang super crispy dan gurih.'],
            ['name' => 'Keripik Kaca', 'price' => 10000, 'category' => 'keripik', 'description' => 'Keripik singkong super tipis dengan bumbu cabe merah asli.'],
            ['name' => 'Emping Melinjo Manis', 'price' => 30000, 'category' => 'keripik', 'description' => 'Emping melinjo asli dengan balutan gula merah manis legit.'],
            ['name' => 'Kacang Umpet', 'price' => 15000, 'category' => 'keripik', 'description' => 'Camilan kulit pangsit bersembunyi kacang di dalamnya.'],
            ['name' => 'Keripik Singkong Balado', 'price' => 12000, 'category' => 'keripik', 'description' => 'Keripik singkong klasik dengan bumbu balado padang.'],
            ['name' => 'Stik Keju', 'price' => 20000, 'category' => 'keripik', 'description' => 'Stik keju premium yang renyah dan terasa banget kejunya.'],
            ['name' => 'Sale Pisang', 'price' => 18000, 'category' => 'keripik', 'description' => 'Sale pisang goreng tepung yang manis dan renyah.'],
        ];

        foreach ($products as $p) {
            Product::create([
                'name' => $p['name'],
                'description' => $p['description'],
                'price' => $p['price'],
                'image' => 'https://via.placeholder.com/300x200.png?text=' . urlencode($p['name']),
                'category' => $p['category'],
                'stock' => 20,
                'is_ready' => true
            ]);
        }
    }
}
