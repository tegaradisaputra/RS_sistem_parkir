<?php

namespace App\Filament\Resources\Transaksis\Tables;

use App\Models\Transaksi;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class TransaksisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kendaraan.plat_nomor')
                    ->label('Plat Nomor'),

                TextColumn::make('areaParkir.nama_area')
                    ->label('Area'),

                TextColumn::make('waktu_masuk')
                    ->dateTime(),

                TextColumn::make('waktu_keluar')
                    ->dateTime()
                    ->placeholder('Belum keluar'),

                TextColumn::make('durasi_jam'),

                TextColumn::make('status')
                    ->badge(),

                TextColumn::make('biaya_total')
                    ->numeric(decimalPlaces: 2)
                    ->placeholder('Belum dihitung'),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('checkout')
                    ->label('Check-out')
                    ->requiresConfirmation()
                    ->visible(fn (Transaksi $record): bool => $record->status === 'aktif')
                    ->action(function (Transaksi $record): void {
                        $waktuKeluar = now();
                        $durasiJam = max(
                            1,
                            (int) ceil($record->waktu_masuk->diffInSeconds($waktuKeluar) / 3600),
                        );

                        $record->update([
                            'waktu_keluar' => $waktuKeluar,
                            'durasi_jam' => $durasiJam,
                            'biaya_total' => $durasiJam * (float) $record->tarif_per_jam,
                            'status' => 'selesai'
                        ]);
                    }),
                Action::make('cetakStruk')
                    ->label('Cetak Struk')
                    ->url(fn(Transaksi $record): string => route(
                        'transaksi.struk',
                        ['transaksi' => $record]
                    ))
                    ->openUrlInNewTab(),
            ]);
    }
}
