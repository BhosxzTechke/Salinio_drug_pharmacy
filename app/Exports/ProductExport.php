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
    return Product::select(
        'product_name',
        'product_code',
        'category_id',
        'subcategory_id',
        'brand_id',
        'description',
        'dosage_form',
        'target_gender',
        'age_group',
        'health_concern',
        'selling_price',
        'has_expiration',
        'prescription_required',
        'product_image',
        'created_at',
        'updated_at'
    )->get();
}

public function headings(): array
{
    return [
        'Product Name',
        'Product Code',
        'Category ID',
        'Subcategory ID',
        'Brand ID',
        'Description',
        'Dosage Form',
        'Target Gender',
        'Age Group',
        'Health Concern',
        'Selling Price',
        'Has Expiration',
        'Prescription Required',
        'Product Image',
        'Created At',
        'Updated At',
    ];
}
}
