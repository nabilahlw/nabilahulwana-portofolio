<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('siakad')->table('mahasiswa', function (Blueprint $table) {
            $table->enum('gender', ['L', 'P'])->nullable()->after('nama');
        });
    }

    public function down(): void
    {
        Schema::connection('siakad')->table('mahasiswa', function (Blueprint $table) {
            $table->dropColumn('gender');
        });
    }
};