<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('berkas', function (Blueprint $table) {
            $table->dropColumn('jenis');
        });
        
        Schema::table('berkas', function (Blueprint $table) {
            $table->enum('jenis', ['ijazah', 'rapor', 'kip', 'kks', 'akta', 'kk', 'ktp_ortu'])->after('pendaftaran_id');
        });
    }

    public function down()
    {
        Schema::table('berkas', function (Blueprint $table) {
            $table->dropColumn('jenis');
        });
        
        Schema::table('berkas', function (Blueprint $table) {
            $table->enum('jenis', ['ijazah', 'rapor', 'kip', 'kks', 'akta', 'kk'])->after('pendaftaran_id');
        });
    }
};