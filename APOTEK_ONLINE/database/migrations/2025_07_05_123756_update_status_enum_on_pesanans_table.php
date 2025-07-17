<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE pesanans MODIFY status ENUM('pending', 'diproses', 'selesai', 'dibatalkan') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE pesanans MODIFY status ENUM('pending', 'diproses', 'selesai') NOT NULL");
    }
};
