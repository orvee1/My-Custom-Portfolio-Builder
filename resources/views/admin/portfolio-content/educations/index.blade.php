@extends('layouts.admin')

@section('title', 'Educations')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Educations</h1>
                <p class="text-sm text-gray-500">
                    Manage education history for {{ $portfolio->full_name }}.
                </p>
            </div>

            <a href="{{ route('admin.portfolios.edit', $portfolio) }}"
                class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                Back to Portfolio
            </a>
        </div>

        @include('admin.portfolio-content.partials.nav', ['portfolio' => $portfolio])

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900">Add Education</h2>

            <form method="POST" action="{{ route('admin.portfolios.educations.store', $portfolio) }}"
                enctype="multipart/form-data" class="mt-6 space-y-6">
                @csrf

                <input type="hidden" name="is_current" value="0">
                <input type="hidden" name="is_enabled" value="0">

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">
                            Institution Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="institution_name" value="{{ old('institution_name') }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('institution_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Degree</label>
                        <input type="text" name="degree" value="{{ old('degree') }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('degree')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Field of Study</label>
                        <input type="text" name="field_of_study" value="{{ old('field_of_study') }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('field_of_study')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Grade</label>
                        <input type="text" name="grade" value="{{ old('grade') }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('grade')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" name="start_date" value="{{ old('start_date') }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">End Date</label>
                        <input type="date" name="end_date" value="{{ old('end_date') }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('end_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Institution Logo</label>
                        <input type="file" name="institution_logo" accept="image/*"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                        @error('institution_logo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Sort Order</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('sort_order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" rows="4"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2 flex flex-wrap gap-5">
                        <label class="inline-flex items-center gap-2 text-sm font-medium text-gray-700">
                            <input type="checkbox" name="is_current" value="1" @checked(old('is_current', false))
                                class="rounded border-gray-300 text-indigo-600">
                            Current Study
                        </label>

                        <label class="inline-flex items-center gap-2 text-sm font-medium text-gray-700">
                            <input type="checkbox" name="is_enabled" value="1" @checked(old('is_enabled', true))
                                class="rounded border-gray-300 text-indigo-600">
                            Enabled
                        </label>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="rounded-lg bg-indigo-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
                        Add Education
                    </button>
                </div>
            </form>
        </div>

        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Institution</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Degree</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Period</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Sort</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($educations as $education)
                            <tr>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        @if ($education->institution_logo)
                                            <img src="{{ Storage::url($education->institution_logo) }}"
                                                class="h-12 w-12 rounded-lg object-cover"
                                                alt="{{ $education->institution_name }}">
                                        @else
                                            <div
                                                class="flex h-12 w-12 items-center justify-center rounded-lg bg-gray-100 text-sm font-bold text-gray-400">
                                                {{ strtoupper(substr($education->institution_name, 0, 1)) }}
                                            </div>
                                        @endif

                                        <div>
                                            <div class="font-medium text-gray-900">{{ $education->institution_name }}</div>
                                            <div class="text-xs text-gray-500">{{ $education->field_of_study ?: '-' }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-4 py-4 text-sm text-gray-600">
                                    {{ $education->degree ?: '-' }}
                                </td>

                                <td class="px-4 py-4 text-sm text-gray-600">
                                    {{ $education->start_date?->format('M Y') ?: 'N/A' }}
                                    -
                                    {{ $education->is_current ? 'Present' : ($education->end_date?->format('M Y') ?: 'N/A') }}
                                </td>

                                <td class="px-4 py-4">
                                    <span
                                        class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $education->is_enabled ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $education->is_enabled ? 'Enabled' : 'Disabled' }}
                                    </span>
                                </td>

                                <td class="px-4 py-4 text-sm text-gray-600">
                                    {{ $education->sort_order }}
                                </td>

                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.portfolios.educations.edit', [$portfolio, $education]) }}"
                                            class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50">
                                            Edit
                                        </a>

                                        <form method="POST"
                                            action="{{ route('admin.portfolios.educations.destroy', [$portfolio, $education]) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this education entry?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="rounded-lg border border-red-300 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-50">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-sm text-gray-500">
                                    No education entries found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-gray-200 px-4 py-4">
                {{ $educations->links() }}
            </div>
        </div>
    </div>
@endsection
