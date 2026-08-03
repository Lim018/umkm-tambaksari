<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_id')->constrained('umkms')->cascadeOnDelete();
            $table->foreignId('menu_id')->nullable()->constrained('menus')->nullOnDelete();
            $table->string('channel', 20);          // whatsapp | shopee
            $table->string('source', 20);           // toko | menu
            $table->string('visitor_hash', 64);     // sha256 dengan rotasi harian, bukan PII
            $table->timestamps();

            $table->index(['umkm_id', 'created_at']);
            $table->index(['channel', 'created_at']);
            $table->index(['visitor_hash', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_events');
    }
};
