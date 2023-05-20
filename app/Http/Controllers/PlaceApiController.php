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
        $data = Cache::remember($name, 600, function () use ($name) {
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
                    'err' => 0
                ], 200);
            }

            $data = $response->json();

            return $data;
        });

        return response()->json([
            'data' => $data,
            'err' => 0
        ], 200);
    }
}
