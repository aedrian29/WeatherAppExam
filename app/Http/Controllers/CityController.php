<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OpenWeatherService;
use App\Services\FourSquareService;

class CityController extends Controller
{
    private $openWeatherService;
    private $fourSquareService;

    public function __construct(
        OpenWeatherService $openWeatherService,
        FourSquareService $fourSquareService
    )
    {
        $this->openWeatherService = $openWeatherService;
        $this->fourSquareService = $fourSquareService;
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
