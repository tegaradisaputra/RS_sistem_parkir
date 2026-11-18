<?php

namespace App\Filament\Resources\AreaParkirs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AreaParkirForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                TextInput::make('nama_area')
                    ->unique()
                    ->required(),
                TextInput::make('kapasitas')
                    ->integer()
                    ->minValue(1)
                    ->required()
            ]);
    }
}
