<?php

namespace App\Filament\Resources\Sales\Pages;

use App\Filament\Resources\Sales\SaleResource;
use App\Models\Product;
use App\Models\SaleItem;
use Filament\Resources\Pages\CreateRecord;

class CreateSale extends CreateRecord
{
    protected static string $resource = SaleResource::class;

    /**
     * Hitung total & change sebelum menyimpan record sale.
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $items = $data['items'] ?? [];
        $total = collect($items)->sum(fn ($i) => ($i['subtotal'] ?? (($i['qty'] ?? 0) * ($i['price'] ?? 0))));
        $data['total'] = $total;
        $data['change'] = ($data['paid'] ?? 0) - $total;

        return $data;
    }

    /**
     * Setelah sale dibuat, simpan sale items dan kurangi stok produk.
     */
    protected function afterCreate(): void
    {
        $items = $this->data['items'] ?? [];

        foreach ($items as $item) {
            // pastikan struktur item valid
            if (empty($item['product_id'])) {
                continue;
            }

            SaleItem::create([
                'sale_id' => $this->record->id,
                'product_id' => $item['product_id'],
                'qty' => $item['qty'] ?? 1,
                'price' => $item['price'] ?? 0,
                'subtotal' => $item['subtotal'] ?? (($item['qty'] ?? 0) * ($item['price'] ?? 0)),
            ]);

            // kurangi stok produk (hati-hati negative stock)
            $product = Product::find($item['product_id']);
            if ($product) {
                $decrement = (int) ($item['qty'] ?? 0);
                if ($decrement > 0) {
                    $product->decrement('stock', $decrement);
                }
            }
        }
    }
}
