@extends('layouts.app')

@section('title', $store->seoTitle())
@section('meta_description', $store->seoDescription())
@section('canonical', route('stores.show', $store->slug))
@if($store->ogImageUrl())
@section('og_image', $store->ogImageUrl())
@endif

@push('structured_data')
@include('partials.breadcrumb-schema', ['breadcrumbs' => [
    ['name' => 'Home', 'url' => route('home')],
    ['name' => 'Stores', 'url' => route('stores.index')],
    ['name' => $store->name, 'url' => route('stores.show', $store->slug)],
]])
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "CollectionPage",
    "name": @json($store->seoTitle()),
    "url": @json(route('stores.show', $store->slug)),
    "description": @json($store->seoDescription())
}
</script>
@endpush

@push('head_links')
    @include('partials.pagination-seo', ['paginator' => $coupons])
@endpush

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
