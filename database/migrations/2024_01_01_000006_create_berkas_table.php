<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('berkas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained();
            $table->enum('jenis', ['ijazah', 'rapor', 'kip', 'kks', 'akta', 'kk']);
            $table->string('nama_file');
            $table->string('path_file');
            $table->enum('status', ['pending', 'diterima', 'ditolak'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('berkas');
    }
};