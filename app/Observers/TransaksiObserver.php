<?php

namespace App\Observers;

use App\Models\LogAktivitas;
use App\Models\Transaksi;

class TransaksiObserver
{
    /**
     * Handle the Transaksi "created" event.
     */
    public function created(Transaksi $transaksi): void
    {
        //
        LogAktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Kendaraan masuk: '.$transaksi->kendaraan->plat_nomor,
            'waktu_aktivitas' => now(),
        ]);
    }

    /**
     * Handle the Transaksi "updated" event.
     */
    public function updated(Transaksi $transaksi): void
    {
        //
        if ($transaksi->wasChanged('status') && $transaksi->status === 'selesai') {
            LogAktivitas::create([
                'user_id' => auth()->id(),
                'aktivitas' => 'Kendaraan Keluar: '.$transaksi->kendaraan->plat_nomor,
                'waktu_aktivitas' => now(),
            ]);
        }
    }

    /**
     * Handle the Transaksi "deleted" event.
     */
    public function deleted(Transaksi $transaksi): void
    {
        //
    }

    /**
     * Handle the Transaksi "restored" event.
     */
    public function restored(Transaksi $transaksi): void
    {
        //
    }

    /**
     * Handle the Transaksi "force deleted" event.
     */
    public function forceDeleted(Transaksi $transaksi): void
    {
        //
    }
}
