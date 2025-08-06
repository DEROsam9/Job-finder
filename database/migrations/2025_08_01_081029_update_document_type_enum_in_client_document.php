<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE client_documents MODIFY COLUMN document_type ENUM(
            'client_id_front',
            'client_id_back',
            'passport_copy',
            'cv',
            'good_conduct',
            'passport_photo'            
        )");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE client_documents MODIFY COLUMN document_type ENUM(
            'client_id_front',
            'client_id_back',
            'passport_copy',
            'cv',
            'good_conduct',
        )");
    }
};
