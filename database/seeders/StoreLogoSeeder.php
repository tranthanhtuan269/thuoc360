<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;

class StoreLogoSeeder extends Seeder
{
    public function run(): void
    {
        $logos = [
            'amazon' => 'https://logo.clearbit.com/amazon.com',
            'walmart' => 'https://logo.clearbit.com/walmart.com',
            'target' => 'https://logo.clearbit.com/target.com',
            'best-buy' => 'https://logo.clearbit.com/bestbuy.com',
            'uber-eats' => 'https://logo.clearbit.com/ubereats.com',
            'starbucks' => 'https://logo.clearbit.com/starbucks.com',
        ];

        foreach ($logos as $slug => $logo) {
            Store::where('slug', $slug)->update(['logo' => $logo]);
        }

        Store::whereNull('logo')->whereNotNull('website')->each(function (Store $store) {
            if ($domain = $store->domain()) {
                $store->update(['logo' => "https://logo.clearbit.com/{$domain}"]);
            }
        });
    }
}
