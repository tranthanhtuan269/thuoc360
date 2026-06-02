@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="container">
    <div class="page-header">
        <h1>{{ $category->icon }} {{ $category->name }}</h1>
        @if($category->description)<p>{{ $category->description }}</p>@endif
    </div>
    <div class="coupon-grid">
        @forelse($coupons as $coupon)
            @include('partials.coupon-card', ['coupon' => $coupon])
        @empty
            <p>No offers in this category yet.</p>
        @endforelse
    </div>
    <div class="pagination">{{ $coupons->links() }}</div>
</div>
@endsection
