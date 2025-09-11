<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('setorans', function (Blueprint $table) {
            $table->id('id');
            $table->date('tanggal_setoran');
            $table->foreignId('sampah_id')->constrained()->onDelete('cascade');
            $table->decimal('berat_setor', 8, 2);
            $table->decimal('jumlah_uang', 10, 2); // = berat * harga
            $table->foreignId('nasabah_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setorans');
    }
};
