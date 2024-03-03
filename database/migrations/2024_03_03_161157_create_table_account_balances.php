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
        Schema::create('account_balances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Use unsigned for foreign keys
            $table->decimal('balance', 15, 2)->default(0.00); // Correct precision for billions
            $table->timestamps();
        
            // Foreign key constraint with explicit index for efficiency
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('user_id');
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_balances');
    }
};
