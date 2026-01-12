<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\LogisticService;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    protected $logistics;

    public function __construct(LogisticService $logistics)
    {
        $this->logistics = $logistics;
    }

    public function getProvinces()
    {
        return response()->json($this->logistics->getProvinces());
    }

    public function getCities(Request $request)
    {
        $provinceId = $request->query('province_id');
        return response()->json($this->logistics->getCities($provinceId));
    }

    public function getDistricts(Request $request)
    {
        $cityId = $request->query('city_id');
        return response()->json($this->logistics->getDistricts($cityId));
    }

    public function getVillages(Request $request)
    {
        $districtId = $request->query('district_id');
        return response()->json($this->logistics->getVillages($districtId));
    }

    public function getShippingCost(Request $request)
    {
        $request->validate([
            'destination' => 'required',
            'weight' => 'required|numeric',
            'courier' => 'required|in:jne,pos,tiki'
        ]);

        $results = $this->logistics->getCost(
            $request->destination,
            $request->weight,
            $request->courier
        );

        return response()->json($results);
    }
}
