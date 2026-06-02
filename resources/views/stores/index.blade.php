@extends('layouts.app')

@section('title', 'Stores')

@section('content')
<div class="container">
    <div class="page-header"><h1>Stores</h1></div>
    <div class="store-grid store-grid--logos">
        @foreach($stores as $store)
            <a href="{{ route('stores.show', $store->slug) }}" class="store-chip store-chip--logo">
                @include('partials.store-logo', ['store' => $store, 'size' => 'lg', 'showVerified' => false, 'linked' => false])
                <strong>{{ $store->name }}</strong>
                <small>{{ $store->coupons_count }} {{ Str::plural('offer', $store->coupons_count) }}</small>
                <span class="store-chip-verified">Verified retailer</span>
            </a>
        @endforeach
    </div>
    <div class="pagination">{{ $stores->links() }}</div>
</div>
@endsection
