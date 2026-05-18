@extends('layouts.admin')

@section('title', 'Skills')

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Skills</h1>
            <p class="text-sm text-gray-500">Manage skills for {{ $portfolio->full_name }}.</p>
        </div>

        @include('admin.portfolio-content.partials.nav', ['portfolio' => $portfolio])

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900">Add Skill</h2>

            <form method="POST" action="{{ route('admin.portfolios.skills.store', $portfolio) }}"
                class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-4">
                @csrf

                <input type="hidden" name="is_highlighted" value="0">
                <input type="hidden" name="is_enabled" value="0">

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Category</label>
                    <input name="category" value="{{ old('category') }}" class="w-full rounded-lg border-gray-300 text-sm">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Name *</label>
                    <input name="name" value="{{ old('name') }}" class="w-full rounded-lg border-gray-300 text-sm">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Proficiency</label>
                    <input type="number" name="proficiency" min="1" max="100" value="{{ old('proficiency') }}"
                        class="w-full rounded-lg border-gray-300 text-sm">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Sort</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}"
                        class="w-full rounded-lg border-gray-300 text-sm">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Years</label>
                    <input type="number" step="0.1" name="years_of_experience" value="{{ old('years_of_experience') }}"
                        class="w-full rounded-lg border-gray-300 text-sm">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Icon</label>
                    <input name="icon" value="{{ old('icon') }}" placeholder="Laravel / ⚡ / icon class"
                        class="w-full rounded-lg border-gray-300 text-sm">
                </div>

                <div class="flex items-center gap-4 pt-6">
                    <label class="inline-flex items-center gap-2 text-sm">
                        <input type="checkbox" name="is_highlighted" value="1" class="rounded border-gray-300">
                        Highlight
                    </label>

                    <label class="inline-flex items-center gap-2 text-sm">
                        <input type="checkbox" name="is_enabled" value="1" checked class="rounded border-gray-300">
                        Enabled
                    </label>
                </div>

                <div class="flex items-end">
                    <button class="rounded-lg bg-indigo-600 px-5 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                        Add Skill
                    </button>
                </div>
            </form>
        </div>

        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">Skill</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">Category</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">Proficiency</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($skills as $skill)
                        <tr>
                            <td class="px-4 py-4 font-medium text-gray-900">{{ $skill->name }}</td>
                            <td class="px-4 py-4 text-sm text-gray-600">{{ $skill->category }}</td>
                            <td class="px-4 py-4 text-sm text-gray-600">
                                {{ $skill->proficiency ? $skill->proficiency . '%' : '-' }}</td>
                            <td class="px-4 py-4">
                                <span
                                    class="rounded-full px-2 py-1 text-xs font-semibold {{ $skill->is_enabled ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $skill->is_enabled ? 'Enabled' : 'Disabled' }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.portfolios.skills.edit', [$portfolio, $skill]) }}"
                                        class="rounded-lg border px-3 py-1.5 text-xs font-semibold">Edit</a>

                                    <form method="POST"
                                        action="{{ route('admin.portfolios.skills.destroy', [$portfolio, $skill]) }}"
                                        onsubmit="return confirm('Delete this skill?')">
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
                            <td colspan="5" class="px-4 py-10 text-center text-sm text-gray-500">No skills found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="border-t px-4 py-4">
                {{ $skills->links() }}
            </div>
        </div>
    </div>
@endsection
