<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->time('opening_time')->nullable()->after('description');
            $table->time('closing_time')->nullable()->after('opening_time');
            // Nomor hari ISO yang toko libur: 1 = Senin ... 7 = Minggu.
            $table->json('closed_days')->nullable()->after('closing_time');
        });
    }

    public function down(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->dropColumn(['opening_time', 'closing_time', 'closed_days']);
        });
    }
};
