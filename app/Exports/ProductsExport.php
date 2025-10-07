<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Product::with(['translations', 'prices'])->get();
    }

    public function map($product): array
    {
        // نجيب الترجمات (مثلاً عربى وإنجليزى)
        $name_ar = $product->translations->where('locale', 'ar')->first()->name ?? '';
        $name_en = $product->translations->where('locale', 'en')->first()->name ?? '';
        $desc_ar = $product->translations->where('locale', 'ar')->first()->description ?? '';
        $desc_en = $product->translations->where('locale', 'en')->first()->description ?? '';

        // السعر الحالي فقط
        $currentPrice = $product->prices->whereNull('end_date')->first();

        return [
            $product->id,
            $name_ar,
            $name_en,
            $desc_ar,
            $desc_en,
            $currentPrice?->purchase_price ?? '',
            $currentPrice?->sale_price ?? '',
            $currentPrice?->start_date ?? '',
            $currentPrice?->end_date ?? '',
        ];
    }

    public function headings(): array
    {
        return [
            'Product ID',
            'Name (ar)',
            'Name (en)',
            'Description (ar)',
            'Description (en)',
            'Purchase Price',
            'Sale Price',
            'Start Date',
            'End Date',
        ];
    }
}
