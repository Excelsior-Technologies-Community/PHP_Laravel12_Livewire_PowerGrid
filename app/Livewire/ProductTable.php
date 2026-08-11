<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class ProductTable extends PowerGridComponent
{
    use WithExport;

    public string $tableName = 'products';

    public string $stockStatus = '';

    /*
    |--------------------------------------------------------------------------
    | Setup
    |--------------------------------------------------------------------------
    */

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            /*
            |--------------------------------------------------------------------------
            | CSV / Excel Export
            |--------------------------------------------------------------------------
            */
            PowerGrid::exportable('products-export')
                ->striped()
                ->type(
                    Exportable::TYPE_XLS,
                    Exportable::TYPE_CSV
                ),

            /*
            |--------------------------------------------------------------------------
            | Header
            |--------------------------------------------------------------------------
            */
            PowerGrid::header()
                ->showSearchInput()
                ->showToggleColumns(),

            /*
            |--------------------------------------------------------------------------
            | Footer
            |--------------------------------------------------------------------------
            */
            PowerGrid::footer()
                ->showPerPage(
                    10,
                    [5, 10, 25, 50, 100]
                )
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Bulk Action Buttons
    |--------------------------------------------------------------------------
    */

    public function header(): array
    {
        return [
            Button::add('bulk-activate')
                ->slot('✅ Activate Selected')
                ->class(
                    'px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700'
                )
                ->dispatch(
                    'bulkActivate.' . $this->tableName,
                    []
                ),

            Button::add('bulk-deactivate')
                ->slot('❌ Deactivate Selected')
                ->class(
                    'px-3 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600'
                )
                ->dispatch(
                    'bulkDeactivate.' . $this->tableName,
                    []
                ),

            Button::add('bulk-delete')
                ->slot('🗑 Delete Selected')
                ->class(
                    'px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700'
                )
                ->dispatch(
                    'bulkDelete.' . $this->tableName,
                    []
                ),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Data Source
    |--------------------------------------------------------------------------
    */

    public function datasource(): ?Builder
    {
        return Product::query()->toBase();
    }

    /*
    |--------------------------------------------------------------------------
    | Relation Search
    |--------------------------------------------------------------------------
    */

    public function relationSearch(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    | Fields
    |--------------------------------------------------------------------------
    */

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()

            ->add('id')

            ->add('name')

            ->add('description')

            ->add('price')

            ->add('price_formatted', function ($product) {
                return '$ ' . number_format(
                    $product->price,
                    2
                );
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

            ->add('is_active')

            ->add('is_active_formatted', function ($product) {
                return $product->is_active
                    ? '✅ Active'
                    : '❌ Inactive';
            })

            ->add('created_at')

            ->add('created_at_formatted', function ($product) {
                return Carbon::parse($product->created_at)
                    ->format('d/m/Y');
            })

            ->add('actions', function ($product) {
                return view(
                    'livewire.product-actions',
                    [
                        'row' => $product,
                    ]
                )->render();
            });
    }

    /*
    |--------------------------------------------------------------------------
    | Columns
    |--------------------------------------------------------------------------
    */

    public function columns(): array
    {
        return [

            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),

            Column::make('Name', 'name')
                ->searchable()
                ->sortable(),

            Column::make(
                'Description',
                'description'
            )
                ->searchable(),

            Column::make(
                'Price',
                'price_formatted',
                'price'
            )
                ->searchable()
                ->sortable()
                ->withSum(
                    'Total Price',
                    header: true,
                    footer: false
                )
                ->withAvg(
                    'Average Price',
                    header: true,
                    footer: false
                ),

            Column::make('Stock', 'stock')
                ->searchable()
                ->sortable()
                ->withSum(
                    'Total Stock',
                    header: true,
                    footer: false
                )
                ->withMin(
                    'Minimum Stock',
                    header: false,
                    footer: true
                )
                ->withMax(
                    'Maximum Stock',
                    header: false,
                    footer: true
                ),

            Column::make(
                'Stock Status',
                'stock_status'
            )
                ->searchable(),

            Column::make('Category', 'category')
                ->searchable()
                ->sortable(),

            Column::make(
                'Status',
                'is_active_formatted',
                'is_active'
            )
                ->searchable(),

            Column::make(
                'Created At',
                'created_at_formatted',
                'created_at'
            )
                ->sortable(),

            Column::make(
                'Actions',
                'actions'
            )
                ->visibleInExport(false),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Advanced Filters
    |--------------------------------------------------------------------------
    */

    public function filters(): array
    {
        return [

            Filter::inputText('name')
                ->placeholder('Search product name'),

            Filter::number(
                'price',
                'price'
            )
                ->placeholder(
                    'Minimum',
                    'Maximum'
                ),

            Filter::number(
                'stock',
                'stock'
            )
                ->placeholder(
                    'Minimum Stock',
                    'Maximum Stock'
                ),

            Filter::inputText('category')
                ->placeholder('Category'),

            Filter::boolean('is_active'),

            Filter::datepicker('created_at'),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Stock Summary Formatting
    |--------------------------------------------------------------------------
    */

    public function summarizeFormat(): array
    {
        return [
            'price.{sum,avg,min,max}' => function ($value) {
                return '$ ' . number_format(
                    (float) $value,
                    2
                );
            },

            'stock.{sum,min,max}' => function ($value) {
                return number_format(
                    (int) $value
                );
            },
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Toggle Individual Product Status
    |--------------------------------------------------------------------------
    */

    #[On('toggleProductStatus')]
    public function toggleProductStatus(
        int $productId
    ): void {

        try {

            $product = Product::findOrFail(
                $productId
            );

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

            $this->refresh();
        } catch (\Throwable $e) {

            $this->dispatch(
                'toast',
                type: 'error',
                message: 'Unable to update product status.'
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Bulk Activate
    |--------------------------------------------------------------------------
    */

    #[On('bulkActivate.{tableName}')]
    public function bulkActivate(): void
    {
        $ids = $this->checkboxValues;

        if (empty($ids)) {

            $this->dispatch(
                'toast',
                type: 'error',
                message: 'Please select at least one product.'
            );

            return;
        }

        Product::whereIn('id', $ids)
            ->update([
                'is_active' => true,
            ]);

        $this->js(
            'window.pgBulkActions.clearAll()'
        );

        $this->dispatch(
            'toast',
            type: 'success',
            message: count($ids) .
                ' product(s) activated successfully!'
        );

        $this->refresh();
    }

    /*
    |--------------------------------------------------------------------------
    | Bulk Deactivate
    |--------------------------------------------------------------------------
    */

    #[On('bulkDeactivate.{tableName}')]
    public function bulkDeactivate(): void
    {
        $ids = $this->checkboxValues;

        if (empty($ids)) {

            $this->dispatch(
                'toast',
                type: 'error',
                message: 'Please select at least one product.'
            );

            return;
        }

        Product::whereIn('id', $ids)
            ->update([
                'is_active' => false,
            ]);

        $this->js(
            'window.pgBulkActions.clearAll()'
        );

        $this->dispatch(
            'toast',
            type: 'success',
            message: count($ids) .
                ' product(s) deactivated successfully!'
        );

        $this->refresh();
    }

    /*
    |--------------------------------------------------------------------------
    | Bulk Delete
    |--------------------------------------------------------------------------
    */

    #[On('bulkDelete.{tableName}')]
    public function bulkDelete(): void
    {
        $ids = $this->checkboxValues;

        if (empty($ids)) {

            $this->dispatch(
                'toast',
                type: 'error',
                message: 'Please select at least one product.'
            );

            return;
        }

        Product::whereIn('id', $ids)
            ->delete();

        $this->js(
            'window.pgBulkActions.clearAll()'
        );

        $this->dispatch(
            'toast',
            type: 'success',
            message: count($ids) .
                ' product(s) deleted successfully!'
        );

        $this->refresh();
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Single Product
    |--------------------------------------------------------------------------
    */

    #[On('deleteProduct')]
    public function deleteProduct(
        int $productId
    ): void {

        try {

            $product = Product::findOrFail(
                $productId
            );

            $product->delete();

            $this->dispatch(
                'toast',
                type: 'success',
                message: 'Product deleted successfully!'
            );

            $this->refresh();
        } catch (\Throwable $e) {

            $this->dispatch(
                'toast',
                type: 'error',
                message: 'Unable to delete product.'
            );
        }
    }
}
