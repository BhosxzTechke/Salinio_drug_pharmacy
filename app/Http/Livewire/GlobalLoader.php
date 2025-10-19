<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;


class GlobalLoader extends Component
{


    public function render()
    {
        return view('livewire.global-loader');
    }
}
