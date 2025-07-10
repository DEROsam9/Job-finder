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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->decimal('amount', 15, 2);
            $table->unsignedBigInteger('status_id')->nullable();
            $table->string('additional_information')->nullable();
            $table->json('payload')->nullable();
            $table->string('transaction_reference');
            $table->date('transaction_date')->nullable();
            $table->string('remarks')->nullable();
            $table->string('merchant_request_id')->nullable();
            $table->string('checkout_request_id')->nullable();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
