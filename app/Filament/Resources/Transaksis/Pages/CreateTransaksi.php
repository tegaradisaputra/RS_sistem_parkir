<?php

namespace App\Filament\Resources\Transaksis\Pages;

use App\Filament\Resources\Transaksis\TransaksiResource;
use App\Models\AreaParkir;
use App\Models\Kendaraan;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;
use Override;

class CreateTransaksi extends CreateRecord
{
    protected static string $resource = TransaksiResource::class;

    #[Override]
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $kendaraan = Kendaraan::query()
            ->with('jenisKendaraan.tarif')
            ->findOrFail($data['kendaraan_id']);

        if ($kendaraan->transaksi()->where('status', 'aktif')->exists()) {
            throw ValidationException::withMessages([
                'data.kendaraan_id' => 'Kendaraan ini masih tercatat parkir',
            ]);
        }

        $tarif = $kendaraan->jenisKendaraan?->tarif;

        if ($tarif === null) {
            throw ValidationException::withMessages([
                'data.kendaraan_id' => 'jenis kendaraan ini belum memiliki tarif.',
            ]);
        }

        $areaParkir = AreaParkir::findOrFail($data['area_parkir_id']);

        $jumlahTerisi = $areaParkir->transaksi()
            ->where('status', 'aktif')
            ->count();

        if ($jumlahTerisi >= $areaParkir->kapasitas) {
            throw ValidationException::withMessages([
                'data.area_parkir_id' => 'Area parkir sudah penuh.',
            ]);
        }

        $data['waktu_masuk'] = now();
        $data['waktu_keluar'] = null;
        $data['tarif_id'] = $tarif->id;
        $data['tarif_per_jam'] = $tarif->tarif_per_jam;
        $data['durasi_jam'] = null;
        $data['biaya_total'] = null;
        $data['status'] = 'aktif';
        $data['user_id'] = auth()->id();

        return $data;
    }
}
