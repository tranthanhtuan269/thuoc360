@extends('layouts.admin')

@section('title', $store->exists ? 'Edit Store' : 'Add Store')

@section('content')
<h1 style="margin-bottom:1.5rem;">{{ $store->exists ? 'Edit' : 'Add' }} Store</h1>
<form method="POST" enctype="multipart/form-data" action="{{ $store->exists ? route('admin.stores.update', $store) : route('admin.stores.store') }}">
    @csrf
    @if($store->exists) @method('PUT') @endif
    <div class="form-group"><label>Name *</label><input name="name" value="{{ old('name', $store->name) }}" required></div>
    <div class="form-group">
        <label>Logo</label>
        @if($store->logoUrl())
            <div class="admin-image-preview">
                <img src="{{ $store->logoUrl() }}" alt="{{ $store->name }}" class="admin-preview-img">
            </div>
        @endif
        <input type="file" name="logo_file" accept="image/*" style="margin-top:.5rem;">
        <p class="form-hint">Upload JPG, PNG or WebP (max 2MB). Or paste an external URL below.</p>
        <input name="logo" value="{{ old('logo', $store->hasStoredLogo() ? '' : $store->logo) }}" placeholder="https://example.com/logo.png" style="margin-top:.5rem;">
    </div>
    <div class="form-group"><label>Website</label><input type="url" name="website" value="{{ old('website', $store->website) }}"></div>
    <div class="form-group"><label>Description</label><textarea name="description" rows="3">{{ old('description', $store->description) }}</textarea></div>
    <div class="form-group"><label>Sort order</label><input type="number" name="sort_order" value="{{ old('sort_order', $store->sort_order ?? 0) }}"></div>
    <div class="form-check">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $store->is_active ?? true))>
        <label>Active</label>
    </div>
    <button type="submit" class="btn btn-primary" style="margin-top:1rem;">Save</button>
</form>
@endsection
