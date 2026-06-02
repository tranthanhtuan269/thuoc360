@extends('layouts.app')

@section('title', $q ? "Search: {$q}" : 'Search')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>
            Search results
            @if($q)
                : "{{ $q }}"
            @endif
        </h1>
        <p>{{ $coupons->total() }} {{ Str::plural('offer', $coupons->total()) }} found</p>
    </div>
    @if($coupons->isEmpty())
        <p>No matching coupons found. Try a different keyword.</p>
    @else
        <div class="coupon-grid">
            @foreach($coupons as $coupon)
                @include('partials.coupon-card', ['coupon' => $coupon])
            @endforeach
        </div>
        <div class="pagination">{{ $coupons->links() }}</div>
    @endif
</div>
@endsection
