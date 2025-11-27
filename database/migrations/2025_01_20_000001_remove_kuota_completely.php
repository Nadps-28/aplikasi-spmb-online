<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jurusans', function (Blueprint $table) {
            if (Schema::hasColumn('jurusans', 'kuota')) {
                $table->dropColumn('kuota');
            }
        });
    }

    public function down(): void
    {
        Schema::table('jurusans', function (Blueprint $table) {
            $table->integer('kuota')->after('nama')->default(36);
        });
    }
};