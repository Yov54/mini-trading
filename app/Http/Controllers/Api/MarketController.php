<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    /**
     * Endpoint to get current market prices.
     * @return JsonResponse
     */
    public function getPrices(): JsonResponse
    {
        // Cache::remember will check if 'market_prices' exists in redis. If it does, it returns the cached value.
        $prices = Cache::remember('market_prices', 5, function () {
            // Simulate fetching market prices
            return [
                'EURUSD' => rand(10000, 11000) / 10000,
                'GBPUSD' => rand(12000, 13000) / 10000,
                'GOLD'   => rand(190000, 200000) / 100,
                'BTCUSD' => rand(6000000, 6500000) / 100,
                'updated_at' => now()->toDateTimeString()
            ];
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Market prices retrieved successfully',
            'data' => $prices
        ], 200);
    }
}
