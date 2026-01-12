<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Testimonial;
use App\Models\Partner;

class ShopSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'name' => 'Keripik Pisang Panjang Original',
            'description' => 'Keripik pisang dengan potongan panjang yang renyah dan rasa original yang gurih.',
            'price' => 15000,
            'image' => 'https://plus.unsplash.com/premium_photo-1694619472658-3d23eb46b334?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'category' => 'keripik',
            'stock' => 50
        ]);

        Product::create([
            'name' => 'Keripik Talas',
            'description' => 'Keripik talas pilihan dengan bumbu rahasia yang bikin ketagihan.',
            'price' => 18000,
            'image' => 'https://plus.unsplash.com/premium_photo-1675237626155-7daee7651a02?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'category' => 'keripik',
            'stock' => 30
        ]);

        Product::create([
            'name' => 'Rempeyek Kacang',
            'description' => 'Rempeyek renyah dengan toping kacang tanah yang melimpah.',
            'price' => 12000,
            'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/00/Rempeyek_kacang_tanah.JPG/1200px-Rempeyek_kacang_tanah.JPG',
            'category' => 'keripik',
            'stock' => 45
        ]);

        Testimonial::create([
            'customer_name' => 'Budi Santoso',
            'content' => 'Keripiknya renyah banget! Pas buat teman nonton TV.',
            'rating' => 5,
            'is_approved' => true
        ]);
        
        Testimonial::create([
            'customer_name' => 'Siti Aminah',
            'content' => 'Pengiriman cepat, rasa keripik talasnya juara.',
            'rating' => 5,
            'is_approved' => true
        ]);

        Testimonial::create([
             'customer_name' => 'Rahmat Hidayat',
             'content' => 'Harganya terjangkau, rasanya enak. Recommended!',
             'rating' => 4,
             'is_approved' => true
        ]);

        Testimonial::create([
             'customer_name' => 'Dewi Lestari',
             'content' => 'Suka banget sama rempeyeknya, gurih pol!',
             'rating' => 5,
             'is_approved' => true
        ]);
        
        Partner::create([
            'name' => 'Toko Barokah',
            'address' => 'Jl. Mawar No. 10',
            'info' => 'Menyediakan Keripik Pisang & Talas',
            'latitude' => '-6.200000',
            'longitude' => '106.816666'
        ]);
    }
}
