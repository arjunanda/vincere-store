<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Categories (Fungsi sebagai Tipe Layanan: Top-up, Voucher, dll)
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: Top-up, Voucher, Jasa Joki
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // 2. Input Groups (Master Data Template Input)
        Schema::create('input_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: "Format MLBB (ID + Zone)", "Format Global (User ID Only)"
            $table->timestamps();
        });

        // 3. Input Fields (Isi Detail dari Group)
        Schema::create('input_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('input_group_id')->constrained()->onDelete('cascade');
            $table->string('label'); // Contoh: User ID
            $table->string('name'); // Key: user_id
            $table->string('placeholder')->nullable();
            $table->string('type')->default('text'); // text, number, select
            $table->timestamps();
        });

        // 4. Games
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Link ke Tipe Layanan
            $table->foreignId('input_group_id')->nullable()->constrained()->onDelete('set null'); // Link ke Master Input
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('image');
            $table->string('banner_image')->nullable();
            $table->enum('platform_type', ['mobile', 'pc', 'console', 'others'])->default('mobile');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 5. Game Variants (List Harga / Item)
        Schema::create('game_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->string('name'); 
            $table->decimal('price', 15, 2);
            $table->decimal('original_price', 15, 2)->nullable(); 
            $table->string('provider_id')->nullable(); 
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_variants');
        Schema::dropIfExists('games');
        Schema::dropIfExists('input_fields');
        Schema::dropIfExists('input_groups');
        Schema::dropIfExists('categories');
    }
};
