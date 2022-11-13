<?php

namespace App\Services;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\GuzzleException;

class FourSquareService
{
    const FOUR_SQUARE_BASE_URL = "https://api.foursquare.com/v3/autocomplete?";
    const RADIUS = 200000;
    const LIMIT = 5;
    const CATEGORY = [16000,19000,18000,17000,10000];
    const JAPAN_LONGTITUDE_LATITUDE = "36.2048%2C138.2529";

    public function data($city)
    {
        $this->client = new Client();
        $options['headers'] = [
            'Authorization' => env("FOUR_SQUARE_AUTHORIZATION_KEY"),
            'Content-Type' => 'application/json'
        ];
        $random = rand(0,4);
        try{
            $request = $this->client->request(
                "GET",
                self::FOUR_SQUARE_BASE_URL
                ."query=".$city
                ."&ll=".self::JAPAN_LONGTITUDE_LATITUDE
                ."&radius=".self::RADIUS
                ."&limit=".self::LIMIT
                ."&category=".self::CATEGORY[$random],
                $options
            );
            $data = json_decode($request->getBody());
            return $data->results;

        } catch(GuzzleException $e) {
            Log::Error("No found city");
        }
    }
}
