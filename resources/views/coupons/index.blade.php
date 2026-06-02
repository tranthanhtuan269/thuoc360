@extends('layouts.app')

@section('title', 'All Coupons & Deals')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Coupons & Discount Deals</h1>
    </div>
    <div class="filter-tabs">
        <a href="{{ route('coupons.index') }}" class="{{ !$type ? 'active' : '' }}">All</a>
        <a href="{{ route('coupons.index', ['type' => 'coupon']) }}" class="{{ $type === 'coupon' ? 'active' : '' }}">Coupon Codes</a>
        <a href="{{ route('coupons.index', ['type' => 'discount']) }}" class="{{ $type === 'discount' ? 'active' : '' }}">Discount Deals</a>
    </div>
    <div class="coupon-grid">
        @forelse($coupons as $coupon)
            @include('partials.coupon-card', ['coupon' => $coupon])
        @empty
            <p>No offers available yet.</p>
        @endforelse
    </div>
    <div class="pagination">{{ $coupons->links() }}</div>
</div>
@endsection
