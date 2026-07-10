<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Category;
use App\Models\Item;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $items = Item::with([
            'category',
            'suppliers',
        ])
            ->latest()
            ->paginate(10);

        return view('items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        $suppliers = Supplier::orderBy('name')->get();

        return view('items.create', compact(
            'categories',
            'suppliers'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item): View
    {
        $item->load([
            'category',
            'suppliers',
        ]);

        return view(
            'items.show',
            compact('item')
        );
    }

    /**
     * Store a newly created resource.
     */
    public function store(StoreItemRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {

            $data = $request->validated();

            $supplierId = $data['supplier_id'];

            unset($data['supplier_id']);

            $item = Item::create($data);

            // Tetap menggunakan pivot,
            // tetapi hanya menyimpan satu supplier.
            $item->suppliers()->sync([$supplierId]);
        });

        return redirect()
            ->route('items.index')
            ->with(
                'success',
                'Barang berhasil ditambahkan.'
            );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item): View
    {
        $item->load('suppliers');

        $categories = Category::orderBy('name')->get();

        $suppliers = Supplier::orderBy('name')->get();

        return view('items.edit', compact(
            'item',
            'categories',
            'suppliers'
        ));
    }

    /**
     * Update the specified resource.
     */
    public function update(
        UpdateItemRequest $request,
        Item $item
    ): RedirectResponse {

        DB::transaction(function () use ($request, $item) {

            $data = $request->validated();

            $supplierId = $data['supplier_id'];

            unset($data['supplier_id']);

            $item->update($data);

            // Hanya satu supplier
            $item->suppliers()->sync([$supplierId]);
        });

        return redirect()
            ->route('items.index')
            ->with(
                'success',
                'Barang berhasil diperbarui.'
            );
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(Item $item): RedirectResponse
    {
        DB::transaction(function () use ($item) {

            $item->suppliers()->detach();

            $item->delete();
        });

        return redirect()
            ->route('items.index')
            ->with(
                'success',
                'Barang berhasil dihapus.'
            );
    }
}
