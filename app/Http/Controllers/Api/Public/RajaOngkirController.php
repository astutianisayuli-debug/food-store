<?php

namespace App\Http\Controllers\Api\Public;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class RajaOngkirController extends Controller
{
    public function searchDestination(Request $request)
    {
        $response = Http::withHeaders([
            'key' => config('rajaongkir.api_key')
        ])->get('https://rajaongkir.komerce.id/api/v1/destination/domestic-destination', [
            'search' => $request->search,
            'limit'  => 100,
            'offset' => 0
        ]);

        if ($response->successful() && isset($response['data'])) {
            return response()->json($response['data']);
        }

        // DUMMY (dipakai kalau API gagal)
        return response()->json([
            [
                'id'               => 1,
                'label'            => 'DIWEK, DIWEK, JOMBANG, JAWA TIMUR, 61471',
                'province_name'    => 'JAWA TIMUR',
                'city_name'        => 'JOMBANG',
                'district_name'    => 'DIWEK',
                'subdistrict_name' => 'DIWEK',
                'zip_code'         => '61471',
            ],
            [
                'id'               => 2,
                'label'            => 'JOMBANG, JOMBANG, JOMBANG, JAWA TIMUR, 61411',
                'province_name'    => 'JAWA TIMUR',
                'city_name'        => 'JOMBANG',
                'district_name'    => 'JOMBANG',
                'subdistrict_name' => 'JOMBANG',
                'zip_code'         => '61411',
            ],
        ]);
    }

    public function checkOngkir(Request $request)
    {
        $response = Http::withHeaders([
            'key' => config('rajaongkir.api_key')
        ])->asForm()->post('https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
            'origin'      => 46174,
            'destination' => $request->destination,
            'weight'      => $request->weight,
            'courier'     => $request->courier
        ]);

        if ($response->successful() && isset($response['data'])) {
            return response()->json($response['data']);
        }

        // DUMMY (dipakai kalau API gagal)
        return response()->json([
            [
                'name'        => 'Jalur Nugraha Ekakurir (JNE)',
                'code'        => 'jne',
                'service'     => 'REG',
                'description' => 'Layanan Reguler',
                'cost'        => 15000,
                'etd'         => '2-3 day',
            ],
            [
                'name'        => 'Jalur Nugraha Ekakurir (JNE)',
                'code'        => 'jne',
                'service'     => 'YES',
                'description' => 'Yakin Esok Sampai',
                'cost'        => 28000,
                'etd'         => '1 day',
            ],
        ]);
    }
}