<div class="form-group">
    <label for="store-website">Website / Affiliate link</label>
    <input type="url" id="store-website" name="website" value="{{ old('website', $store->website ?? '') }}" placeholder="https://example.com/?ref=your-affiliate-id">
    <p class="form-hint">
        Enter your <strong>affiliate or tracking URL</strong> for this store (not just the homepage).
        Coupons can use this link when shoppers click through from {{ config('site.name') }}.
    </p>
</div>
