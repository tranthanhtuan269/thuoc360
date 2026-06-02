@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<h1 style="margin-bottom:1.5rem;">Dashboard</h1>
<div class="stats-grid">
    <div class="stat-card"><strong>{{ $stats['coupons'] }}</strong> Total Coupons</div>
    <div class="stat-card"><strong>{{ $stats['active_coupons'] }}</strong> Active</div>
    <div class="stat-card"><strong>{{ $stats['stores'] }}</strong> Stores</div>
    <div class="stat-card"><strong>{{ $stats['categories'] }}</strong> Categories</div>
    <div class="stat-card"><strong>{{ $stats['published_posts'] }}</strong> Blog Posts</div>
    <div class="stat-card"><strong>{{ number_format($stats['clicks']) }}</strong> Clicks</div>
</div>
<h2 style="margin-bottom:1rem;">Latest Coupons</h2>
<table class="admin-table">
    <thead>
        <tr><th>Title</th><th>Store</th><th>Type</th><th>Clicks</th></tr>
    </thead>
    <tbody>
        @foreach($recentCoupons as $c)
        <tr>
            <td><a href="{{ route('admin.coupons.edit', $c) }}">{{ $c->title }}</a></td>
            <td>{{ $c->store?->name }}</td>
            <td>{{ $c->typeLabel() }}</td>
            <td>{{ $c->click_count }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
