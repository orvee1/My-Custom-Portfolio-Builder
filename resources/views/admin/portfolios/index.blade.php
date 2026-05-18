@extends('layouts.admin')

@section('title', 'Portfolios')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Portfolios</h1>
                <p class="text-sm text-gray-500">Monitor and manage admin portfolio pages.</p>
            </div>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
            <form method="GET" action="{{ route('admin.portfolios.index') }}" class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Name, title, slug, email"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Status</label>
                    <select name="status"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        <option value="">All</option>
                        <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                        <option value="published" @selected(request('status') === 'published')>Published</option>
                        <option value="archived" @selected(request('status') === 'archived')>Archived</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-black">
                        Filter
                    </button>

                    <a href="{{ route('admin.portfolios.index') }}"
                        class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Owner</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Portfolio</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Slug</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Updated</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($portfolios as $portfolio)
                            <tr>
                                <td class="px-4 py-4">
                                    <div class="font-medium text-gray-900">{{ $portfolio->user?->name ?? 'Unknown' }}</div>
                                    <div class="text-xs text-gray-500">{{ $portfolio->user?->email }}</div>
                                </td>

                                <td class="px-4 py-4">
                                    <div class="font-medium text-gray-900">{{ $portfolio->portfolio_title }}</div>
                                    <div class="text-xs text-gray-500">{{ $portfolio->profession_title }}</div>
                                </td>

                                <td class="px-4 py-4 text-sm text-gray-600">
                                    /p/{{ $portfolio->slug }}
                                </td>

                                <td class="px-4 py-4">
                                    <span
                                        class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold
                                    {{ $portfolio->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ ucfirst($portfolio->status) }}
                                    </span>
                                </td>

                                <td class="px-4 py-4 text-sm text-gray-600">
                                    {{ $portfolio->updated_at?->format('d M Y, h:i A') }}
                                </td>

                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.portfolios.edit', $portfolio) }}"
                                            class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50">
                                            Edit
                                        </a>

                                        <a href="{{ route('admin.portfolios.preview', $portfolio) }}" target="_blank"
                                            class="rounded-lg border border-indigo-300 px-3 py-1.5 text-xs font-semibold text-indigo-700 hover:bg-indigo-50">
                                            Preview
                                        </a>

                                        @if ($portfolio->isPublished())
                                            <a href="{{ $portfolio->publicUrl() }}" target="_blank"
                                                class="rounded-lg border border-green-300 px-3 py-1.5 text-xs font-semibold text-green-700 hover:bg-green-50">
                                                Public
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-sm text-gray-500">
                                    No portfolios found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-gray-200 px-4 py-4">
                {{ $portfolios->links() }}
            </div>
        </div>
    </div>
@endsection
