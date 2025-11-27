<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pendaftaran')->unique();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('jurusan_id')->constrained();
            $table->foreignId('gelombang_id')->constrained();
            $table->string('nik', 16);
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('agama');
            $table->text('alamat');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('kodepos');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('asal_sekolah');
            $table->string('nama_ayah');
            $table->string('pekerjaan_ayah');
            $table->string('nama_ibu');
            $table->string('pekerjaan_ibu');
            $table->string('nama_wali')->nullable();
            $table->string('pekerjaan_wali')->nullable();
            $table->string('phone_ortu');
            $table->enum('status', ['draft', 'dikirim', 'verifikasi_admin', 'menunggu_bayar', 'terbayar', 'verifikasi_keuangan', 'lulus', 'tidak_lulus', 'cadangan'])->default('draft');
            $table->text('catatan_verifikasi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pendaftarans');
    }
};