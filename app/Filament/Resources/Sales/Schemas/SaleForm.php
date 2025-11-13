<?php

namespace App\Filament\Resources\Sales\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms;
use App\Models\Product;

class SaleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Forms\Components\Builder::make('items')
                    ->label('Keranjang Belanja')
                    ->blocks([
                        Forms\Components\Builder\Block::make('item')
                            ->schema([
                                Forms\Components\Select::make('product_id')
                                    ->label('Produk')
                                    ->options(Product::pluck('name', 'id'))
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, $set, $get) {
                                        $product = Product::find($state);
                                        $set('price', $product?->price ?? 0);
                                        $set('subtotal', ($product?->price ?? 0) * ($get('qty') ?? 1));
                                    })
                                    ->columnSpan(6),

                                Forms\Components\TextInput::make('qty')
                                    ->label('Qty')
                                    ->numeric()
                                    ->default(1)
                                    ->live()
                                    ->afterStateUpdated(function ($state, $set, $get) {
                                        $set('subtotal', ($get('price') ?? 0) * ($state ?? 1));
                                    })
                                    ->columnSpan(2),

                                Forms\Components\TextInput::make('price')
                                    ->label('Harga')
                                    ->numeric()
                                    ->live()
                                    ->afterStateUpdated(function ($state, $set, $get) {
                                        $set('subtotal', ($get('qty') ?? 0) * ($state ?? 1));
                                    })
                                    ->columnSpan(4),

                                Forms\Components\TextInput::make('subtotal')
                                    ->label('Subtotal')
                                    ->numeric()
                                    ->disabled()
                                    ->columnSpan(4),
                            ])
                            ->columns(12),
                    ]),

                Forms\Components\TextInput::make('total')
                    ->label('Total')
                    ->numeric()
                    ->disabled(),

                Forms\Components\TextInput::make('paid')
                    ->label('Dibayar')
                    ->numeric()
                    ->live(),

                Forms\Components\TextInput::make('change')
                    ->label('Kembalian')
                    ->numeric()
                    ->disabled(),

            ])
            ->columns(1);
    }
}
