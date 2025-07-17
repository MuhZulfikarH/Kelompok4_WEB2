<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('balasan_komplains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('komplain_id')->constrained('komplains')->onDelete('cascade');
            $table->text('isi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('balasan_komplains');
    }
};
