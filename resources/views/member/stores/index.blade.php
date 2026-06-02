@extends('layouts.member')

@section('title', 'My Stores')

@section('content')
<div style="display:flex;justify-content:space-between;margin-bottom:1.5rem;">
    <h1>My Stores</h1>
    <a href="{{ route('member.stores.create') }}" class="btn btn-primary">+ Add Store</a>
</div>
<table class="admin-table">
    <thead>
        <tr>
            <th>Logo</th>
            <th>Name</th>
            <th>Public page</th>
            <th>Coupons</th>
            <th>Page views</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse($stores as $store)
        <tr>
            <td>
                @if($store->logoUrl())
                    <img src="{{ $store->logoUrl() }}" alt="{{ $store->name }}" class="admin-thumb" loading="lazy">
                @else
                    <span class="admin-thumb-fallback">{{ $store->initials() }}</span>
                @endif
            </td>
            <td>{{ $store->name }}</td>
            <td>
                @if($store->is_active)
                    <a href="{{ route('stores.show', $store->slug) }}" target="_blank" rel="noopener">View →</a>
                @else
                    <span style="color:var(--muted);">Inactive</span>
                @endif
            </td>
            <td>{{ $store->coupons_count }}</td>
            <td><strong>{{ number_format($store->view_count) }}</strong></td>
            <td>
                <a href="{{ route('member.stores.edit', $store) }}">Edit</a>
                <form action="{{ route('member.stores.destroy', $store) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this store and its coupons?')">
                    @csrf @method('DELETE')
                    <button type="submit" style="background:none;border:none;color:red;cursor:pointer;">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6">No stores yet. <a href="{{ route('member.stores.create') }}">Add your first store</a>.</td></tr>
        @endforelse
    </tbody>
</table>
{{ $stores->links() }}
@endsection
