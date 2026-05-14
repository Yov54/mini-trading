<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            // relationship to users table
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Asset symbol (e.g., BTC, ETH)
            $table->string('asset_symbol');

            // Transaction type (buy/sell)
            $table->enum('type', ['buy', 'sell']);
            
            // Purchased quantity/volume (e.g., 1.5 lots)
            $table->decimal('volume', 10, 2); 

            // Price per unit at the time of transaction
            $table->decimal('price', 15, 2); 

            // Total value of the transaction (price * volume)
            $table->decimal('total_cost', 20, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
