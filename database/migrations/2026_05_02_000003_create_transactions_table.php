<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique(); // Contoh: VTZ-123456
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            
            // Game & Variant Snapshot (Agar histori tetap benar meski data game berubah)
            $table->foreignId('game_id')->nullable()->constrained()->onDelete('set null');
            $table->string('game_name');
            $table->foreignId('variant_id')->nullable()->constrained('game_variants')->onDelete('set null');
            $table->string('variant_name');
            
            // Order Details
            $table->json('input_data'); // {user_id: "12345", zone_id: "6789"}
            $table->decimal('total_price', 15, 2);
            $table->string('payment_method')->nullable();
            
            // Statuses
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'expired'])->default('pending');
            $table->enum('delivery_status', ['pending', 'processing', 'success', 'failed'])->default('pending');
            
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
