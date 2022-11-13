<?php

namespace App\Services;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\GuzzleException;

class OpenWeatherService
{
    const OPEN_WEATHER_BASE_URL = "https://api.openweathermap.org/data/2.5/weather?";
    const CITY = "q=";
    const API_KEY = "&appid=";
    const TEMP_UNIT = "&units=metric";

    public function data($city)
    {
        $this->client = new Client();

        try{
            $res = $this->client
                    ->request(
                        'GET',
                        self::OPEN_WEATHER_BASE_URL.""
                        .self::CITY.$city
                        .self::API_KEY.env("OPEN_WEATHER_API_KEY")
                        .self::TEMP_UNIT
                    );
            return $res = $res->getBody();
        } catch(GuzzleException $e) {
            Log::Error("No found city");
        }
    }
}
