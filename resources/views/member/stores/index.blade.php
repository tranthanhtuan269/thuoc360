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
            <th>Category</th>
            <th>Coupons</th>
            <th>Page views</th>
            <th class="table-actions-col">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($stores as $store)
        @php $publicUrl = route('stores.show', $store->slug); @endphp
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
                @if($store->category)
                    <span>{{ $store->category->icon }} {{ $store->category->name }}</span>
                @else
                    <span class="text-muted">—</span>
                @endif
            </td>
            <td>{{ $store->coupons_count }}</td>
            <td><strong>{{ number_format($store->view_count) }}</strong></td>
            <td>
                <div class="table-actions">
                    @if($store->is_active)
                        <a href="{{ $publicUrl }}" class="table-action-btn" target="_blank" rel="noopener" title="View public page" aria-label="View public page">
                            @include('partials.icons.eye')
                        </a>
                    @else
                        <span class="table-action-btn is-disabled" title="Store is inactive" aria-label="Store is inactive">
                            @include('partials.icons.eye')
                        </span>
                    @endif
                    <button
                        type="button"
                        class="table-action-btn js-copy-link"
                        data-copy-url="{{ $publicUrl }}"
                        title="Copy store link"
                        aria-label="Copy store link"
                    >
                        @include('partials.icons.copy')
                    </button>
                    <a href="{{ route('member.stores.edit', $store) }}" class="table-action-btn" title="Edit store" aria-label="Edit store">
                        @include('partials.icons.edit')
                    </a>
                    <form action="{{ route('member.stores.destroy', $store) }}" method="POST" class="table-action-form" onsubmit="return confirm('Delete this store and its coupons?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="table-action-btn table-action-btn-danger" title="Delete store" aria-label="Delete store">
                            @include('partials.icons.trash')
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="6">No stores yet. <a href="{{ route('member.stores.create') }}">Add your first store</a>.</td></tr>
        @endforelse
    </tbody>
</table>
{{ $stores->links() }}
@endsection

@once
    @push('styles')
        <style>
            .table-actions-col { width: 9rem; text-align: right; }
            .table-actions {
                display: flex;
                align-items: center;
                justify-content: flex-end;
                gap: .25rem;
            }
            .table-action-form { display: inline; margin: 0; }
            .table-action-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 2rem;
                height: 2rem;
                padding: 0;
                border: none;
                border-radius: 6px;
                background: transparent;
                color: #475569;
                cursor: pointer;
                text-decoration: none;
                transition: background .15s, color .15s;
            }
            .table-action-btn:hover:not(.is-disabled):not(:disabled) {
                background: #f1f5f9;
                color: #0f172a;
            }
            .table-action-btn.is-disabled {
                opacity: .35;
                cursor: not-allowed;
            }
            .table-action-btn-danger:hover {
                background: #fef2f2;
                color: #dc2626;
            }
            .table-action-btn.is-copied {
                color: #16a34a;
            }
            .text-muted { color: #94a3b8; }
        </style>
    @endpush
    @push('scripts')
        <script>
            document.addEventListener('click', function (e) {
                var btn = e.target.closest('.js-copy-link');
                if (!btn) return;

                var url = btn.getAttribute('data-copy-url');
                if (!url) return;

                function markCopied() {
                    btn.classList.add('is-copied');
                    btn.setAttribute('title', 'Copied!');
                    setTimeout(function () {
                        btn.classList.remove('is-copied');
                        btn.setAttribute('title', 'Copy store link');
                    }, 2000);
                }

                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(url).then(markCopied).catch(function () {
                        window.prompt('Copy this link:', url);
                    });
                } else {
                    window.prompt('Copy this link:', url);
                    markCopied();
                }
            });
        </script>
    @endpush
@endonce
