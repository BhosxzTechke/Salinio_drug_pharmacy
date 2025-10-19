<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::select( 'product_name', 'category_id', 'supplier_id', 'product_code','product_garage',
        'product_image','product_store','buying_date','expire_date','buying_price','selling_price')->get();
    }

    public function headings(): array
    {
        return [
            'Product Name',
            'Category ID',
            'Supplier ID',
            'Product Code',
            'Product Garage',
            'Product Image',
            'Product Store',
            'Buying Date',
            'Expire Date',
            'Buying Price',
            'Selling Price',
        ];
    }
}
