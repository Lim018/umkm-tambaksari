<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Badge popularitas per menu menghitung ulang tiap kali halaman toko dibuka,
     * jadi hitungan per menu butuh indeksnya sendiri.
     */
    public function up(): void
    {
        Schema::table('contact_events', function (Blueprint $table) {
            $table->index(['menu_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::table('contact_events', function (Blueprint $table) {
            $table->dropIndex(['menu_id', 'created_at']);
        });
    }
};
