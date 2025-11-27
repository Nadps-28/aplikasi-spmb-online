<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            // Add new timestamp fields for tracking
            $table->timestamp('verified_at')->nullable()->after('catatan_verifikasi');
            $table->unsignedBigInteger('verified_by')->nullable()->after('verified_at');
            $table->timestamp('payment_verified_at')->nullable()->after('verified_by');
            $table->unsignedBigInteger('payment_verified_by')->nullable()->after('payment_verified_at');
            $table->timestamp('graduated_at')->nullable()->after('payment_verified_by');
            $table->unsignedBigInteger('graduated_by')->nullable()->after('graduated_at');
            
            // Add foreign key constraints
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('payment_verified_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('graduated_by')->references('id')->on('users')->onDelete('set null');
        });
        
        // Update existing status values to match new flow
        DB::statement("UPDATE pendaftarans SET status = 'draft' WHERE status = 'draft'");
        DB::statement("UPDATE pendaftarans SET status = 'submitted' WHERE status = 'dikirim'");
        DB::statement("UPDATE pendaftarans SET status = 'valid' WHERE status = 'verifikasi_admin'");
        DB::statement("UPDATE pendaftarans SET status = 'lunas' WHERE status = 'terbayar'");
        DB::statement("UPDATE pendaftarans SET status = 'lulus' WHERE status = 'lulus'");
        DB::statement("UPDATE pendaftarans SET status = 'tidak_valid' WHERE status = 'ditolak'");
    }

    public function down()
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropForeign(['payment_verified_by']);
            $table->dropForeign(['graduated_by']);
            
            $table->dropColumn([
                'verified_at',
                'verified_by',
                'payment_verified_at',
                'payment_verified_by',
                'graduated_at',
                'graduated_by'
            ]);
        });
        
        // Revert status values
        DB::statement("UPDATE pendaftarans SET status = 'dikirim' WHERE status = 'submitted'");
        DB::statement("UPDATE pendaftarans SET status = 'verifikasi_admin' WHERE status = 'valid'");
        DB::statement("UPDATE pendaftarans SET status = 'terbayar' WHERE status = 'lunas'");
        DB::statement("UPDATE pendaftarans SET status = 'ditolak' WHERE status = 'tidak_valid'");
    }
};