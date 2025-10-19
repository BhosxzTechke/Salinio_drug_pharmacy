<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
class ProductImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

                return new Product([
                    'product_name'     => $row['product_name'],
                    'category_id'      => $row['category_id'],
                    'supplier_id'      => $row['supplier_id'],
                    'product_code'     => $row['product_code'],
                    'product_garage'   => $row['product_garage'],
                    'product_image'    => $row['product_image'],
                    'product_store'    => $row['product_store'],
                    'buying_date'      => $row['buying_date'],
                    'expire_date'      => $row['expire_date'],
                    'buying_price'     => $row['buying_price'],
                    'selling_price'    => $row['selling_price'],
                ]);
    }

                public function rules(): array
            {
                return [
                    '*.product_name' => 'required|string',
                    '*.product_code' => 'required|unique:products,product_code',
                    '*.buying_price' => 'required|numeric',
                    '*.selling_price' => 'required|numeric',
                    // Add more as needed
                ];
            }
}
