<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Store;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@thuoc360.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );

        $categories = [
            ['name' => 'Fashion', 'icon' => '👗', 'sort_order' => 1],
            ['name' => 'Electronics', 'icon' => '📱', 'sort_order' => 2],
            ['name' => 'Beauty', 'icon' => '💄', 'sort_order' => 3],
            ['name' => 'Food & Dining', 'icon' => '🍔', 'sort_order' => 4],
            ['name' => 'Travel', 'icon' => '✈️', 'sort_order' => 5],
            ['name' => 'Health', 'icon' => '💊', 'sort_order' => 6],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['slug' => Str::slug($cat['name'])],
                array_merge($cat, ['is_active' => true])
            );
        }

        $stores = [
            ['name' => 'Amazon', 'website' => 'https://www.amazon.com', 'logo' => 'https://logo.clearbit.com/amazon.com', 'sort_order' => 1],
            ['name' => 'Walmart', 'website' => 'https://www.walmart.com', 'logo' => 'https://logo.clearbit.com/walmart.com', 'sort_order' => 2],
            ['name' => 'Target', 'website' => 'https://www.target.com', 'logo' => 'https://logo.clearbit.com/target.com', 'sort_order' => 3],
            ['name' => 'Best Buy', 'website' => 'https://www.bestbuy.com', 'logo' => 'https://logo.clearbit.com/bestbuy.com', 'sort_order' => 4],
            ['name' => 'Uber Eats', 'website' => 'https://www.ubereats.com', 'logo' => 'https://logo.clearbit.com/ubereats.com', 'sort_order' => 5],
            ['name' => 'Starbucks', 'website' => 'https://www.starbucks.com', 'logo' => 'https://logo.clearbit.com/starbucks.com', 'sort_order' => 6],
        ];

        foreach ($stores as $store) {
            Store::updateOrCreate(
                ['slug' => Str::slug($store['name'])],
                array_merge($store, ['is_active' => true])
            );
        }

        $samples = [
            [
                'store' => 'amazon',
                'category' => 'fashion',
                'title' => '15% Off Orders $50+ — Amazon Fashion',
                'code' => 'AMZN15OFF',
                'type' => 'coupon',
                'discount_type' => 'percent',
                'discount_value' => 15,
                'is_featured' => true,
            ],
            [
                'store' => 'walmart',
                'category' => 'electronics',
                'title' => '$20 Off Electronics Orders $100+',
                'code' => 'WM20TECH',
                'type' => 'coupon',
                'discount_type' => 'fixed',
                'discount_value' => 20,
                'is_featured' => true,
            ],
            [
                'store' => 'target',
                'category' => 'health',
                'title' => 'Free Shipping on Target Orders',
                'code' => 'TARGETSHIP',
                'type' => 'coupon',
                'discount_type' => 'free_shipping',
                'discount_value' => null,
                'is_featured' => true,
            ],
            [
                'store' => 'uber-eats',
                'category' => 'food-dining',
                'title' => '$10 Off Your First Uber Eats Order',
                'code' => 'EATS10',
                'type' => 'coupon',
                'discount_type' => 'fixed',
                'discount_value' => 10,
                'is_featured' => false,
            ],
            [
                'store' => 'starbucks',
                'category' => 'food-dining',
                'title' => 'Buy One, Get One Free — Starbucks',
                'code' => null,
                'type' => 'discount',
                'discount_type' => 'other',
                'discount_value' => null,
                'is_featured' => true,
            ],
            [
                'store' => 'best-buy',
                'category' => 'beauty',
                'title' => '10% Off Select Beauty at Best Buy',
                'code' => 'BBBEAUTY10',
                'type' => 'coupon',
                'discount_type' => 'percent',
                'discount_value' => 10,
                'is_featured' => false,
            ],
            [
                'store' => 'amazon',
                'category' => 'electronics',
                'title' => 'Flash Sale: Up to $50 Off Smartphones',
                'code' => null,
                'type' => 'discount',
                'discount_type' => 'fixed',
                'discount_value' => 50,
                'is_featured' => true,
            ],
            [
                'store' => 'walmart',
                'category' => 'travel',
                'title' => '15% Off Walmart Travel & Luggage',
                'code' => 'WMTRAVEL15',
                'type' => 'coupon',
                'discount_type' => 'percent',
                'discount_value' => 15,
                'is_featured' => false,
            ],
        ];

        $this->call(BlogSeeder::class);

        foreach ($samples as $sample) {
            $store = Store::where('slug', $sample['store'])->first();
            $category = Category::where('slug', $sample['category'])->first();

            if (! $store) {
                continue;
            }

            $slug = Str::slug($sample['title']);

            Coupon::updateOrCreate(
                ['slug' => $slug],
                [
                    'store_id' => $store->id,
                    'category_id' => $category?->id,
                    'title' => $sample['title'],
                    'description' => 'Offer updated regularly. Store terms and conditions apply.',
                    'code' => $sample['code'],
                    'type' => $sample['type'],
                    'discount_type' => $sample['discount_type'],
                    'discount_value' => $sample['discount_value'],
                    'affiliate_url' => $store->website,
                    'starts_at' => Carbon::now()->subDays(1),
                    'expires_at' => Carbon::now()->addMonths(1),
                    'is_featured' => $sample['is_featured'],
                    'is_active' => true,
                ]
            );
        }
    }
}
