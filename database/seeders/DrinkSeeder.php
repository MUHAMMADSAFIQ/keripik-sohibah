<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class DrinkSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'name' => 'Es Teh Manis Jumbo',
            'description' => 'Teh manis dingin segar dengan ukuran jumbo, pas untuk menghilangkan dahaga.',
            'price' => 5000,
            'image' => 'https://plus.unsplash.com/premium_photo-1663853291253-9b93557e492b?q=80&w=2070&auto=format&fit=crop',
            'category' => 'minuman',
            'stock' => 100
        ]);
        
        Product::create([
            'name' => 'Jus Alpukat',
            'description' => 'Jus alpukat kental dengan susu coklat yang nikmat.',
            'price' => 12000,
            'image' => 'https://plus.unsplash.com/premium_photo-1675704909893-1b15aa2d815e?q=80&w=1978&auto=format&fit=crop',
            'category' => 'minuman',
            'stock' => 20
        ]);

        Product::create([
            'name' => 'Es Jeruk Peras',
            'description' => 'Jeruk peras asli tanpa biang gula.',
            'price' => 8000,
            'image' => 'https://images.unsplash.com/photo-1613478223719-2ab802602423?q=80&w=2047&auto=format&fit=crop',
            'category' => 'minuman',
            'stock' => 50
        ]);
    }
}
