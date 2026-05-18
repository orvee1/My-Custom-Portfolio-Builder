@extends('layouts.admin')

@section('title', 'Edit Skill')

@section('content')
    <div class="mx-auto max-w-3xl space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Skill</h1>
            <p class="text-sm text-gray-500">{{ $portfolio->full_name }}</p>
        </div>

        @include('admin.portfolio-content.partials.nav', ['portfolio' => $portfolio])

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <form method="POST" action="{{ route('admin.portfolios.skills.update', [$portfolio, $skill]) }}"
                class="space-y-5">
                @csrf
                @method('PUT')

                <input type="hidden" name="is_highlighted" value="0">
                <input type="hidden" name="is_enabled" value="0">

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Name *</label>
                    <input name="name" value="{{ old('name', $skill->name) }}"
                        class="w-full rounded-lg border-gray-300 text-sm">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Category</label>
                    <input name="category" value="{{ old('category', $skill->category) }}"
                        class="w-full rounded-lg border-gray-300 text-sm">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Proficiency</label>
                        <input type="number" name="proficiency" min="1" max="100"
                            value="{{ old('proficiency', $skill->proficiency) }}"
                            class="w-full rounded-lg border-gray-300 text-sm">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Years</label>
                        <input type="number" step="0.1" name="years_of_experience"
                            value="{{ old('years_of_experience', $skill->years_of_experience) }}"
                            class="w-full rounded-lg border-gray-300 text-sm">
                    </div>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Icon</label>
                    <input name="icon" value="{{ old('icon', $skill->icon) }}"
                        class="w-full rounded-lg border-gray-300 text-sm">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $skill->sort_order) }}"
                        class="w-full rounded-lg border-gray-300 text-sm">
                </div>

                <div class="flex gap-5">
                    <label class="inline-flex items-center gap-2 text-sm">
                        <input type="checkbox" name="is_highlighted" value="1" @checked(old('is_highlighted', $skill->is_highlighted))>
                        Highlight
                    </label>

                    <label class="inline-flex items-center gap-2 text-sm">
                        <input type="checkbox" name="is_enabled" value="1" @checked(old('is_enabled', $skill->is_enabled))>
                        Enabled
                    </label>
                </div>

                <div class="flex gap-3">
                    <button class="rounded-lg bg-indigo-600 px-5 py-2 text-sm font-semibold text-white">Update
                        Skill</button>
                    <a href="{{ route('admin.portfolios.skills.index', $portfolio) }}"
                        class="rounded-lg border px-5 py-2 text-sm font-semibold">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
