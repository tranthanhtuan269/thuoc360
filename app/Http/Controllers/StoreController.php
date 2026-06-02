<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function index(): View
    {
        $stores = Store::active()
            ->withCount(['coupons' => fn ($q) => $q->valid()])
            ->orderBy('sort_order')
            ->paginate(24);

        return view('stores.index', compact('stores'));
    }

    public function show(string $slug): View
    {
        $store = Store::where('slug', $slug)->active()->firstOrFail();
        $store->incrementViews();

        $coupons = $store->coupons()
            ->with('category')
            ->valid()
            ->latest()
            ->paginate(16);

        return view('stores.show', compact('store', 'coupons'));
    }
}
