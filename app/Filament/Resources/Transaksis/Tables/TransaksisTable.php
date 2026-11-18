<?php

namespace App\Filament\Resources\Transaksis\Tables;

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

                TextColumn::make('status')
                    ->badge(),

                TextColumn::make('biaya_total')
                    ->numeric(decimalPlaces: 2)
                    ->placeholder('Belum dihitung'),
            ])
            ->filters([
                TrashedFilter::make(),
            ]);
    }
}
