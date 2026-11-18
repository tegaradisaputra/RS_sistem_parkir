<?php

namespace App\Filament\Resources\JenisKendaraans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class JenisKendaraanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_jenis')
                    ->required()
                    ->unique(),
            ]);
    }
}
