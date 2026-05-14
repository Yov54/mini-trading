<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\TransactionRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    /**
     * @var TransactionRepository
     */
    protected $transactionRepository;

    /**
     * Dependency Injection: Injecting the Repository into the Service
     * 
     * @param TransactionRepository $transactionRepository
     */
    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Main function to handle the buying of an asset
     *
     * @param User 
     * @param string $assetSymbol
     * @param float $volume
     * @param float $price
     * @return \App\Models\Transaction
     * @throws Exception if balance is not enough or if any error occurs during the transaction process
     */
    public function buyAsset(User $user, string $assetSymbol, float $volume, float $price)
    {
        $totalCost = $volume * $price;

        // Check if user has enough balance
        if ($user->balance < $totalCost) {
            throw new Exception('Balance is not enough to complete this transaction.');
        }

        // if there's an shutdown or error in the middle of the process, the database will automatically rollback to the state before the transaction began.
        DB::beginTransaction();

        try {
            // Deduct user balance via Repository
            $this->transactionRepository->deductUserBalance($user, $totalCost);

            // record the transaction in the database via Repository
            $transaction = $this->transactionRepository->createTransaction(
                $user->id,
                $assetSymbol,
                'buy',
                $volume,
                $price,
                $totalCost
            );

            // If everything goes smoothly, save permanently to the database
            DB::commit();

            return $transaction;

        } catch (Exception $e) {
            // If there's a failure, rollback the balance deduction!
            DB::rollBack();
            
            // Throw the error to the Controller
            throw $e;
        }
    }
}