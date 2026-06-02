<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
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
    }
}
