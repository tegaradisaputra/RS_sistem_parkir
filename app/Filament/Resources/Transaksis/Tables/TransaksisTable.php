<?php

namespace App\Filament\Resources\Transaksis\Tables;

use App\Models\Transaksi;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

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
                Filter::make('periode_checkout')
                    ->label('Rekap berdasarkan tanggal keluar')
                    ->schema([
                        DatePicker::make('tanggal_mulai')
                            ->label('Dari tanggal')
                            ->required(),
                        DatePicker::make('tanggal_akhir')
                            ->label('Sampai tanggal')
                            ->required(),
                    ])
                    ->visible(fn (): bool => auth()->user()?->isOwner() ?? false)
                    ->query(function (Builder $query, array $data): Builder {
                        $tanggalMulai = $data['tanggal_mulai'] ?? null;
                        $tanggalAkhir = $data['tanggal_akhir'] ?? null;

                        if (blank($tanggalMulai) || blank($tanggalAkhir)) {
                            return $query;
                        }

                        return $query
                            ->where('status', 'selesai')
                            ->whereNotNull('waktu_keluar')
                            ->where('waktu_keluar', '>=', Carbon::parse($tanggalMulai)->startOfDay())
                            ->where('waktu_keluar', '<',
                                Carbon::parse($tanggalAkhir)->addDay()->startOfDay());
                    }),
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
                            'status' => 'selesai',
                        ]);
                    }),
                Action::make('cetakStruk')
                    ->label('Cetak Struk')
                    ->url(fn (Transaksi $record): string => route(
                        'transaksi.struk',
                        ['transaksi' => $record]
                    ))
                    ->openUrlInNewTab(),
            ]);
    }
}
