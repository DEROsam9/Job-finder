<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE client_documents MODIFY document_type ENUM(
            'id_card',
            'passport_copy',
            'cv',
            'good_conduct',
            'client_id_front',
            'client_id_back'
        )");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE client_documents MODIFY document_type ENUM(
            'id_card',
            'passport_copy',
            'cv',
            'good_conduct'
        )");
    }
};

