@extends('layouts.app')

@section('title', 'Home — Coupons & Discount Codes')

@section('content')
<section class="hero">
    <div class="container">
        <h1>{{ config('site.name') }}</h1>
        <p>{{ config('site.tagline') }}.</p>
        <p class="hero-subtitle">Save at Amazon, Walmart, Target, and top U.S. retailers.</p>
        <form action="{{ route('search') }}" method="GET" class="search-form" style="max-width:480px;margin:0 auto;">
            <input type="search" name="q" placeholder="Search coupons, stores...">
            <button type="submit">Search</button>
        </form>
        <div class="hero-stats">
            <div><strong>{{ $stats['coupons'] }}</strong> Active Offers</div>
            <div><strong>{{ $stats['stores'] }}</strong> Stores</div>
            <div><strong>{{ $stats['categories'] }}</strong> Categories</div>
        </div>
    </div>
</section>

@if($featuredCoupons->isNotEmpty())
<section class="section">
    <div class="container">
        <h2 class="section-title">Featured <a href="{{ route('coupons.index') }}">View all →</a></h2>
        <div class="coupon-grid">
            @foreach($featuredCoupons as $coupon)
                @include('partials.coupon-card', ['coupon' => $coupon])
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="section">
    <div class="container">
        <h2 class="section-title">Categories</h2>
        <div class="category-grid">
            @foreach($categories as $category)
                <a href="{{ route('categories.show', $category->slug) }}" class="category-chip">
                    <span class="icon">{{ $category->icon ?? '🏷️' }}</span>
                    <strong>{{ $category->name }}</strong>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <h2 class="section-title">Popular Stores</h2>
        <div class="store-grid">
            @foreach($stores as $store)
                <a href="{{ route('stores.show', $store->slug) }}" class="store-chip store-chip--logo">
                    @include('partials.store-logo', ['store' => $store, 'size' => 'md', 'showVerified' => false, 'linked' => false])
                    <strong>{{ $store->name }}</strong>
                    <small>{{ $store->activeCouponsCount() }} offers</small>
                </a>
            @endforeach
        </div>
    </div>
</section>

@if($latestPosts->isNotEmpty())
<section class="section">
    <div class="container">
        <h2 class="section-title">From the Blog <a href="{{ route('blog.index') }}">All articles →</a></h2>
        <div class="blog-grid">
            @foreach($latestPosts as $post)
                @include('blog.partials.card', ['post' => $post])
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="section">
    <div class="container">
        <h2 class="section-title">Recently Added</h2>
        <div class="coupon-grid">
            @foreach($latestCoupons as $coupon)
                @include('partials.coupon-card', ['coupon' => $coupon])
            @endforeach
        </div>
    </div>
</section>
@endsection
