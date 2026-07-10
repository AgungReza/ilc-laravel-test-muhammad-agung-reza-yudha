<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGoodsReceiptRequest;
use App\Http\Requests\UpdateGoodsReceiptRequest;
use App\Models\GoodsReceipt;
use App\Models\Item;
use App\Models\ItemSupplier;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;


class GoodsReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $goodsReceipts = GoodsReceipt::query()
            ->with(['user', 'items'])
            ->latest('receipt_date')
            ->latest('id')
            ->paginate(10);

        return view('goods-receipts.index', compact('goodsReceipts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $items = Item::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        $existingPrices = $this->existingPurchasePrices();

        return view(
            'goods-receipts.create',
            compact('items', 'suppliers', 'existingPrices')
        );
    }

    /**
     * Store a newly created resource.
     *
     * Setiap baris detail menambah stok pada kombinasi item+supplier
     * yang bersangkutan di tabel item_supplier. Kalau kombinasi itu
     * belum pernah ada, baris pivot-nya dibuat otomatis.
     */
    public function store(StoreGoodsReceiptRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $data = $request->validated();

            $goodsReceipt = GoodsReceipt::create([
                'transaction_number' => $this->generateTransactionNumber($data['receipt_date']),
                'receipt_date' => $data['receipt_date'],
                'notes' => $data['notes'] ?? null,
                'user_id' => auth()->id(),
            ]);

            foreach ($data['items'] as $line) {
                $goodsReceipt->items()->create($line);

                $this->increaseSupplierStock(
                    itemId: $line['item_id'],
                    supplierId: $line['supplier_id'],
                    quantity: $line['quantity'],
                    purchasePrice: $line['purchase_price'],
                );
            }
        });

        return redirect()
            ->route('goods-receipts.index')
            ->with('success', 'Barang masuk berhasil disimpan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GoodsReceipt $goodsReceipt): View
    {
        $goodsReceipt->load('items');

        $items = Item::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        $existingPrices = $this->existingPurchasePrices();

        return view(
            'goods-receipts.edit',
            compact('goodsReceipt', 'items', 'suppliers', 'existingPrices')
        );
    }

    /**
     * Update the specified resource.
     *
     * Efek stok dari detail lama dibatalkan (reverse) terlebih dahulu,
     * baru efek stok dari detail baru diterapkan. Kalau pembatalan
     * membuat stok supplier manapun jadi negatif (mis. karena stok itu
     * sudah terlanjur dipakai di transaksi Barang Keluar), keseluruhan
     * perubahan dibatalkan dan user diberi tahu baris mana yang bermasalah.
     */
    public function update(
        UpdateGoodsReceiptRequest $request,
        GoodsReceipt $goodsReceipt
    ): RedirectResponse {

        DB::transaction(function () use ($request, $goodsReceipt) {
            foreach ($goodsReceipt->items as $oldLine) {
                $this->decreaseSupplierStock(
                    itemId: $oldLine->item_id,
                    supplierId: $oldLine->supplier_id,
                    quantity: $oldLine->quantity,
                );
            }

            $goodsReceipt->items()->delete();

            $data = $request->validated();

            $goodsReceipt->update([
                'receipt_date' => $data['receipt_date'],
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($data['items'] as $line) {
                $goodsReceipt->items()->create($line);

                $this->increaseSupplierStock(
                    itemId: $line['item_id'],
                    supplierId: $line['supplier_id'],
                    quantity: $line['quantity'],
                    purchasePrice: $line['purchase_price'],
                );
            }
        });

        return redirect()
            ->route('goods-receipts.index')
            ->with('success', 'Barang masuk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource.
     *
     * Membatalkan (reverse) stok yang sebelumnya ditambahkan oleh
     * transaksi ini sebelum menghapus header-nya.
     */
    public function destroy(GoodsReceipt $goodsReceipt): RedirectResponse
    {
        DB::transaction(function () use ($goodsReceipt) {
            foreach ($goodsReceipt->items as $line) {
                $this->decreaseSupplierStock(
                    itemId: $line->item_id,
                    supplierId: $line->supplier_id,
                    quantity: $line->quantity,
                );
            }

            // Detail ikut terhapus otomatis lewat cascadeOnDelete
            // pada foreign key goods_receipt_id.
            $goodsReceipt->delete();
        });

        return redirect()
            ->route('goods-receipts.index')
            ->with('success', 'Barang masuk berhasil dihapus.');
    }

    /**
     * Generate nomor transaksi otomatis dengan format BM-YYYYMMDD-NNN,
     * urut per tanggal transaksi. Menggunakan lockForUpdate supaya aman
     * kalau ada dua input bersamaan pada tanggal yang sama.
     */
    private function generateTransactionNumber(string $receiptDate): string
    {
        $prefix = 'BM-' . Carbon::parse($receiptDate)->format('Ymd') . '-';

        $lastNumber = GoodsReceipt::query()
            ->where('transaction_number', 'like', $prefix . '%')
            ->lockForUpdate()
            ->orderByDesc('transaction_number')
            ->value('transaction_number');

        $nextSequence = $lastNumber
            ? ((int) substr($lastNumber, -3)) + 1
            : 1;

        return $prefix . str_pad((string) $nextSequence, 3, '0', STR_PAD_LEFT);
    }

     private const DEFAULT_MINIMUM_STOCK = 5;
    /**
     * Menambah stok supplier untuk kombinasi item+supplier tertentu.
     * Kalau kombinasi ini belum pernah didaftarkan di item_supplier,
     * baris pivot-nya dibuat otomatis dengan purchase_price dari baris
     * transaksi ini (karena belum ada harga master lain sebagai acuan).
     */
    private function increaseSupplierStock(
        int $itemId,
        int $supplierId,
        int $quantity,
        string $purchasePrice
    ): void {

        $pivot = ItemSupplier::query()
            ->where('item_id', $itemId)
            ->where('supplier_id', $supplierId)
            ->lockForUpdate()
            ->first();

        if (! $pivot) {
            ItemSupplier::create([
                'item_id' => $itemId,
                'supplier_id' => $supplierId,
                'purchase_price' => $purchasePrice,
                'stock' => $quantity,
                'minimum_stock' => self::DEFAULT_MINIMUM_STOCK, // sebelumnya 0
            ]);

            return;
        }

        ItemSupplier::query()
            ->where('item_id', $itemId)
            ->where('supplier_id', $supplierId)
            ->increment('stock', $quantity);
    }

    /**
     * Membatalkan (mengurangi) stok supplier untuk kombinasi item+supplier
     * tertentu, dipakai saat edit/hapus transaksi Barang Masuk.
     *
     * Melempar ValidationException kalau pengurangan ini akan membuat
     * stok jadi negatif -- artinya stok tersebut sudah terlanjur dipakai
     * di transaksi lain (mis. Barang Keluar) dan tidak aman untuk ditarik.
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

        // Pivot-nya sudah tidak ada (mis. dihapus manual dari menu
        // Item-Supplier) -- tidak ada lagi yang bisa dibatalkan.
        if (! $pivot) {
            return;
        }

        if ($pivot->stock < $quantity) {
            throw ValidationException::withMessages([
                'items' => sprintf(
                    'Stok "%s" dari supplier "%s" sudah terpakai di transaksi lain, sehingga perubahan ini tidak bisa dilakukan tanpa membuat stok menjadi negatif.',
                    $pivot->item->name,
                    $pivot->supplier->name,
                ),
            ]);
        }

        // Sama seperti increaseSupplierStock(): gunakan query builder
        // langsung, bukan $pivot->decrement(), karena instance Pivot ini
        // tidak diambil lewat relasi Eloquent asli.
        ItemSupplier::query()
            ->where('item_id', $itemId)
            ->where('supplier_id', $supplierId)
            ->decrement('stock', $quantity);
    }

    /**
     * Peta harga beli yang sudah pernah tercatat di item_supplier,
     * dipakai di form untuk auto-isi harga beli saat user memilih
     * kombinasi barang + supplier yang sudah pernah ada. Murni bantuan
     * UX di sisi client, tidak mempengaruhi logika penyimpanan.
     *
     * @return array<string, string>
     */
    private function existingPurchasePrices(): array
    {
        return ItemSupplier::query()
            ->get(['item_id', 'supplier_id', 'purchase_price'])
            ->mapWithKeys(fn(ItemSupplier $pivot) => [
                "{$pivot->item_id}-{$pivot->supplier_id}" => (string) $pivot->purchase_price,
            ])
            ->all();
    }
}
