<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE berkas MODIFY COLUMN jenis ENUM('ijazah', 'rapor', 'kip', 'kks', 'akta', 'kk', 'pas_foto')");
    }

    public function down()
    {
        DB::statement("ALTER TABLE berkas MODIFY COLUMN jenis ENUM('ijazah', 'rapor', 'kip', 'kks', 'akta', 'kk')");
    }
};