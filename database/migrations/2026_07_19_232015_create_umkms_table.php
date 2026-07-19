<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('umkms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('kelurahan');
            $table->string('price_range');                 // "Rp 15rb–40rb"
            $table->string('photo_path')->nullable();
            $table->string('pastel_bg')->default('linear-gradient(135deg,#EDE9FE,#F5F0FF)');
            $table->string('whatsapp');                    // 62...
            $table->string('shopee_url')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_bestseller')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('umkms');
    }
};
