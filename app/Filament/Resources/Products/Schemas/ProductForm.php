<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->label('Nama Produk')
                    ->required(),

                TextInput::make('price')
                    ->label('Harga')
                    ->numeric()
                    ->required(),

                TextInput::make('stock')
                    ->label('Stok')
                    ->numeric()
                    ->minValue(0)
                    ->required(),

                // ➕ Upload Gambar
                FileUpload::make('image')
                    ->label('Gambar Produk')
                    ->image()
                    ->directory('products') // folder penyimpanan di storage/app/public/products
                    ->maxSize(2048), // max 2MB
            ]);
    }
}
