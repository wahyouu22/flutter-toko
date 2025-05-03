<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OngkirController extends Controller
{
    private $apiKey;
    private $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('RAJAONGKIR_API_KEY');
        $this->baseUrl = env('RAJAONGKIR_BASE_URL');
    }

    public function index()
    {
        // Get provinces data
        $provincesResponse = Http::withHeaders([
            'key' => $this->apiKey
        ])->get("{$this->baseUrl}/province");

        $provinces = [];
        if ($provincesResponse->successful()) {
            $provinces = $provincesResponse->json()['rajaongkir']['results'];
        }

        // Get cities data
        $citiesResponse = Http::withHeaders([
            'key' => $this->apiKey
        ])->get("{$this->baseUrl}/city");

        $cities = [];
        if ($citiesResponse->successful()) {
            $cities = $citiesResponse->json()['rajaongkir']['results'];
        }

        $couriers = [
            'jne' => 'JNE',
            'pos' => 'POS Indonesia',
            'tiki' => 'TIKI'
        ];

        return view('ongkir', compact('provinces', 'cities', 'couriers'));
    }

    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'origin' => 'required|numeric',
            'destination' => 'required|numeric',
            'weight' => 'required|numeric|min:1',
            'courier' => 'required|in:jne,pos,tiki'
        ]);

        $response = Http::withHeaders([
            'key' => $this->apiKey,
            'content-type' => 'application/x-www-form-urlencoded'
        ])->asForm()->post("{$this->baseUrl}/cost", [
            'origin' => $validated['origin'],
            'destination' => $validated['destination'],
            'weight' => $validated['weight'],
            'courier' => $validated['courier']
        ]);

        $result = [];
        if ($response->successful()) {
            $result = $response->json()['rajaongkir'];
        }

        // Membuat respons dalam format JSON
        return response()->json([
            'result' => $result,
            'validated' => $validated,
        ]);
    }

    public function getCities($provinceId)
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->get("{$this->baseUrl}/city", [
            'province' => $provinceId
        ]);

        if ($response->successful()) {
            return response()->json($response->json()['rajaongkir']['results']);
        }

        return response()->json([]);
    }
}
