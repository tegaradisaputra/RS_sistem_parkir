<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tarif extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tarifs';

    protected $fillable = [
        'jenis_kendaraan_id',
        'tarif_per_jam',
    ];

    protected function casts(): array
    {
        return [
            'tarif_per_jam' => 'decimal:2',
        ];
    }

    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class);
    }

    public function jenisKendaraan(): BelongsTo
    {
        return $this->belongsTo(JenisKendaraan::class);
    }
}
