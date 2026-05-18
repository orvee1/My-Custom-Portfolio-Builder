@extends('layouts.admin')

@section('title', 'Experiences')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Experiences</h1>
                <p class="text-sm text-gray-500">
                    Manage work experience for {{ $portfolio->full_name }}.
                </p>
            </div>

            <a href="{{ route('admin.portfolios.edit', $portfolio) }}"
                class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                Back to Portfolio
            </a>
        </div>

        @include('admin.portfolio-content.partials.nav', ['portfolio' => $portfolio])

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900">Add Experience</h2>

            <form method="POST" action="{{ route('admin.portfolios.experiences.store', $portfolio) }}"
                enctype="multipart/form-data" class="mt-6 space-y-6">
                @csrf

                <input type="hidden" name="is_current" value="0">
                <input type="hidden" name="is_enabled" value="0">

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">
                            Company Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="company_name" value="{{ old('company_name') }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('company_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">
                            Job Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="job_title" value="{{ old('job_title') }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('job_title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Employment Type</label>
                        <input type="text" name="employment_type" value="{{ old('employment_type') }}"
                            placeholder="Full-time, Contract, Internship"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('employment_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Location</label>
                        <input type="text" name="location" value="{{ old('location') }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('location')
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
                        <label class="mb-1 block text-sm font-medium text-gray-700">Company Logo</label>
                        <input type="file" name="company_logo" accept="image/*"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                        @error('company_logo')
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
                        <label class="mb-1 block text-sm font-medium text-gray-700">Summary</label>
                        <textarea name="summary" rows="4"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">{{ old('summary') }}</textarea>
                        @error('summary')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-gray-700">Achievements</label>
                        <textarea name="achievements_text" rows="5" placeholder="Led the redesign project&#10;Improved deployment workflow"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">{{ old('achievements_text') }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">One achievement per line.</p>
                        @error('achievements_text')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2 flex flex-wrap gap-5">
                        <label class="inline-flex items-center gap-2 text-sm font-medium text-gray-700">
                            <input type="checkbox" name="is_current" value="1" @checked(old('is_current', false))
                                class="rounded border-gray-300 text-indigo-600">
                            Current Role
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
                        Add Experience
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
                                Company</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Role</th>
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
                        @forelse($experiences as $experience)
                            <tr>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        @if ($experience->company_logo)
                                            <img src="{{ Storage::url($experience->company_logo) }}"
                                                class="h-12 w-12 rounded-lg object-cover"
                                                alt="{{ $experience->company_name }}">
                                        @else
                                            <div
                                                class="flex h-12 w-12 items-center justify-center rounded-lg bg-gray-100 text-sm font-bold text-gray-400">
                                                {{ strtoupper(substr($experience->company_name, 0, 1)) }}
                                            </div>
                                        @endif

                                        <div>
                                            <div class="font-medium text-gray-900">{{ $experience->company_name }}</div>
                                            <div class="text-xs text-gray-500">{{ $experience->location ?: '-' }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-4 py-4 text-sm text-gray-600">
                                    {{ $experience->job_title }}
                                </td>

                                <td class="px-4 py-4 text-sm text-gray-600">
                                    {{ $experience->start_date?->format('M Y') ?: 'N/A' }}
                                    -
                                    {{ $experience->is_current ? 'Present' : ($experience->end_date?->format('M Y') ?: 'N/A') }}
                                </td>

                                <td class="px-4 py-4">
                                    <span
                                        class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $experience->is_enabled ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $experience->is_enabled ? 'Enabled' : 'Disabled' }}
                                    </span>
                                </td>

                                <td class="px-4 py-4 text-sm text-gray-600">
                                    {{ $experience->sort_order }}
                                </td>

                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.portfolios.experiences.edit', [$portfolio, $experience]) }}"
                                            class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50">
                                            Edit
                                        </a>

                                        <form method="POST"
                                            action="{{ route('admin.portfolios.experiences.destroy', [$portfolio, $experience]) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this experience entry?')">
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
                                    No experience entries found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-gray-200 px-4 py-4">
                {{ $experiences->links() }}
            </div>
        </div>
    </div>
@endsection
