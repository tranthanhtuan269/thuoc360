<article class="coupon-card {{ $coupon->is_featured ? 'featured' : '' }}">
    <div class="coupon-card-top">
        @include('partials.store-logo', ['store' => $coupon->store, 'size' => 'md'])
        <div class="coupon-card-badges">
            <div class="coupon-badge">{{ $coupon->discountLabel() }}</div>
            <div class="coupon-type">{{ $coupon->typeLabel() }}</div>
        </div>
    </div>
    <h3 class="coupon-title">
        <a href="{{ route('coupons.show', $coupon->slug) }}">{{ $coupon->title }}</a>
    </h3>
    <div class="coupon-store">
        @if($coupon->store)
            <a href="{{ route('stores.show', $coupon->store->slug) }}">{{ $coupon->store->name }}</a>
        @endif
        @if($coupon->category)
            <span class="coupon-cat">{{ $coupon->category->icon }} {{ $coupon->category->name }}</span>
        @endif
    </div>
    @if($coupon->expires_at)
        <p class="coupon-expire">Expires: {{ $coupon->expires_at->format('m/d/Y') }}</p>
    @endif
    <div class="coupon-actions">
        @if($coupon->code)
            <button type="button" class="btn btn-copy" data-code="{{ $coupon->code }}" data-reveal-url="{{ route('coupons.reveal', $coupon->slug) }}">
                Copy Code
            </button>
        @else
            <a href="{{ route('coupons.show', $coupon->slug) }}" class="btn btn-primary">View Deal</a>
        @endif
        <a href="{{ route('coupons.go', $coupon->slug) }}" class="btn btn-outline" target="_blank" rel="noopener">Shop Now</a>
    </div>
</article>
