<div class="flex flex-wrap items-center gap-2">

    @if ($row->is_active)

    {{-- Deactivate --}}
    <button
        type="button"
        wire:click="$dispatch('toggleProductStatus', { productId: {{ $row->id }} })"
        wire:confirm="Are you sure you want to deactivate this product?"
        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-red-700 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 hover:border-red-300 transition"
        title="Deactivate product">
        <span>⏸</span>
        <span>Deactivate</span>
    </button>

    @else

    {{-- Activate --}}
    <button
        type="button"
        wire:click="$dispatch('toggleProductStatus', { productId: {{ $row->id }} })"
        wire:confirm="Are you sure you want to activate this product?"
        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-green-700 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 hover:border-green-300 transition"
        title="Activate product">
        <span>✓</span>
        <span>Activate</span>
    </button>

    @endif


    {{-- Delete --}}
    <button
        type="button"
        wire:click="$dispatch('deleteProduct', { productId: {{ $row->id }} })"
        wire:confirm="Are you sure you want to permanently delete this product?"
        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-gray-700 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 hover:border-gray-300 transition"
        title="Delete product">
        <span>🗑</span>
        <span>Delete</span>
    </button>

</div>