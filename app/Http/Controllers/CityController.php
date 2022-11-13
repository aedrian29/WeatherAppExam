<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OpenWeatherService;
use App\Services\FourSquareService;

class CityController extends Controller
{
    private $OpenWeatherService;

    public function __construct(
        OpenWeatherService $OpenWeatherService,
        FourSquareService $FourSquareService
    )
    {
        $this->openWeatherService = $OpenWeatherService;
        $this->fourSquareService = $FourSquareService;
    }

    public function getData($city)
    {
        return [
            "weather" => json_decode(
                            $this
                            ->openWeatherService
                            ->data($city)),
            "places" => $this
                        ->fourSquareService
                        ->data($city)
        ];
    }
}
