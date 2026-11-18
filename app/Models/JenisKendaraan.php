<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisKendaraan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jenis_kendaraans';

    protected $fillable = [
        'nama_jenis',
    ];

    public function kendaraan(): HasMany
    {
        return $this->hasMany(Kendaraan::class);
    }

    public function tarif(): HasMany
    {
        return $this->hasMany(Tarif::class);
    }
}
