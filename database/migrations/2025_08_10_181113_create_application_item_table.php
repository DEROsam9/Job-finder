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
        Schema::create('application_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id');
            $table->unsignedBigInteger('career_id');
            $table->unsignedBigInteger('status_id');

            $table->foreign('application_id')
                    ->references('id')
                    ->on('applications')
                    ->onDelete('cascade');
                
             $table->foreign('career_id')
                    ->references('id')
                    ->on('careers')
                    ->onDelete('cascade');
                    
            $table->foreign('status_id')
                    ->references('id')
                    ->on('statuses')
                    ->onDelete('cascade');         

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_item');
    }
};
