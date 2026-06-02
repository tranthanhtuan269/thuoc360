@extends('layouts.admin')

@section('title', 'Blog Posts')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
    <h1>Blog Posts</h1>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">+ New Post</a>
</div>
<table class="admin-table">
    <thead>
        <tr>
            <th>Image</th>
            <th>Title</th>
            <th>Status</th>
            <th>Published</th>
            <th>Views</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($posts as $post)
        <tr>
            <td>
                @if($post->featuredImageUrl())
                    <img src="{{ $post->featuredImageUrl() }}" alt="" class="admin-thumb admin-thumb--wide" loading="lazy">
                @else
                    <span class="admin-thumb-empty">—</span>
                @endif
            </td>
            <td>
                <a href="{{ $post->is_published ? route('blog.show', $post->slug) : '#' }}" target="_blank">
                    {{ $post->title }}
                </a>
            </td>
            <td>{{ $post->is_published ? 'Published' : 'Draft' }}</td>
            <td>{{ $post->published_at?->format('m/d/Y') ?? '—' }}</td>
            <td>{{ number_format($post->view_count) }}</td>
            <td>
                <a href="{{ route('admin.posts.edit', $post) }}">Edit</a>
                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this post?')">
                    @csrf @method('DELETE')
                    <button type="submit" style="background:none;border:none;color:red;cursor:pointer;">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $posts->links() }}
@endsection
