<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Category;
use App\Models\Item;
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
        $items = Item::with(['category', 'suppliers'])
            ->withSum('itemSuppliers as total_stock', 'stock')
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

        return view('items.create', compact('categories'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item): View
    {
        $item->load(['category', 'itemSuppliers.supplier']);

        $item->loadSum('itemSuppliers as total_stock', 'stock');

        return view('items.show', compact('item'));
    }

    /**
     * Store a newly created resource.
     *
     * Hanya menyimpan data Master Barang. Supplier ditambahkan
     * setelahnya melalui halaman "Kelola Supplier" pada detail barang.
     */
    public function store(StoreItemRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            Item::create($request->validated());
        });

        return redirect()
            ->route('items.index')
            ->with(
                'success',
                'Barang berhasil ditambahkan. Silakan tambahkan supplier pada halaman detail barang.'
            );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item): View
    {
        $categories = Category::orderBy('name')->get();

        return view('items.edit', compact('item', 'categories'));
    }

    /**
     * Update the specified resource.
     */
    public function update(
        UpdateItemRequest $request,
        Item $item
    ): RedirectResponse {

        DB::transaction(function () use ($request, $item) {
            $item->update($request->validated());
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
     *
     * Baris pivot item_supplier ikut terhapus otomatis lewat
     * cascadeOnDelete pada foreign key item_id.
     */
    public function destroy(Item $item): RedirectResponse
    {
        DB::transaction(function () use ($item) {
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
