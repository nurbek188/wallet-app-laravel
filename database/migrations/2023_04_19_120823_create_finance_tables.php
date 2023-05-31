<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('balance', 64)->default(0);
            $table->string('currency', 5)->default('RUB');
            $table->timestamps();
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type', ['debit', 'credit'])->index();
            $table->decimal('amount', 64);
            $table->string('currency', 5);
            $table->enum('reason', ['stock', 'refund', 'gift'])->index();
            $table->integer('wallet_id')->index();
            $table->timestamps();
            $table->foreign('wallet_id')
                ->references('id')
                ->on('wallets')
                ->onDelete('cascade');
        });

        Schema::create('currency_rates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('from');
            $table->string('to');
            $table->decimal('rate', 8, 4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('wallets');
        Schema::dropIfExists('currency_rates');
    }
};
