@extends('layouts.admin')

@section('title', $category->exists ? 'Edit Category' : 'Add Category')

@section('content')
<h1 style="margin-bottom:1.5rem;">{{ $category->exists ? 'Edit' : 'Add' }} Category</h1>
<form method="POST" action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}">
    @csrf
    @if($category->exists) @method('PUT') @endif
    <div class="form-group"><label>Name *</label><input name="name" value="{{ old('name', $category->name) }}" required></div>
    <div class="form-group"><label>Icon (emoji)</label><input name="icon" value="{{ old('icon', $category->icon) }}" placeholder="🛒"></div>
    <div class="form-group"><label>Description</label><textarea name="description" rows="3">{{ old('description', $category->description) }}</textarea></div>
    <div class="form-group"><label>Sort order</label><input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}"></div>
    <div class="form-check">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active ?? true))>
        <label>Active</label>
    </div>
    <button type="submit" class="btn btn-primary" style="margin-top:1rem;">Save</button>
</form>
@endsection
