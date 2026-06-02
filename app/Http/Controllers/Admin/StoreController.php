<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Support\PublicImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function index(): View
    {
        $stores = Store::withCount('coupons')->orderBy('sort_order')->paginate(20);

        return view('admin.stores.index', compact('stores'));
    }

    public function create(): View
    {
        return view('admin.stores.form', ['store' => new Store()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['logo'] = $this->resolveLogo($request, $data['logo'] ?? null);
        Store::create($data);

        return redirect()->route('admin.stores.index')->with('success', 'Store created successfully.');
    }

    public function edit(Store $store): View
    {
        return view('admin.stores.form', compact('store'));
    }

    public function update(Request $request, Store $store): RedirectResponse
    {
        $data = $this->validated($request);
        $data['logo'] = $this->resolveLogo($request, $request->input('logo'), $store->logo);
        $store->update($data);

        return redirect()->route('admin.stores.index')->with('success', 'Store updated successfully.');
    }

    public function destroy(Store $store): RedirectResponse
    {
        PublicImage::delete($store->logo);
        $store->delete();

        return redirect()->route('admin.stores.index')->with('success', 'Store deleted successfully.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'string', 'max:500'],
            'logo_file' => ['nullable', 'image', 'max:2048'],
            'website' => ['nullable', 'url', 'max:500'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active', true);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        unset($data['logo_file']);

        return $data;
    }

    private function resolveLogo(Request $request, ?string $logoUrl, ?string $existing = null): ?string
    {
        if ($request->hasFile('logo_file')) {
            PublicImage::delete($existing);

            return PublicImage::store($request->file('logo_file'), 'stores');
        }

        if (filled($logoUrl)) {
            if ($existing && PublicImage::isStored($existing) && $logoUrl !== $existing) {
                PublicImage::delete($existing);
            }

            return $logoUrl;
        }

        return $existing;
    }

    private function uniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $original = $slug;
        $i = 1;

        while (Store::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $i++;
        }

        return $slug;
    }
}
