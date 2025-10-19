<div>
    <!-- Fullscreen Overlay -->
    <div id="global-loader"
         class="hidden fixed inset-0 z-[9999] flex items-center justify-center bg-black bg-opacity-60"
         style="display:none; pointer-events:none;">
        <div class="flex flex-col items-center">
            <svg class="animate-spin h-14 w-14 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            <p class="text-white mt-4 text-lg font-semibold">Processing...</p>
        </div>
    </div>

    <!-- Loader Script -->
 <script>
document.addEventListener('DOMContentLoaded', function () {
    const loader = document.getElementById('global-loader');

    function showLoader() {
        loader.style.display = 'flex';
        loader.classList.remove('hidden');
        loader.style.pointerEvents = 'auto';
    }

    function hideLoader() {
        setTimeout(() => {
            loader.style.display = 'none';
            loader.classList.add('hidden');
            loader.style.pointerEvents = 'none';
        }, 150);
    }

    // Livewire Hooks
    document.addEventListener('livewire:load', function () {
        Livewire.hook('message.sent', () => showLoader());
        Livewire.hook('message.processed', () => hideLoader());
        Livewire.hook('message.failed', () => hideLoader());
    });

    // Manual Trigger from Buttons
    document.addEventListener('click', (e) => {
        if (e.target.closest('[data-show-loader]')) {
            showLoader();
        }
    });

    // 🔥 Listen for manual hide event
    document.addEventListener('hide-global-loader', hideLoader);
});
</script>



</div>
