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
        Schema::table('input_fields', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->integer('max_length')->nullable()->after('placeholder');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('input_fields', function (Blueprint $table) {
            //
        });
    }
};
