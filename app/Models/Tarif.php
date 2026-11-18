<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Override;

class Tarif extends Model
{
    //
    use HasFactory, SoftDeletes;

    protected $table = 'tarif';

    protected $fillable = [
        'jenis_kendaraan_id',
        'tarif_per_jam'
    ];

    #[Override]
    protected function casts()
    {
        return [
            'tarif_per_jam' => 'decimal:2'
        ];
    }

    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class);
    }

    public function jenis_kendaraan(): BelongsTo
    {
        return $this->belongsTo(JenisKendaraan::class);
    }
}
