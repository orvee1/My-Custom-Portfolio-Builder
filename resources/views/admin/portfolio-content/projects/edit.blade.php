@extends('layouts.admin')

@section('title', 'Edit Project')

@section('content')
    @php
        $techStackText = old(
            'tech_stack_text',
            is_array($project->tech_stack) ? implode("\n", $project->tech_stack) : '',
        );
        $metricsText = old('metrics_text', is_array($project->metrics) ? implode("\n", $project->metrics) : '');
    @endphp

    <div class="mx-auto max-w-5xl space-y-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Project</h1>
                <p class="text-sm text-gray-500">
                    Update project information for {{ $portfolio->full_name }}.
                </p>
            </div>

            <a href="{{ route('admin.portfolios.projects.index', $portfolio) }}"
                class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                Back to Projects
            </a>
        </div>

        @include('admin.portfolio-content.partials.nav', ['portfolio' => $portfolio])

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <form method="POST" action="{{ route('admin.portfolios.projects.update', [$portfolio, $project]) }}"
                enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <input type="hidden" name="is_featured" value="0">
                <input type="hidden" name="is_enabled" value="0">

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">
                            Project Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" value="{{ old('title', $project->title) }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">
                            Slug <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="slug" value="{{ old('slug', $project->slug) }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Project Type</label>
                        <input type="text" name="project_type" value="{{ old('project_type', $project->project_type) }}"
                            placeholder="Web App, SaaS, Mobile App"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('project_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Category</label>
                        <input type="text" name="category" value="{{ old('category', $project->category) }}"
                            placeholder="Laravel, UI/UX, E-commerce"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('category')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Client Name</label>
                        <input type="text" name="client_name" value="{{ old('client_name', $project->client_name) }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('client_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Sort Order</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $project->sort_order) }}"
                            min="0"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('sort_order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Started At</label>
                        <input type="date" name="started_at"
                            value="{{ old('started_at', $project->started_at?->format('Y-m-d')) }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('started_at')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Ended At</label>
                        <input type="date" name="ended_at"
                            value="{{ old('ended_at', $project->ended_at?->format('Y-m-d')) }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('ended_at')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-gray-700">Short Description</label>
                        <textarea name="short_description" rows="3"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">{{ old('short_description', $project->short_description) }}</textarea>
                        @error('short_description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-gray-700">Long Description</label>
                        <textarea name="long_description" rows="5"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">{{ old('long_description', $project->long_description) }}</textarea>
                        @error('long_description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Problem Statement</label>
                        <textarea name="problem_statement" rows="4"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">{{ old('problem_statement', $project->problem_statement) }}</textarea>
                        @error('problem_statement')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Solution Summary</label>
                        <textarea name="solution_summary" rows="4"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">{{ old('solution_summary', $project->solution_summary) }}</textarea>
                        @error('solution_summary')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-gray-700">Result Summary</label>
                        <textarea name="result_summary" rows="4"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">{{ old('result_summary', $project->result_summary) }}</textarea>
                        @error('result_summary')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Project URL</label>
                        <input type="url" name="project_url" value="{{ old('project_url', $project->project_url) }}"
                            placeholder="https://example.com"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('project_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">GitHub URL</label>
                        <input type="url" name="github_url" value="{{ old('github_url', $project->github_url) }}"
                            placeholder="https://github.com/..."
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('github_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Figma URL</label>
                        <input type="url" name="figma_url" value="{{ old('figma_url', $project->figma_url) }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('figma_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Case Study URL</label>
                        <input type="url" name="case_study_url"
                            value="{{ old('case_study_url', $project->case_study_url) }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('case_study_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Thumbnail</label>

                        @if ($project->thumbnail)
                            <img src="{{ Storage::url($project->thumbnail) }}"
                                class="mb-3 h-28 w-40 rounded-lg object-cover" alt="{{ $project->title }}">
                        @endif

                        <input type="file" name="thumbnail" accept="image/*"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                        @error('thumbnail')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Banner Image</label>

                        @if ($project->banner_image)
                            <img src="{{ Storage::url($project->banner_image) }}"
                                class="mb-3 h-28 w-full rounded-lg object-cover" alt="{{ $project->title }}">
                        @endif

                        <input type="file" name="banner_image" accept="image/*"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                        @error('banner_image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Tech Stack</label>
                        <textarea name="tech_stack_text" rows="5" placeholder="Laravel&#10;Tailwind CSS&#10;MySQL"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">{{ $techStackText }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">One item per line.</p>
                        @error('tech_stack_text')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Metrics / Results</label>
                        <textarea name="metrics_text" rows="5" placeholder="Reduced manual work by 60%&#10;Improved page speed score"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">{{ $metricsText }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">One item per line.</p>
                        @error('metrics_text')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2 flex flex-wrap gap-5">
                        <label class="inline-flex items-center gap-2 text-sm font-medium text-gray-700">
                            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $project->is_featured))
                                class="rounded border-gray-300 text-indigo-600">
                            Featured Project
                        </label>

                        <label class="inline-flex items-center gap-2 text-sm font-medium text-gray-700">
                            <input type="checkbox" name="is_enabled" value="1" @checked(old('is_enabled', $project->is_enabled))
                                class="rounded border-gray-300 text-indigo-600">
                            Enabled
                        </label>
                    </div>
                </div>

                <div class="flex flex-wrap justify-end gap-3">
                    <a href="{{ route('admin.portfolios.projects.index', $portfolio) }}"
                        class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                        Cancel
                    </a>

                    <button type="submit"
                        class="rounded-lg bg-indigo-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
                        Update Project
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
