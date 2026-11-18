<?php

namespace App\Filament\Resources\Transaksis\Schemas;

use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class TransaksiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('kendaraan_id')
                    ->relationship('kendaraan', 'plat_nomor')
                    ->searchable()
                    ->required(),

                Select::make('area_parkir_id')
                    ->relationship('areaParkir', 'nama_area')
                    ->searchable()
                    ->required(),
            ]);
    }
}
