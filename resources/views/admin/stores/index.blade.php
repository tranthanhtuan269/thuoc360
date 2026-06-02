@extends('layouts.admin')

@section('title', 'Stores')

@section('content')
<div style="display:flex;justify-content:space-between;margin-bottom:1.5rem;">
    <h1>Stores</h1>
    <a href="{{ route('admin.stores.create') }}" class="btn btn-primary">+ Add Store</a>
</div>
<table class="admin-table">
    <thead><tr><th>Logo</th><th>Name</th><th>Slug</th><th>Coupons</th><th></th></tr></thead>
    <tbody>
        @foreach($stores as $store)
        <tr>
            <td>
                @if($store->logoUrl())
                    <img src="{{ $store->logoUrl() }}" alt="{{ $store->name }}" class="admin-thumb" loading="lazy">
                @else
                    <span class="admin-thumb-fallback">{{ $store->initials() }}</span>
                @endif
            </td>
            <td>{{ $store->name }}</td>
            <td>{{ $store->slug }}</td>
            <td>{{ $store->coupons_count }}</td>
            <td>
                <a href="{{ route('admin.stores.edit', $store) }}">Edit</a>
                <form action="{{ route('admin.stores.destroy', $store) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this store?')">
                    @csrf @method('DELETE')
                    <button type="submit" style="background:none;border:none;color:red;cursor:pointer;">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $stores->links() }}
@endsection
