<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TransactionService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * @var TransactionService
     */
    protected $transactionService;

    /**
     * Constructor to inject TransactionService
     */
    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * Endpoint to handle buying an asset
     */
    public function buy(Request $request)
    {
        // Input Validation
        $validator = Validator::make($request->all(), [
            'asset_symbol' => 'required|string|max:10',
            'volume' => 'required|numeric|min:0.0001',
            'price' => 'required|numeric|min:0.01',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Get authenticated user(from sanctum token)
        $user = $request->user();

        /**
         * for this simulation project, request of price can be sent from client side for testing purposes. 
         */

        try {
            // Call the Service to perform the buy transaction
            $transaction = $this->transactionService->buyAsset(
                $user,
                $request->asset_symbol,
                (float) $request->volume,
                (float) $request->price
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Asset bought successfully',
                'data' => [
                    'transaction' => $transaction,
                    'current_balance' => $user->balance, // Show updated balance after transaction
                ]
            ], 201);

        } catch (Exception $e) {
            // catch any error thrown by the Service and return as JSON response
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
