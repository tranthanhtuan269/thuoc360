<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Post;
use App\Models\Store;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'coupons' => Coupon::count(),
            'active_coupons' => Coupon::valid()->count(),
            'stores' => Store::count(),
            'categories' => Category::count(),
            'posts' => Post::count(),
            'published_posts' => Post::published()->count(),
            'clicks' => Coupon::sum('click_count'),
        ];

        $recentCoupons = Coupon::with('store')->latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recentCoupons'));
    }
}
