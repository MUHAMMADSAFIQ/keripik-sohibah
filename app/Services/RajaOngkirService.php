<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class RajaOngkirService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $type = env('RAJAONGKIR_TYPE', 'starter'); // starter, basic, pro
        $this->baseUrl = "https://api.rajaongkir.com/{$type}";
        // Use a default key or the environment variable
        $this->apiKey = env('RAJAONGKIR_API_KEY', 'wNYvebNZ62cdfe623282af5fJU4cmEIa'); // Updated with user key
    }

    public function getProvinces()
    {
        // Remove cache for debugging/demo purposes if needed, or keep it short
        // return Cache::remember('rajaongkir_provinces', 60 * 24 * 30, function () {
            try {
                Log::info("RajaOngkir: Fetching provinces...");
                $response = Http::withoutVerifying()->withHeaders(['key' => $this->apiKey])->get("{$this->baseUrl}/province");
                
                // Retry if 400 (Bad Request) or 410 (Gone - upgrade to Pro)
                if ($response->failed() && in_array($response->status(), [400, 410])) {
                     Log::warning("RajaOngkir: Standard endpoint failed ({$response->status()}), retrying with PRO endpoint...");
                     $this->baseUrl = str_replace(['starter', 'basic'], 'pro', $this->baseUrl);
                     $response = Http::withoutVerifying()->withHeaders(['key' => $this->apiKey])->get("{$this->baseUrl}/province");
                }

                if ($response->failed()) {
                    Log::error("RajaOngkir Error: " . $response->body());
                    return $this->getMockProvinces(); // Fallback to mock
                }

                return $response->json()['rajaongkir']['results'] ?? [];
            } catch (\Exception $e) {
                Log::error("RajaOngkir Exception: " . $e->getMessage());
                return $this->getMockProvinces(); // Fallback to mock
            }
        // });
    }

    public function getCities($provinceId = null)
    {
        try {
            $params = [];
            if ($provinceId) {
                $params['province'] = $provinceId;
            }
            
            Log::info("RajaOngkir: Fetching cities...", $params);
            $response = Http::withoutVerifying()->withHeaders(['key' => $this->apiKey])->get("{$this->baseUrl}/city", $params);
            
            if ($response->failed()) {
                Log::error("RajaOngkir Error: " . $response->body());
                return $this->getMockCities($provinceId); // Fallback
            }

            return $response->json()['rajaongkir']['results'] ?? [];
        } catch (\Exception $e) {
            Log::error("RajaOngkir Exception: " . $e->getMessage());
            return $this->getMockCities($provinceId); // Fallback
        }
    }

    public function getCost($origin, $destination, $weight, $courier)
    {
        try {
            Log::info("RajaOngkir: Calculating cost", compact('origin', 'destination', 'weight', 'courier'));
            $response = Http::withoutVerifying()->withHeaders(['key' => $this->apiKey])->post("{$this->baseUrl}/cost", [
                'origin' => $origin,
                'destination' => $destination,
                'weight' => $weight,
                'courier' => $courier
            ]);

            if ($response->failed()) {
                Log::error("RajaOngkir Cost Error: " . $response->body());
                return $this->getMockCost($courier); // Fallback
            }

            return $response->json()['rajaongkir']['results'][0]['costs'] ?? [];
        } catch (\Exception $e) {
            Log::error("RajaOngkir Cost Exception: " . $e->getMessage());
            return $this->getMockCost($courier); // Fallback
        }
    }

    // --- MOCK DATA FUNCTIONS (Restored for UX stability) ---

    private function getMockProvinces()
    {
        return [
            ['province_id' => 10, 'province' => 'Jawa Tengah (Demo/Key Salah)'],
            ['province_id' => 5,  'province' => 'DI Yogyakarta (Demo/Key Salah)'],
            ['province_id' => 6,  'province' => 'DKI Jakarta (Demo/Key Salah)'],
        ];
    }

    private function getMockCities($provinceId)
    {
        // Simple mock logic
        if ($provinceId == 10) { // Jateng
            return [
                ['city_id' => 369, 'province_id' => 10, 'type' => 'Kabupaten', 'city_name' => 'Purworejo'],
                ['city_id' => 222, 'province_id' => 10, 'type' => 'Kota', 'city_name' => 'Magelang'],
            ];
        }
        return [
             ['city_id' => 1, 'province_id' => $provinceId, 'type' => 'Kota', 'city_name' => 'Kota Contoh']
        ];
    }

    private function getMockCost($courier)
    {
        return [
            [
                'service' => 'REG',
                'description' => 'Layanan Reguler (Demo)',
                'cost' => [['value' => 25000, 'etd' => '2-3', 'note' => '']]
            ],
            [
                'service' => 'YES',
                'description' => 'Yakin Esok Sampai (Demo)',
                'cost' => [['value' => 45000, 'etd' => '1-1', 'note' => '']]
            ]
        ];
    }
}
