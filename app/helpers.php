<?php

namespace App\Support;

use Gloudemans\Shoppingcart\Cart as BaseCart;

class InclusiveCart extends BaseCart
{
    public function tax($decimals = null, $decimalSeparator = null, $thousandSeparator = null)
    {
        $subTotal = (float) str_replace(',', '', $this->subtotal());
        $rate = config('cart.tax');
        return round($subTotal * ($rate / (100 + $rate)), 2);
    }

    public function total($decimals = null, $decimalSeparator = null, $thousandSeparator = null)
    {
        return $this->subtotal($decimals, $decimalSeparator, $thousandSeparator);
    }
}






// if (!function_exists('getVatBreakdown')) {
//     function getVatBreakdown($inclusiveAmount, $vatPercent = 12)
//     {
//         $vatRate = $vatPercent / 100;
//         $vatable = $inclusiveAmount / (1 + $vatRate);
//         $vat = $inclusiveAmount - $vatable;

//         return [
//             'inclusive' => round($inclusiveAmount, 2),
//             'vatable' => round($vatable, 2),
//             'vat' => round($vat, 2),
//             'percent' => $vatPercent
//         ];
//     }
// }
