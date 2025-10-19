<?php

namespace App\Http\Livewire;

use Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Gloudemans\Shoppingcart\Facades\Cart;



class GoToCheckout extends Component
{

public function goToCheckout()
{
    if (Cart::instance('ecommerce')->count() === 0) {
        $this->dispatchBrowserEvent('notify', [
            'type' => 'error',
            'message' => 'Your cart is empty.'
        ]);

        return $this->redirect(route('cart.show')); // cart page instead of payment

    }

    if (!auth('customer')->check()) {
        $this->dispatchBrowserEvent('notify', [
            'type' => 'error',
            'message' => 'Please login to proceed to checkout.'
        ]);

        return $this->redirect(route('customer.login')); // redirect to login
    }

    // If cart is not empty and user is logged in
    return $this->redirect(route('cart.payment'));
}




    
    public function render()
    {
        return view('livewire.go-to-checkout');
    }
}
