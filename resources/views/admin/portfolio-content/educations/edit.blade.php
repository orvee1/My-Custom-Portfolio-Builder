@extends('layouts.admin')

@section('title', 'Edit Education')

@section('content')
    <div class="mx-auto max-w-5xl space-y-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Education</h1>
                <p class="text-sm text-gray-500">
                    Update education information for {{ $portfolio->full_name }}.
                </p>
            </div>

            <a href="{{ route('admin.portfolios.educations.index', $portfolio) }}"
                class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                Back to Educations
            </a>
        </div>

        @include('admin.portfolio-content.partials.nav', ['portfolio' => $portfolio])

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <form method="POST" action="{{ route('admin.portfolios.educations.update', [$portfolio, $education]) }}"
                enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <input type="hidden" name="is_current" value="0">
                <input type="hidden" name="is_enabled" value="0">

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">
                            Institution Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="institution_name"
                            value="{{ old('institution_name', $education->institution_name) }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('institution_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Degree</label>
                        <input type="text" name="degree" value="{{ old('degree', $education->degree) }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('degree')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Field of Study</label>
                        <input type="text" name="field_of_study"
                            value="{{ old('field_of_study', $education->field_of_study) }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('field_of_study')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Grade</label>
                        <input type="text" name="grade" value="{{ old('grade', $education->grade) }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('grade')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" name="start_date"
                            value="{{ old('start_date', $education->start_date?->format('Y-m-d')) }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">End Date</label>
                        <input type="date" name="end_date"
                            value="{{ old('end_date', $education->end_date?->format('Y-m-d')) }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('end_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Institution Logo</label>

                        @if ($education->institution_logo)
                            <img src="{{ Storage::url($education->institution_logo) }}"
                                class="mb-3 h-24 w-24 rounded-lg object-cover" alt="{{ $education->institution_name }}">
                        @endif

                        <input type="file" name="institution_logo" accept="image/*"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                        @error('institution_logo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Sort Order</label>
                        <input type="number" name="sort_order"
                            value="{{ old('sort_order', $education->sort_order) }}" min="0"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('sort_order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" rows="4"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">{{ old('description', $education->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2 flex flex-wrap gap-5">
                        <label class="inline-flex items-center gap-2 text-sm font-medium text-gray-700">
                            <input type="checkbox" name="is_current" value="1" @checked(old('is_current', $education->is_current))
                                class="rounded border-gray-300 text-indigo-600">
                            Current Study
                        </label>

                        <label class="inline-flex items-center gap-2 text-sm font-medium text-gray-700">
                            <input type="checkbox" name="is_enabled" value="1" @checked(old('is_enabled', $education->is_enabled))
                                class="rounded border-gray-300 text-indigo-600">
                            Enabled
                        </label>
                    </div>
                </div>

                <div class="flex flex-wrap justify-end gap-3">
                    <a href="{{ route('admin.portfolios.educations.index', $portfolio) }}"
                        class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                        Cancel
                    </a>

                    <button type="submit"
                        class="rounded-lg bg-indigo-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
                        Update Education
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
