<!-- resources/views/livewire/go-to-checkout.blade.php -->
<button
    wire:click="goToCheckout"
    wire:loading.attr="disabled"
    wire:target="goToCheckout"
    data-show-loader
    class="w-full py-3 mt-6 flex items-center justify-center gap-2 cursor-pointer bg-blue-600 text-white font-medium hover:bg-blue-700 transition rounded-lg disabled:opacity-50 disabled:cursor-not-allowed"
>
    <span wire:loading.remove wire:target="goToCheckout">Proceed to Checkout</span>

    <span wire:loading wire:target="goToCheckout" class="flex items-center gap-2">
        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
        Processing...
    </span>
</button>
