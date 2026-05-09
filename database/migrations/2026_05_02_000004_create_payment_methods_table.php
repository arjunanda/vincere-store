<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['bank', 'ewallet', 'qris'])->default('bank');
            $table->string('name'); // Contoh: Bank BCA, OVO, QRIS All Payment
            $table->string('code')->unique(); // bca, ovo, qris
            $table->string('account_number')->nullable(); // No Rekening / No HP
            $table->string('account_name')->nullable(); // Atas Nama
            $table->string('image')->nullable(); // Logo Pembayaran
            $table->string('qris_image')->nullable(); // Khusus untuk upload gambar QRIS
            $table->decimal('fee', 10, 2)->default(0); // Biaya admin jika ada
            $table->string('bank_code')->nullable(); // Kode Bank (014, 008, dll)
            $table->string('bank_name')->nullable(); // Nama Bank Resmi
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
