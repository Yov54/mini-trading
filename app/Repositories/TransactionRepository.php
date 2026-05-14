<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Models\User;

class TransactionRepository
{
    /**
     * Create a new transaction to the database
     * @param int $userId
     * @param string $assetSymbol
     * @param string $type
     * @param float $volume
     * @param float $price
     * @param float $totalCost
     * @return \App\Models\Transaction
     */

    public function createTransaction(int $userId, string $assetSymbol, string $type, float $volume, float $price, float $totalCost)
    {
        return Transaction::create([
            'user_id' => $userId,
            'asset_symbol' => $assetSymbol,
            'type' => $type,
            'volume' => $volume,
            'price' => $price,
            'total_cost' => $totalCost,
        ]);
    }


    /**
     * Deduct user balance after a transaction
     * @param \App\Models\User $user
     * @param float $amount
     * @return \App\Models\User
     */

    public function deductUserBalance(User $user, float $amount)
    {
        $user->balance -= $amount;
        $user->save();
        
        return $user;
    }

}