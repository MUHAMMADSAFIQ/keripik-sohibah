<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class LogisticService
{
    // Base Rates per Zone
    protected $baseRates = [
        'jawa' => 15000,
        'sumatera' => 25000,
        'kalimantan' => 30000,
        'sulawesi' => 35000,
        'nusa_tenggara' => 40000,
        'maluku_papua' => 60000,
        'default' => 30000
    ];

    public function getProvinces()
    {
        // Fetch from local 'wilayah' table
        // Codes with length 2 are provinces (e.g., '11', '33')
        $provinces = DB::table('wilayah')
            ->whereRaw('CHAR_LENGTH(kode) = 2')
            ->orderBy('nama')
            ->get();

        return $provinces->map(function($p) {
            return [
                'province_id' => $p->kode,
                'province' => $p->nama
            ];
        });
    }

    public function getCities($provinceId)
    {
        // Fetch Cities for Province
        // Format: '33.01' (Kabupaten), '33.71' (Kota) - Length 5
        $cities = DB::table('wilayah')
            ->where('kode', 'like', $provinceId . '.%')
            ->whereRaw('CHAR_LENGTH(kode) = 5')
            ->orderBy('nama')
            ->get();

        return $cities->map(function($c) use ($provinceId) {
            return [
                'city_id' => $c->kode,
                'province_id' => $provinceId,
                'type' => str_contains($c->nama, 'KOTA') ? 'Kota' : 'Kabupaten',
                'city_name' => $c->nama
            ];
        });
    }

    public function getDistricts($cityId)
    {
        // Fetch Districts (Kecamatan)
        // Format: '33.06.01' - Length 8
        $districts = DB::table('wilayah')
            ->where('kode', 'like', $cityId . '.%')
            ->whereRaw('CHAR_LENGTH(kode) = 8')
            ->orderBy('nama')
            ->get();

        return $districts->map(function($d) use ($cityId) {
            return [
                'district_id' => $d->kode,
                'city_id' => $cityId,
                'district_name' => $d->nama
            ];
        });
    }

    public function getVillages($districtId)
    {
        // Fetch Villages (Desa/Kelurahan)
        // Format: '33.06.01.2001' - Length > 8 (usually 13)
        $villages = DB::table('wilayah')
            ->where('kode', 'like', $districtId . '.%')
            ->whereRaw('CHAR_LENGTH(kode) > 8')
            ->orderBy('nama')
            ->get();

        return $villages->map(function($v) use ($districtId) {
            return [
                'village_id' => $v->kode,
                'district_id' => $districtId,
                'village_name' => $v->nama
            ];
        });
    }

    public function getCost($destinationCityId, $weight, $courier)
    {
        // Determine Zone based on Province Code from City ID
        // City ID example: '33.06' -> Province '33' (Jateng)
        
        $provinceCode = substr((string)$destinationCityId, 0, 2);
        
        // Define Zones based on BPS Codes
        // 11-21: Sumatera
        // 31-36: Jawa
        // 51-53: Nusa Tenggara
        // 61-65: Kalimantan
        // 71-76: Sulawesi
        // 81-82: Maluku
        // 91-95: Papua
        
        $zone = 'default';
        $p = (int)$provinceCode;
        
        if ($p >= 31 && $p <= 36) $zone = 'jawa';
        elseif ($p >= 11 && $p <= 21) $zone = 'sumatera';
        elseif ($p >= 61 && $p <= 65) $zone = 'kalimantan';
        elseif ($p >= 71 && $p <= 76) $zone = 'sulawesi';
        elseif ($p >= 51 && $p <= 53) $zone = 'nusa_tenggara';
        elseif ($p >= 81 && $p <= 94) $zone = 'maluku_papua';

        $basePrice = $this->baseRates[$zone] ?? 30000;
        
        // Adjust by Courier
        if ($courier == 'pos') $basePrice += 2000;
        if ($courier == 'tiki') $basePrice += 5000;
        
        // Adjust by Weight (ceil to nearest KG)
        $weightKg = ceil($weight / 1000);
        $totalCost = $basePrice * $weightKg;

        return [
            [
                'service' => 'REG',
                'description' => 'Layanan Reguler',
                'cost' => [['value' => $totalCost, 'etd' => '2-3', 'note' => '']]
            ],
            [
                'service' => 'EXPRESS',
                'description' => 'Layanan Cepat',
                'cost' => [['value' => $totalCost * 1.5, 'etd' => '1-2', 'note' => '']]
            ]
        ];
    }
}
