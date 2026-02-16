<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class ProductTable extends PowerGridComponent
{
    public string $tableName = 'products';

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

    public function datasource(): ?\Illuminate\Database\Query\Builder
    {
        return Product::query()->toBase(); // Add toBase() to convert to Query Builder
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
            ->add('category')
            ->add('is_active', function ($product) {
                return $product->is_active ? '✅ Active' : '❌ Inactive';
            })
            ->add('created_at_formatted', function ($product) {
                return Carbon::parse($product->created_at)->format('d/m/Y');
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

            Column::make('Category', 'category')
                ->searchable()
                ->sortable(),

            Column::make('Status', 'is_active')
                ->searchable(),

            Column::make('Created At', 'created_at_formatted')
                ->sortable(),

            Column::action('Actions'),
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

    public function actions($product): array // Remove type hint
    {
        return [
            Button::add('edit')
                ->slot('Edit')
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('editProduct', [$product->id]),

            Button::add('delete')
                ->slot('Delete')
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('deleteProduct', [$product->id]),
        ];
    }
    // Add this method inside the ProductTable class
    public function deleteProduct(int $productId)
    {
        try {
            $product = Product::findOrFail($productId);
            $product->delete();

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Product deleted successfully!'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Error deleting product: ' . $e->getMessage()
            ]);
        }
    }
}