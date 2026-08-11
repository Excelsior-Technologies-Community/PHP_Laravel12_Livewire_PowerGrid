<div class="flex items-center gap-2">

    @if ($row->is_active)

        <button
            type="button"
            wire:click="$dispatch('toggleProductStatus', { productId: {{ $row->id }} })"
            wire:confirm="Are you sure you want to deactivate this product?"
            class="px-3 py-1 text-sm font-medium text-white bg-red-600 rounded hover:bg-red-700"
        >
            ❌ Deactivate
        </button>

    @else

        <button
            type="button"
            wire:click="$dispatch('toggleProductStatus', { productId: {{ $row->id }} })"
            wire:confirm="Are you sure you want to activate this product?"
            class="px-3 py-1 text-sm font-medium text-white bg-green-600 rounded hover:bg-green-700"
        >
            ✅ Activate
        </button>

    @endif

</div>