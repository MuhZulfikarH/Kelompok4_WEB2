<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->datetime('tanggal');
            $table->enum('status', ['pending', 'diproses', 'selesai'])->default('pending');
            $table->string('alamat_pengiriman', 255); 
            $table->decimal('total_harga', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pesanans');
    }
};
