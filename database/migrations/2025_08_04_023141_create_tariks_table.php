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
        Schema::create('tariks', function (Blueprint $table) {
            $table->id('id');
            $table->date('tanggal_tarik');
            $table->decimal('jumlah_uang_tarik', 10, 2);
            $table->foreignId('nasabah_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tariks');
    }
};
