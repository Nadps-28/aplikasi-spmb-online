<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Modify the enum column first to allow new values
        DB::statement("ALTER TABLE pembayarans MODIFY COLUMN status ENUM('pending', 'terbayar', 'ditolak', 'verified', 'rejected') DEFAULT 'pending'");
        
        // Update existing data
        DB::table('pembayarans')->where('status', 'terbayar')->update(['status' => 'verified']);
        DB::table('pembayarans')->where('status', 'ditolak')->update(['status' => 'rejected']);
        
        // Remove old enum values
        DB::statement("ALTER TABLE pembayarans MODIFY COLUMN status ENUM('pending', 'verified', 'rejected') DEFAULT 'pending'");
    }

    public function down(): void
    {
        // Revert data
        DB::table('pembayarans')->where('status', 'verified')->update(['status' => 'terbayar']);
        DB::table('pembayarans')->where('status', 'rejected')->update(['status' => 'ditolak']);
        
        // Revert enum
        DB::statement("ALTER TABLE pembayarans MODIFY COLUMN status ENUM('pending', 'terbayar', 'ditolak') DEFAULT 'pending'");
    }
};