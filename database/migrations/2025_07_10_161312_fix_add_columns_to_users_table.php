<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixAddColumnsToUsersTable extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hanya tambahkan jika kolom belum ada
            if (!Schema::hasColumn('users', 'nip')) {
                $table->string('nip')->unique()->after('name');
            }
            
            if (!Schema::hasColumn('users', 'jabatan')) {
                $table->string('jabatan')->nullable()->after('nip');
            }
            
            if (!Schema::hasColumn('users', 'unit_kerja')) {
                $table->string('unit_kerja')->nullable()->after('jabatan');
            }
        });
    }

    public function down(): void
    {
        // Tidak perlu drop column di down untuk perbaikan
    }
}