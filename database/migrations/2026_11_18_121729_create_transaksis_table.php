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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kendaraan_id')
                ->constrained('kendaraan')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->dateTime('waktu_masuk');
            $table->dateTime('waktu_keluar');

            $table->foreignId('tarif_id')
                ->constrained('tarif')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->integer('durasi_jam');
            $table->decimal('biaya_total', 10, 2);
            $table->enum('status', ['waktu_masuk', 'waktu_keluar']);

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete()
                ->cascadeOnDelete();
            $table->foreignId('area_parkir_id')
                ->constrained('area_parkir')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
