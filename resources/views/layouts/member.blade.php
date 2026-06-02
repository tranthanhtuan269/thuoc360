<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title') — My Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="admin-layout">
    <aside class="admin-sidebar">
        <p style="font-weight:700;margin-bottom:1rem;">{{ config('site.name') }}</p>
        <p style="font-size:.85rem;opacity:.85;margin-bottom:1rem;">{{ auth()->user()->name }}</p>
        <a href="{{ route('member.dashboard') }}">Dashboard</a>
        <a href="{{ route('member.coupons.index') }}">My Coupons</a>
        <a href="{{ route('member.stores.index') }}">My Stores</a>
        <a href="{{ route('member.posts.index') }}">My Blog</a>
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
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @yield('content')
    </main>
</div>
</body>
</html>
