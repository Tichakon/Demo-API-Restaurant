<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class PlaceApiController extends Controller
{
    public function store(Request $request)
    {
        $name = $request->name;

        if (Cache::has($name)) {
            $value = Cache::get($name);

            return response()->json([
                'data' => $value,
                'err' => 0
            ], 200);
        }

        $endpoint = "https://maps.googleapis.com/maps/api/place/textsearch/json";

        $body = [
            'query' => $name,
            'key' => env('GOOGLE_MAPS_API_KEY'),
            'type' => 'restaurant'
        ];

        $response = Http::acceptJson()->get($endpoint, $body);

        if ($response->status() != 200) {
            return response()->json([
                'data' => [],
                'err' => 1
            ], 200);
        }

        $data = $response->json();

        if ($data['status'] != 'OK') {
            return response()->json([
                'data' => [],
                'err' => 2
            ], 200);
        }

        Cache::put($name, $data, 600);

        return response()->json([
            'data' => $data,
            'err' => 0
        ], 200);
    }
}
