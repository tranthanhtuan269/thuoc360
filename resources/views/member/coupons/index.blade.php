@extends('layouts.member')

@section('title', 'My Coupons')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
    <h1>My Coupons &amp; Deals</h1>
    <a href="{{ route('member.coupons.create') }}" class="btn btn-primary">+ Add Coupon</a>
</div>
<table class="admin-table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Store</th>
            <th>Code</th>
            <th>Type</th>
            <th>Status</th>
            <th>Clicks</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse($coupons as $coupon)
        <tr>
            <td>
                @if($coupon->is_active)
                    <a href="{{ route('coupons.show', $coupon->slug) }}" target="_blank" rel="noopener">{{ $coupon->title }}</a>
                @else
                    {{ $coupon->title }}
                @endif
            </td>
            <td>{{ $coupon->store?->name }}</td>
            <td><code>{{ $coupon->code ?? '—' }}</code></td>
            <td>{{ $coupon->typeLabel() }}</td>
            <td>{{ $coupon->is_active ? 'Active' : 'Inactive' }}</td>
            <td><strong>{{ number_format($coupon->click_count) }}</strong></td>
            <td>
                <a href="{{ route('member.coupons.edit', $coupon) }}">Edit</a>
                <form action="{{ route('member.coupons.destroy', $coupon) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this coupon?')">
                    @csrf @method('DELETE')
                    <button type="submit" style="background:none;border:none;color:red;cursor:pointer;">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="7">No coupons yet. <a href="{{ route('member.coupons.create') }}">Create one</a> (add a store first if needed).</td></tr>
        @endforelse
    </tbody>
</table>
{{ $coupons->links() }}
@endsection
