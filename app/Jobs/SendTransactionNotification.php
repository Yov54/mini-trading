<?php

namespace App\Jobs;

use App\Models\Transaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendTransactionNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $transaction;
    /**
     * Create a new job instance.
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //loading or delay simulation for 3 seconds
        sleep(3);

        // Log the transaction details (In real application, you would send an email or push notification)
        Log::info('Transaction Notification Sent');
        Log::info('Transaction ID: ' . $this->transaction->id . ' | Aset: ' . $this->transaction->asset_symbol);
    }
}
