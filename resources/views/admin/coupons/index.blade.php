@extends('layouts.admin')

@section('title', 'Manage Coupons')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
    <h1>Coupons</h1>
    <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">+ Add Coupon</a>
</div>
<table class="admin-table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Store</th>
            <th>Code</th>
            <th>Type</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($coupons as $coupon)
        <tr>
            <td>{{ $coupon->title }}</td>
            <td>{{ $coupon->store?->name }}</td>
            <td><code>{{ $coupon->code ?? '—' }}</code></td>
            <td>{{ $coupon->typeLabel() }}</td>
            <td>{{ $coupon->is_active ? 'Active' : 'Inactive' }}</td>
            <td>
                <a href="{{ route('admin.coupons.edit', $coupon) }}">Edit</a>
                <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this coupon?')">
                    @csrf @method('DELETE')
                    <button type="submit" style="background:none;border:none;color:red;cursor:pointer;">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $coupons->links() }}
@endsection
