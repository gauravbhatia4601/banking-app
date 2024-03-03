<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('type', ['debit', 'credit']); // Represents whether the amount is debited or credited
            $table->enum('transaction_type', ['withdraw', 'transfer', 'deposit']); // Represents the type of transaction
            $table->decimal('amount', 15, 2); // Precision adjusted to handle large amounts
            $table->string('transfer_to')->nullable(); // Represents the email of the user for transfer transactions
            $table->decimal('sender_balance', 15, 2);
            $table->decimal('receiver_balance', 15, 2)->nullable();
            $table->timestamps();

            // Foreign key constraint to link with users table (assuming users table exists)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
