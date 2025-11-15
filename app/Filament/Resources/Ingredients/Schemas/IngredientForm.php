<?php

namespace App\Filament\Resources\Ingredients\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;

class IngredientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nama Bahan Baku')
                ->required(),

            Forms\Components\Select::make('unit')
                ->label('Satuan')
                ->required()
                ->options([
                    'gram' => 'Gram',
                    'ml'   => 'Mili Liter',
                    'pcs'  => 'Pcs',
                ]),

            Forms\Components\TextInput::make('stock')
                ->label('Stok')
                ->numeric()
                ->default(0),
        ]);

    }
}
