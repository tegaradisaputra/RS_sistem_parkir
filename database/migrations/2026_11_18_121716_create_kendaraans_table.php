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
        Schema::create('kendaraans', function (Blueprint $table) {
            $table->id();
            $table->string('plat_nomor')->unique(); // menghindari duplikat

            $table->foreignId('jenis_kendaraan_id')
                ->constrained('jenis_kendaraan')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->string('merk');
            $table->string('tipe');
            $table->string('warna');
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraans');
    }
};
