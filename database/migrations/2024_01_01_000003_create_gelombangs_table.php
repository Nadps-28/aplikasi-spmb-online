<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('gelombangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gelombangs');
    }
};