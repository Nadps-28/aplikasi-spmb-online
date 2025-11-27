<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained();
            $table->decimal('nominal', 10, 2);
            $table->string('bukti_bayar')->nullable();
            $table->enum('status', ['pending', 'terbayar', 'ditolak'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamp('tanggal_bayar')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pembayarans');
    }
};