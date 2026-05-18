@extends('layouts.admin')

@section('title', 'Edit Social Link')

@section('content')
    <div class="mx-auto max-w-3xl space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Social Link</h1>
            <p class="text-sm text-gray-500">{{ $portfolio->full_name }}</p>
        </div>

        @include('admin.portfolio-content.partials.nav', ['portfolio' => $portfolio])

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <form method="POST" action="{{ route('admin.portfolios.social-links.update', [$portfolio, $socialLink]) }}"
                class="space-y-5">
                @csrf
                @method('PUT')

                <input type="hidden" name="is_enabled" value="0">

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Platform *</label>
                    <input name="platform" value="{{ old('platform', $socialLink->platform) }}"
                        class="w-full rounded-lg border-gray-300 text-sm">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Label</label>
                    <input name="label" value="{{ old('label', $socialLink->label) }}"
                        class="w-full rounded-lg border-gray-300 text-sm">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">URL *</label>
                    <input name="url" value="{{ old('url', $socialLink->url) }}"
                        class="w-full rounded-lg border-gray-300 text-sm">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $socialLink->sort_order) }}"
                        class="w-full rounded-lg border-gray-300 text-sm">
                </div>

                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="checkbox" name="is_enabled" value="1" @checked(old('is_enabled', $socialLink->is_enabled))>
                    Enabled
                </label>

                <div class="flex gap-3">
                    <button class="rounded-lg bg-indigo-600 px-5 py-2 text-sm font-semibold text-white">Update Link</button>
                    <a href="{{ route('admin.portfolios.social-links.index', $portfolio) }}"
                        class="rounded-lg border px-5 py-2 text-sm font-semibold">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
