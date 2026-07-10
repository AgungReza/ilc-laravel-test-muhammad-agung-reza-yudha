<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\ItemSupplier;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Ringkasan data utama
        $totalCategories = Category::count();
        $totalItems = Item::count();

        // Total stok = SUM(item_supplier.stock), sesuai konsep
        // "stok adalah milik supplier, bukan milik barang".
        $totalStock = (int) ItemSupplier::sum('stock');

        // Kombinasi barang-supplier yang stoknya sudah mencapai
        // atau di bawah batas minimum stok yang ditentukan.
        $lowStockCount = ItemSupplier::query()
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->count();

        // Lima barang terbaru, beserta total stok lintas supplier
        $latestItems = Item::query()
            ->with('category')
            ->withSum('itemSuppliers as total_stock', 'stock')
            ->latest()
            ->take(5)
            ->get();

        // Lima kombinasi barang-supplier dengan stok paling menipis
        $lowStockItems = ItemSupplier::query()
            ->with(['item.category', 'supplier'])
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->orderBy('stock')
            ->take(5)
            ->get();

        // Total user hanya diperlukan untuk admin
        $totalUsers = auth()->user()->role === 'admin'
            ? User::count()
            : null;

        return view('dashboard', compact(
            'totalCategories',
            'totalItems',
            'totalStock',
            'lowStockCount',
            'latestItems',
            'lowStockItems',
            'totalUsers'
        ));
    }
}
