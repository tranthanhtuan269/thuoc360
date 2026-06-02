<?php

namespace App\Models;

use App\Support\HtmlCleaner;
use App\Support\PublicImage;
use App\Support\Seo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Store extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'logo',
        'website',
        'description',
        'category_id',
        'sort_order',
        'is_active',
        'view_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Store $store) {
            if (empty($store->slug)) {
                $store->slug = Str::slug($store->name);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function coupons(): HasMany
    {
        return $this->hasMany(Coupon::class);
    }

    public function scopeOwnedBy(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function incrementViews(): void
    {
        $this->increment('view_count');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function activeCouponsCount(): int
    {
        return $this->coupons()->valid()->count();
    }

    public function domain(): ?string
    {
        if (! $this->website) {
            return null;
        }

        $host = parse_url($this->website, PHP_URL_HOST);

        return $host ? preg_replace('/^www\./', '', $host) : null;
    }

    public function hasStoredLogo(): bool
    {
        return PublicImage::isStored($this->logo);
    }

    public function logoUrl(): ?string
    {
        if ($this->logo) {
            return PublicImage::url($this->logo);
        }

        $domain = $this->domain();

        return $domain ? "https://logo.clearbit.com/{$domain}" : null;
    }

    public function faviconUrl(): ?string
    {
        $domain = $this->domain();

        return $domain ? "https://www.google.com/s2/favicons?domain={$domain}&sz=128" : null;
    }

    public function initials(): string
    {
        $words = preg_split('/\s+/', trim($this->name)) ?: [];

        return strtoupper(collect($words)->take(2)->map(fn ($w) => mb_substr($w, 0, 1))->implode(''));
    }

    public function seoTitle(): string
    {
        return "{$this->name} Coupons & Promo Codes";
    }

    public function seoDescription(): string
    {
        $count = $this->activeCouponsCount();
        $base = HtmlCleaner::plainText($this->description)
            ?: "Browse {$count} verified {$this->name} coupon codes and discount deals. Updated daily on " . config('site.name') . '.';

        return Seo::description($base);
    }

    public function ogImageUrl(): ?string
    {
        return $this->logoUrl();
    }
}
