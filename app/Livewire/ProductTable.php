<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class ProductTable extends PowerGridComponent
{
    public string $tableName = 'products';

    public string $stockStatus = '';

    public function setUp(): array
    {
        return [
            PowerGrid::header()
                ->showSearchInput()
                ->showToggleColumns(),

            PowerGrid::footer()
                ->showPerPage(10, [5, 10, 25, 50])
                ->showRecordCount(),
        ];
    }

    public function datasource(): ?Builder
    {
        $query = Product::query();

        return $query->toBase();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('description')

            ->add('price', function ($product) {
                return '$ ' . number_format($product->price, 2);
            })

            ->add('stock')

            ->add('stock_status', function ($product) {
                if ($product->stock == 0) {
                    return '⚫ Out of Stock';
                }

                if ($product->stock <= 2) {
                    return '🔴 Critical';
                }

                if ($product->stock <= 10) {
                    return '🟡 Low Stock';
                }

                return '🟢 In Stock';
            })

            ->add('category')

            ->add('is_active', function ($product) {
                return $product->is_active
                    ? '✅ Active'
                    : '❌ Inactive';
            })

            ->add('created_at_formatted', function ($product) {
                return Carbon::parse($product->created_at)
                    ->format('d/m/Y');
            })

            ->add('actions', function ($product) {
                return view('livewire.product-actions', [
                    'row' => $product,
                ])->render();
            });
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),

            Column::make('Name', 'name')
                ->searchable()
                ->sortable(),

            Column::make('Description', 'description')
                ->searchable(),

            Column::make('Price', 'price')
                ->searchable()
                ->sortable(),

            Column::make('Stock', 'stock')
                ->searchable()
                ->sortable(),

            Column::make('Stock Status', 'stock_status')
                ->searchable(),

            Column::make('Category', 'category')
                ->searchable()
                ->sortable(),

            Column::make('Status', 'is_active')
                ->searchable(),

            Column::make('Created At', 'created_at_formatted')
                ->sortable(),

            Column::make('Actions', 'actions')
                ->visibleInExport(false),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('name'),

            Filter::number('price', 'price'),

            Filter::inputText('category'),

            Filter::boolean('is_active'),

            Filter::datepicker('created_at'),
        ];
    }

    #[On('toggleProductStatus')]
    public function toggleProductStatus(int $productId): void
    {
        try {
            $product = Product::findOrFail($productId);

            $product->is_active = ! $product->is_active;

            $product->save();

            $status = $product->is_active
                ? 'activated'
                : 'deactivated';

            $this->dispatch(
                'toast',
                type: 'success',
                message: "Product {$status} successfully!"
            );
        } catch (\Throwable $e) {
            $this->dispatch(
                'toast',
                type: 'error',
                message: 'Unable to update product status.'
            );
        }
    }
}