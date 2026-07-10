<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGoodsIssueRequest;
use App\Http\Requests\UpdateGoodsIssueRequest;
use App\Models\GoodsIssue;
use App\Models\Item;
use App\Models\ItemSupplier;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class GoodsIssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $goodsIssues = GoodsIssue::query()
            ->with(['user', 'items'])
            ->latest('issue_date')
            ->latest('id')
            ->paginate(10);

        return view('goods-issues.index', compact('goodsIssues'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $items = Item::orderBy('name')->get();
        $itemSuppliers = $this->itemSupplierStockMap();

        return view(
            'goods-issues.create',
            compact('items', 'itemSuppliers')
        );
    }

    /**
     * Store a newly created resource.
     *
     * Setiap baris detail mengurangi stok pada kombinasi item+supplier
     * yang dipilih di baris itu -- supplier yang dipilih menentukan
     * stok siapa yang berkurang.
     */
    public function store(StoreGoodsIssueRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $data = $request->validated();

            $goodsIssue = GoodsIssue::create([
                'transaction_number' => $this->generateTransactionNumber($data['issue_date']),
                'issue_date' => $data['issue_date'],
                'notes' => $data['notes'] ?? null,
                'user_id' => auth()->id(),
            ]);

            foreach ($data['items'] as $line) {
                $goodsIssue->items()->create($line);

                $this->decreaseSupplierStock(
                    itemId: $line['item_id'],
                    supplierId: $line['supplier_id'],
                    quantity: $line['quantity'],
                );
            }
        });

        return redirect()
            ->route('goods-issues.index')
            ->with('success', 'Barang keluar berhasil disimpan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GoodsIssue $goodsIssue): View
    {
        $goodsIssue->load('items');

        $items = Item::orderBy('name')->get();
        $itemSuppliers = $this->itemSupplierStockMap();

        return view(
            'goods-issues.edit',
            compact('goodsIssue', 'items', 'itemSuppliers')
        );
    }

    /**
     * Update the specified resource.
     *
     * Efek stok dari detail lama dikembalikan (reverse) terlebih dahulu,
     * baru efek stok dari detail baru diterapkan. Kalau baris baru
     * ternyata melebihi stok yang tersedia, keseluruhan perubahan
     * dibatalkan dan user diberi tahu baris mana yang bermasalah.
     */
    public function update(
        UpdateGoodsIssueRequest $request,
        GoodsIssue $goodsIssue
    ): RedirectResponse {

        DB::transaction(function () use ($request, $goodsIssue) {
            foreach ($goodsIssue->items as $oldLine) {
                $this->increaseSupplierStock(
                    itemId: $oldLine->item_id,
                    supplierId: $oldLine->supplier_id,
                    quantity: $oldLine->quantity,
                );
            }

            $goodsIssue->items()->delete();

            $data = $request->validated();

            $goodsIssue->update([
                'issue_date' => $data['issue_date'],
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($data['items'] as $line) {
                $goodsIssue->items()->create($line);

                $this->decreaseSupplierStock(
                    itemId: $line['item_id'],
                    supplierId: $line['supplier_id'],
                    quantity: $line['quantity'],
                );
            }
        });

        return redirect()
            ->route('goods-issues.index')
            ->with('success', 'Barang keluar berhasil diperbarui.');
    }

    /**
     * Remove the specified resource.
     *
     * Mengembalikan (reverse) stok yang sebelumnya dikurangi oleh
     * transaksi ini sebelum menghapus header-nya.
     */
    public function destroy(GoodsIssue $goodsIssue): RedirectResponse
    {
        DB::transaction(function () use ($goodsIssue) {
            foreach ($goodsIssue->items as $line) {
                $this->increaseSupplierStock(
                    itemId: $line->item_id,
                    supplierId: $line->supplier_id,
                    quantity: $line->quantity,
                );
            }

            // Detail ikut terhapus otomatis lewat cascadeOnDelete
            // pada foreign key goods_issue_id.
            $goodsIssue->delete();
        });

        return redirect()
            ->route('goods-issues.index')
            ->with('success', 'Barang keluar berhasil dihapus.');
    }

    /**
     * Generate nomor transaksi otomatis dengan format BK-YYYYMMDD-NNN,
     * urut per tanggal transaksi. Menggunakan lockForUpdate supaya aman
     * kalau ada dua input bersamaan pada tanggal yang sama.
     */
    private function generateTransactionNumber(string $issueDate): string
    {
        $prefix = 'BK-' . Carbon::parse($issueDate)->format('Ymd') . '-';

        $lastNumber = GoodsIssue::query()
            ->where('transaction_number', 'like', $prefix . '%')
            ->lockForUpdate()
            ->orderByDesc('transaction_number')
            ->value('transaction_number');

        $nextSequence = $lastNumber
            ? ((int) substr($lastNumber, -3)) + 1
            : 1;

        return $prefix . str_pad((string) $nextSequence, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Mengurangi stok supplier untuk kombinasi item+supplier tertentu.
     *
     * Melempar ValidationException kalau kombinasi ini belum pernah
     * terdaftar di item_supplier, atau kalau stoknya tidak cukup --
     * artinya barang ini tidak bisa dikeluarkan dari supplier tersebut
     * tanpa membuat stok jadi negatif.
     */
    private function decreaseSupplierStock(
        int $itemId,
        int $supplierId,
        int $quantity
    ): void {

        $pivot = ItemSupplier::query()
            ->where('item_id', $itemId)
            ->where('supplier_id', $supplierId)
            ->lockForUpdate()
            ->first();

        if (! $pivot || $pivot->stock < $quantity) {
            $item = Item::find($itemId);

            throw ValidationException::withMessages([
                'items' => sprintf(
                    'Stok "%s" dari supplier yang dipilih tidak mencukupi. Sisa stok saat ini: %d.',
                    $item?->name ?? 'Barang',
                    $pivot->stock ?? 0,
                ),
            ]);
        }

        // PENTING: tidak memakai $pivot->decrement() di sini. ItemSupplier
        // adalah custom Pivot dengan primary key komposit (item_id +
        // supplier_id). Kalau instance-nya diambil lewat query manual
        // (bukan lewat relasi Eloquent asli), Laravel tidak tahu kolom
        // kunci mana yang harus dipakai untuk WHERE saat increment/decrement,
        // sehingga menghasilkan SQL rusak (WHERE dengan kolom kosong).
        // Query builder langsung seperti ini aman karena tidak bergantung
        // pada resolusi primary key model sama sekali.
        ItemSupplier::query()
            ->where('item_id', $itemId)
            ->where('supplier_id', $supplierId)
            ->decrement('stock', $quantity);
    }

    /**
     * Mengembalikan (menambah) stok supplier untuk kombinasi item+supplier
     * tertentu, dipakai saat edit/hapus transaksi Barang Keluar untuk
     * membatalkan efek stok dari data lama.
     */
    private function increaseSupplierStock(
        int $itemId,
        int $supplierId,
        int $quantity
    ): void {

        $pivot = ItemSupplier::query()
            ->where('item_id', $itemId)
            ->where('supplier_id', $supplierId)
            ->lockForUpdate()
            ->first();

        // Pivot-nya sudah tidak ada (mis. dihapus manual dari menu
        // Item-Supplier) -- tidak ada lagi yang bisa dikembalikan.
        if (! $pivot) {
            return;
        }

        // Sama seperti decreaseSupplierStock(): gunakan query builder
        // langsung, bukan $pivot->increment(), karena instance Pivot ini
        // tidak diambil lewat relasi Eloquent asli.
        ItemSupplier::query()
            ->where('item_id', $itemId)
            ->where('supplier_id', $supplierId)
            ->increment('stock', $quantity);
    }

    /**
     * Peta supplier beserta stok yang tersedia untuk tiap barang,
     * dipakai di form untuk membatasi pilihan supplier hanya pada
     * supplier yang benar-benar memasok barang tersebut, sekaligus
     * menampilkan sisa stoknya. Murni bantuan UX di sisi client,
     * validasi stok yang sebenarnya tetap dilakukan di controller.
     *
     * @return array<int, array<int, array{id: int, name: string, stock: int}>>
     */
    private function itemSupplierStockMap(): array
    {
        return ItemSupplier::query()
            ->with('supplier')
            ->get()
            ->groupBy('item_id')
            ->map(fn ($group) => $group->map(fn (ItemSupplier $pivot) => [
                'id' => $pivot->supplier_id,
                'name' => $pivot->supplier->name,
                'stock' => $pivot->stock,
            ])->values())
            ->all();
    }
}
