<?php

namespace App\Filament\Resources\Kendaraans\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KendaraanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                Select::make('jenis_kendaraan_id')
                    ->relationship('jenisKendaraan', 'nama_jenis')
                    ->required(),
                TextInput::make('plat_nomor')
                    ->unique()
                    ->required(),
                TextInput::make('merk')
                    ->required(),
                TextInput::make('tipe')
                    ->required(),
                TextInput::make('warna')
                    ->required(),
            ]);
    }
}
