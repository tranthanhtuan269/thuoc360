<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') — Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>
<div class="admin-layout">
    <aside class="admin-sidebar">
        <p style="font-weight:700;margin-bottom:1rem;">{{ config('site.name') }} Admin</p>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.coupons.index') }}">Coupons</a>
        <a href="{{ route('admin.stores.index') }}">Stores</a>
        <a href="{{ route('admin.categories.index') }}">Categories</a>
        <a href="{{ route('admin.posts.index') }}">Blog Posts</a>
        <hr style="border-color:rgba(255,255,255,.2);margin:1rem 0;">
        <a href="{{ route('home') }}">← Back to site</a>
        <form action="{{ route('logout') }}" method="POST" style="margin-top:.5rem;">
            @csrf
            <button type="submit" style="background:none;border:none;color:rgba(255,255,255,.85);cursor:pointer;padding:.6rem .75rem;">Sign Out</button>
        </form>
    </aside>
    <main class="admin-main">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @yield('content')
    </main>
</div>
@stack('scripts')
</body>
</html>
