<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Counter</h1>
    <div class="flex items-center space-x-4">
        <!-- Tombol Increment -->
        <button 
            wire:click="increment" 
            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition"
        >
            Increment (+)
        </button>
        
        <!-- Display Counter -->
        <span class="text-xl font-medium">{{ $count }}</span>
    </div>
</div>