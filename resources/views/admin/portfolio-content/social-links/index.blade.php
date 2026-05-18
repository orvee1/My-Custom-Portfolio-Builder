@extends('layouts.admin')

@section('title', 'Social Links')

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Social Links</h1>
            <p class="text-sm text-gray-500">Manage public social links for {{ $portfolio->full_name }}.</p>
        </div>

        @include('admin.portfolio-content.partials.nav', ['portfolio' => $portfolio])

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900">Add Social Link</h2>

            <form method="POST" action="{{ route('admin.portfolios.social-links.store', $portfolio) }}"
                class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-5">
                @csrf
                <input type="hidden" name="is_enabled" value="0">

                <input name="platform" placeholder="github" class="rounded-lg border-gray-300 text-sm">
                <input name="label" placeholder="GitHub" class="rounded-lg border-gray-300 text-sm">
                <input name="url" placeholder="https://github.com/username"
                    class="rounded-lg border-gray-300 text-sm md:col-span-2">
                <input type="number" name="sort_order" value="0" class="rounded-lg border-gray-300 text-sm">

                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="checkbox" name="is_enabled" value="1" checked>
                    Enabled
                </label>

                <button class="rounded-lg bg-indigo-600 px-5 py-2 text-sm font-semibold text-white md:col-span-4">
                    Add Social Link
                </button>
            </form>
        </div>

        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">Platform</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">URL</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($socialLinks as $socialLink)
                        <tr>
                            <td class="px-4 py-4 font-medium text-gray-900">
                                {{ $socialLink->label ?: ucfirst($socialLink->platform) }}</td>
                            <td class="px-4 py-4 text-sm text-gray-600">
                                <a href="{{ $socialLink->url }}" target="_blank"
                                    class="text-indigo-600">{{ $socialLink->url }}</a>
                            </td>
                            <td class="px-4 py-4">
                                <span
                                    class="rounded-full px-2 py-1 text-xs font-semibold {{ $socialLink->is_enabled ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $socialLink->is_enabled ? 'Enabled' : 'Disabled' }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.portfolios.social-links.edit', [$portfolio, $socialLink]) }}"
                                        class="rounded-lg border px-3 py-1.5 text-xs font-semibold">Edit</a>

                                    <form method="POST"
                                        action="{{ route('admin.portfolios.social-links.destroy', [$portfolio, $socialLink]) }}"
                                        onsubmit="return confirm('Delete this link?')">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="rounded-lg border border-red-300 px-3 py-1.5 text-xs font-semibold text-red-700">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-10 text-center text-sm text-gray-500">No social links found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="border-t px-4 py-4">
                {{ $socialLinks->links() }}
            </div>
        </div>
    </div>
@endsection
