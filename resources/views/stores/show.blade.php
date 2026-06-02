@extends('layouts.app')

@section('title', $store->name)

@section('content')
<div class="container">
    <div class="page-header store-page-header">
        @include('partials.store-logo', ['store' => $store, 'size' => 'xl', 'showVerified' => true])
        <div>
            <h1>{{ $store->name }}</h1>
            <span class="store-page-verified">Verified retailer on {{ config('site.name') }}</span>
            @if($store->website)
                <p class="store-page-website"><a href="{{ $store->website }}" target="_blank" rel="noopener">{{ $store->website }}</a></p>
            @endif
        </div>
    </div>
    @if($store->description)
        <p style="margin-bottom:1.5rem;color:var(--muted);">{{ $store->description }}</p>
    @endif
    <div class="coupon-grid">
        @forelse($coupons as $coupon)
            @include('partials.coupon-card', ['coupon' => $coupon])
        @empty
            <p>No coupons available for this store yet.</p>
        @endforelse
    </div>
    <div class="pagination">{{ $coupons->links() }}</div>
</div>
@endsection
