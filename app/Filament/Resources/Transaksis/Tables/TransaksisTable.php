<?php

namespace App\Filament\Resources\Transaksis\Tables;

use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class TransaksisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                TrashedFilter::make(),
            ]);
    }
}
