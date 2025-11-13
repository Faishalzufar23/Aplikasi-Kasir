<?php

namespace App\Filament\Resources\Sales\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class SalesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('No')->sortable(),
                TextColumn::make('total')->label('Total')->money('idr'),
                TextColumn::make('paid')->label('Dibayar')->money('idr'),
                TextColumn::make('change')->label('Kembalian')->money('idr'),
                TextColumn::make('created_at')->label('Tanggal')->dateTime('d M Y H:i'),
            ]);
    }
}
