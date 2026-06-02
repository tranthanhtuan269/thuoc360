@extends('layouts.member')

@section('title', 'Dashboard')

@section('content')
<h1 style="margin-bottom:1.5rem;">My Dashboard</h1>
<p style="color:var(--muted);margin-bottom:1.5rem;">Statistics for content you created only.</p>
<div class="stats-grid">
    <div class="stat-card"><strong>{{ $stats['coupons'] }}</strong> My Coupons</div>
    <div class="stat-card"><strong>{{ $stats['active_coupons'] }}</strong> Active</div>
    <div class="stat-card"><strong>{{ $stats['stores'] }}</strong> My Stores</div>
    <div class="stat-card"><strong>{{ $stats['published_posts'] }}</strong> Published Posts</div>
    <div class="stat-card"><strong>{{ number_format($stats['clicks']) }}</strong> Coupon Clicks</div>
    <div class="stat-card"><strong>{{ number_format($stats['store_views']) }}</strong> Store Page Views</div>
</div>
<h2 style="margin:1.5rem 0 1rem;">Latest Coupons</h2>
@if($recentCoupons->isEmpty())
    <p>No coupons yet. <a href="{{ route('member.coupons.create') }}">Create your first coupon</a>.</p>
@else
<table class="admin-table">
    <thead>
        <tr><th>Title</th><th>Store</th><th>Type</th><th>Clicks</th></tr>
    </thead>
    <tbody>
        @foreach($recentCoupons as $c)
        <tr>
            <td><a href="{{ route('member.coupons.edit', $c) }}">{{ $c->title }}</a></td>
            <td>{{ $c->store?->name }}</td>
            <td>{{ $c->typeLabel() }}</td>
            <td>{{ number_format($c->click_count) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection
