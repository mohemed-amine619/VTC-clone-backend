<?php

namespace App\Http\Controllers\MapBox;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PlaceController extends Controller
{

    public function fetchPlaces(Request $request)
    {
        $response = Http::get('https://api.mapbox.com/search/geocode/v6/forward', [
            'q' => $request->place,
            'access_token' => env('MAPBOX_ACCESS_TOKEN'),
            'limit' => 10,
            'language' => "fr",
            'country' => 'DZ',
        ]);
        if ($response->successful()) {
            return $response->json();
        } else {
            return response(['message' => 'Failed To Fetch the place'], $response->status());
        }
    }
}
