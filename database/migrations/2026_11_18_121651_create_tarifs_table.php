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
        Schema::create('tarifs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('jenis_kendaraan_id')
            ->constrained('jenis_kendaraans')
            ->restrictOnDelete()
            ->cascadeOnUpdate();

            $table->decimal('tarif_per_jam', 10, 2);
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarifs');
    }
};
