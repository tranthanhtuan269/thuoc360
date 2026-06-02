@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
<div style="display:flex;justify-content:space-between;margin-bottom:1.5rem;">
    <h1>Categories</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">+ Add Category</a>
</div>
<table class="admin-table">
    <thead><tr><th>Name</th><th>Icon</th><th>Coupons</th><th></th></tr></thead>
    <tbody>
        @foreach($categories as $category)
        <tr>
            <td>{{ $category->name }}</td>
            <td>{{ $category->icon }}</td>
            <td>{{ $category->coupons_count }}</td>
            <td>
                <a href="{{ route('admin.categories.edit', $category) }}">Edit</a>
                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this category?')">
                    @csrf @method('DELETE')
                    <button type="submit" style="background:none;border:none;color:red;cursor:pointer;">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $categories->links() }}
@endsection
