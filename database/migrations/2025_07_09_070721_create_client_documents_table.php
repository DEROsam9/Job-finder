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
        Schema::create('client_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->string('remarks')->nullable();
            $table->enum('document_type', ['id_copy', 'passport_copy', 'curriculum_vitae', 'good_conduct_certificate']);
            $table->date('passport_expiry_date')->nullable();
            $table->string('document_url')->nullable();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_documents');
    }
};
