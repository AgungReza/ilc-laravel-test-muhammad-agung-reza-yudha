<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->search;

        $suppliers = Supplier::withCount('items')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('suppliers.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier): View
    {
        $supplier->load([
            'items.category'
        ]);

        return view(
            'suppliers.show',
            compact('supplier')
        );
    }

    /**
     * Store a newly created resource.
     */
    public function store(StoreSupplierRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {

            Supplier::create(
                $request->validated()
            );
        });

        return redirect()
            ->route('suppliers.index')
            ->with(
                'success',
                'Supplier berhasil ditambahkan.'
            );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier): View
    {
        return view(
            'suppliers.edit',
            compact('supplier')
        );
    }

    /**
     * Update the specified resource.
     */
    public function update(
        UpdateSupplierRequest $request,
        Supplier $supplier
    ): RedirectResponse {

        DB::transaction(function () use ($request, $supplier) {

            $supplier->update(
                $request->validated()
            );
        });

        return redirect()
            ->route('suppliers.index')
            ->with(
                'success',
                'Supplier berhasil diperbarui.'
            );
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(
        Supplier $supplier
    ): RedirectResponse {

        DB::transaction(function () use ($supplier) {

            $supplier->delete();
        });

        return redirect()
            ->route('suppliers.index')
            ->with(
                'success',
                'Supplier berhasil dihapus.'
            );
    }
}
