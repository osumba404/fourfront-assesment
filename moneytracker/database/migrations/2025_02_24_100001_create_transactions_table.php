<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Transactions are income or expense entries per wallet.
     * Amount is always stored as positive; type (income/expense) determines
     * whether it adds to or subtracts from the wallet balance.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['income', 'expense']);
            $table->decimal('amount', 15, 2); // always positive
            $table->string('description')->nullable();
            $table->date('transaction_date');
            $table->string('reference')->nullable(); // external reference
            $table->timestamps();
            $table->softDeletes();

            $table->index(['wallet_id', 'transaction_date']);
            $table->index(['wallet_id', 'type']);
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
