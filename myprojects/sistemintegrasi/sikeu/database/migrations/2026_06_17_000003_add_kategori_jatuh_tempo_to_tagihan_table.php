<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('sikeu')->table('tagihan', function (Blueprint $table) {
            $table->string('kategori')->nullable()->after('periode');
            $table->date('tanggal_jatuh_tempo')->nullable()->after('total_tagihan');
        });
    }

    public function down(): void
    {
        Schema::connection('sikeu')->table('tagihan', function (Blueprint $table) {
            $table->dropColumn(['kategori', 'tanggal_jatuh_tempo']);
        });
    }
};