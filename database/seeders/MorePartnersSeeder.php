<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Partner;

class MorePartnersSeeder extends Seeder
{
    public function run()
    {
        $partners = [
            [
                'name' => 'Warung Bu Siti',
                'address' => 'Jl. Kenanga No. 5, Jakarta Selatan',
                'info' => 'Stok lengkap Keripik & Rempeyek',
                'latitude' => '-6.250000',
                'longitude' => '106.800000'
            ],
            [
                'name' => 'Agen Snack Jaya',
                'address' => 'Pasar Minggu Blok A2',
                'info' => 'Distributor resmi wilayah Selatan',
                'latitude' => '-6.280000',
                'longitude' => '106.830000'
            ],
            [
                'name' => 'Mini Market 24 Jam',
                'address' => 'Jl. Fatmawati Raya No. 88',
                'info' => 'Tersedia kemasan ekonomis',
                'latitude' => '-6.300000',
                'longitude' => '106.790000'
            ]
        ];

        foreach ($partners as $p) {
            Partner::create($p);
        }
    }
}
