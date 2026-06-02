@extends('layouts.admin')

@section('title', $coupon->exists ? 'Edit Coupon' : 'Add Coupon')

@section('content')
<h1 style="margin-bottom:1.5rem;">{{ $coupon->exists ? 'Edit' : 'Add' }} Coupon</h1>
<form method="POST" action="{{ $coupon->exists ? route('admin.coupons.update', $coupon) : route('admin.coupons.store') }}">
    @csrf
    @if($coupon->exists) @method('PUT') @endif

    <div class="form-group">
        <label>Store *</label>
        <select name="store_id" required>
            @foreach($stores as $s)
                <option value="{{ $s->id }}" @selected(old('store_id', $coupon->store_id) == $s->id)>{{ $s->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Title *</label>
        <input type="text" name="title" value="{{ old('title', $coupon->title) }}" required>
    </div>
    <div class="form-group">
        <label>Description</label>
        <textarea name="description" rows="3">{{ old('description', $coupon->description) }}</textarea>
    </div>
    <div class="form-group">
        <label>Promo code (leave blank for deals without a code)</label>
        <input type="text" name="code" value="{{ old('code', $coupon->code) }}">
    </div>
    <div class="form-group">
        <label>Type *</label>
        <select name="type" required>
            <option value="coupon" @selected(old('type', $coupon->type) === 'coupon')>Coupon (with code)</option>
            <option value="discount" @selected(old('type', $coupon->type) === 'discount')>Discount (deal)</option>
        </select>
    </div>
    <div class="form-group">
        <label>Discount type</label>
        <select name="discount_type">
            <option value="">—</option>
            <option value="percent" @selected(old('discount_type', $coupon->discount_type) === 'percent')>Percentage</option>
            <option value="fixed" @selected(old('discount_type', $coupon->discount_type) === 'fixed')>Fixed amount ($)</option>
            <option value="free_shipping" @selected(old('discount_type', $coupon->discount_type) === 'free_shipping')>Free shipping</option>
            <option value="other" @selected(old('discount_type', $coupon->discount_type) === 'other')>Other</option>
        </select>
    </div>
    <div class="form-group">
        <label>Discount value</label>
        <input type="number" name="discount_value" step="0.01" value="{{ old('discount_value', $coupon->discount_value) }}">
    </div>
    <div class="form-group">
        <label>Affiliate / shop URL</label>
        <input type="url" name="affiliate_url" value="{{ old('affiliate_url', $coupon->affiliate_url) }}">
    </div>
    <div class="form-group">
        <label>Starts at</label>
        <input type="datetime-local" name="starts_at" value="{{ old('starts_at', $coupon->starts_at?->format('Y-m-d\TH:i')) }}">
    </div>
    <div class="form-group">
        <label>Expires at</label>
        <input type="datetime-local" name="expires_at" value="{{ old('expires_at', $coupon->expires_at?->format('Y-m-d\TH:i')) }}">
    </div>
    <div class="form-check">
        <input type="checkbox" name="is_featured" value="1" id="featured" @checked(old('is_featured', $coupon->is_featured))>
        <label for="featured">Featured</label>
    </div>
    <div class="form-check">
        <input type="checkbox" name="is_active" value="1" id="active" @checked(old('is_active', $coupon->is_active ?? true))>
        <label for="active">Active</label>
    </div>
    <button type="submit" class="btn btn-primary" style="margin-top:1rem;">Save</button>
    <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline">Cancel</a>
</form>
@endsection
