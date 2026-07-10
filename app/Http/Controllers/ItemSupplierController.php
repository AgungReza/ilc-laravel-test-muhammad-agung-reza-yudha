<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemSupplierRequest;
use App\Http\Requests\UpdateItemSupplierRequest;
use App\Models\Item;
use App\Models\ItemSupplier;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ItemSupplierController extends Controller
{
    /**
     * Show the form for attaching a new supplier to the given item.
     */
    public function create(Item $item): View
    {
        $suppliers = Supplier::whereDoesntHave('items', function ($query) use ($item) {
            $query->where('items.id', $item->id);
        })
            ->orderBy('name')
            ->get();

        return view('items.suppliers.create', compact('item', 'suppliers'));
    }

    /**
     * Attach a supplier to the item with its own purchase price, stock,
     * and minimum stock.
     */
    public function store(
        StoreItemSupplierRequest $request,
        Item $item
    ): RedirectResponse {

        DB::transaction(function () use ($request, $item) {
            $data = $request->validated();

            $item->suppliers()->attach($data['supplier_id'], [
                'purchase_price' => $data['purchase_price'],
                'stock' => $data['stock'],
                'minimum_stock' => $data['minimum_stock'],
            ]);
        });

        return redirect()
            ->route('items.show', $item)
            ->with(
                'success',
                'Supplier berhasil ditambahkan ke barang ini.'
            );
    }

    /**
     * Show the form for editing the pivot data of an existing item-supplier pair.
     */
    public function edit(Item $item, Supplier $supplier): View
    {
        $itemSupplier = ItemSupplier::query()
            ->where('item_id', $item->id)
            ->where('supplier_id', $supplier->id)
            ->firstOrFail();

        return view(
            'items.suppliers.edit',
            compact('item', 'supplier', 'itemSupplier')
        );
    }

    /**
     * Update purchase price, stock, and minimum stock for this item-supplier pair.
     */
    public function update(
        UpdateItemSupplierRequest $request,
        Item $item,
        Supplier $supplier
    ): RedirectResponse {

        DB::transaction(function () use ($request, $item, $supplier) {
            $item->suppliers()->updateExistingPivot(
                $supplier->id,
                $request->validated()
            );
        });

        return redirect()
            ->route('items.show', $item)
            ->with(
                'success',
                'Data supplier untuk barang ini berhasil diperbarui.'
            );
    }

    /**
     * Detach a supplier from the item.
     */
    public function destroy(Item $item, Supplier $supplier): RedirectResponse
    {
        DB::transaction(function () use ($item, $supplier) {
            $item->suppliers()->detach($supplier->id);
        });

        return redirect()
            ->route('items.show', $item)
            ->with(
                'success',
                'Supplier berhasil dihapus dari barang ini.'
            );
    }
}
