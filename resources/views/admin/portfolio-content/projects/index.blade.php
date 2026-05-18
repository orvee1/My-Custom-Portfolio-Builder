@extends('layouts.admin')

@section('title', 'Projects')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Projects</h1>
                <p class="text-sm text-gray-500">
                    Manage portfolio projects for {{ $portfolio->full_name }}.
                </p>
            </div>

            <a href="{{ route('admin.portfolios.edit', $portfolio) }}"
                class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                Back to Portfolio
            </a>
        </div>

        @include('admin.portfolio-content.partials.nav', ['portfolio' => $portfolio])

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900">Add Project</h2>

            <form method="POST" action="{{ route('admin.portfolios.projects.store', $portfolio) }}"
                enctype="multipart/form-data" class="mt-6 space-y-6">
                @csrf

                <input type="hidden" name="is_featured" value="0">
                <input type="hidden" name="is_enabled" value="0">

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">
                            Project Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" value="{{ old('title') }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">
                            Slug
                        </label>
                        <input type="text" name="slug" value="{{ old('slug') }}"
                            placeholder="auto-generated-from-title"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        <p class="mt-1 text-xs text-gray-500">Leave empty to generate from title.</p>
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Project Type</label>
                        <input type="text" name="project_type" value="{{ old('project_type') }}"
                            placeholder="Web App, SaaS, Mobile App"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('project_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Category</label>
                        <input type="text" name="category" value="{{ old('category') }}"
                            placeholder="Laravel, UI/UX, E-commerce"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('category')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Client Name</label>
                        <input type="text" name="client_name" value="{{ old('client_name') }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('client_name')
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

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Started At</label>
                        <input type="date" name="started_at" value="{{ old('started_at') }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('started_at')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Ended At</label>
                        <input type="date" name="ended_at" value="{{ old('ended_at') }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('ended_at')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-gray-700">Short Description</label>
                        <textarea name="short_description" rows="3"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">{{ old('short_description') }}</textarea>
                        @error('short_description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-gray-700">Long Description</label>
                        <textarea name="long_description" rows="5"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">{{ old('long_description') }}</textarea>
                        @error('long_description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Problem Statement</label>
                        <textarea name="problem_statement" rows="4"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">{{ old('problem_statement') }}</textarea>
                        @error('problem_statement')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Solution Summary</label>
                        <textarea name="solution_summary" rows="4"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">{{ old('solution_summary') }}</textarea>
                        @error('solution_summary')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-gray-700">Result Summary</label>
                        <textarea name="result_summary" rows="4"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">{{ old('result_summary') }}</textarea>
                        @error('result_summary')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Project URL</label>
                        <input type="url" name="project_url" value="{{ old('project_url') }}"
                            placeholder="https://example.com"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('project_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">GitHub URL</label>
                        <input type="url" name="github_url" value="{{ old('github_url') }}"
                            placeholder="https://github.com/..."
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('github_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Figma URL</label>
                        <input type="url" name="figma_url" value="{{ old('figma_url') }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('figma_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Case Study URL</label>
                        <input type="url" name="case_study_url" value="{{ old('case_study_url') }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('case_study_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Thumbnail</label>
                        <input type="file" name="thumbnail" accept="image/*"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                        @error('thumbnail')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Banner Image</label>
                        <input type="file" name="banner_image" accept="image/*"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                        @error('banner_image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Tech Stack</label>
                        <textarea name="tech_stack_text" rows="5" placeholder="Laravel&#10;Tailwind CSS&#10;MySQL"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">{{ old('tech_stack_text') }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">One item per line.</p>
                        @error('tech_stack_text')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Metrics / Results</label>
                        <textarea name="metrics_text" rows="5" placeholder="Reduced manual work by 60%&#10;Improved page speed score"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">{{ old('metrics_text') }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">One item per line.</p>
                        @error('metrics_text')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2 flex flex-wrap gap-5">
                        <label class="inline-flex items-center gap-2 text-sm font-medium text-gray-700">
                            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', false))
                                class="rounded border-gray-300 text-indigo-600">
                            Featured Project
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
                        Add Project
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
                                Project</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Category</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Featured</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Sort</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($projects as $project)
                            <tr>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        @if ($project->thumbnail)
                                            <img src="{{ Storage::url($project->thumbnail) }}"
                                                class="h-12 w-12 rounded-lg object-cover" alt="{{ $project->title }}">
                                        @else
                                            <div
                                                class="flex h-12 w-12 items-center justify-center rounded-lg bg-gray-100 text-sm font-bold text-gray-400">
                                                {{ strtoupper(substr($project->title, 0, 1)) }}
                                            </div>
                                        @endif

                                        <div>
                                            <div class="font-medium text-gray-900">{{ $project->title }}</div>
                                            <div class="text-xs text-gray-500">{{ $project->slug }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-4 py-4 text-sm text-gray-600">
                                    {{ $project->category ?: '-' }}
                                </td>

                                <td class="px-4 py-4">
                                    <span
                                        class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $project->is_featured ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $project->is_featured ? 'Featured' : 'Normal' }}
                                    </span>
                                </td>

                                <td class="px-4 py-4">
                                    <span
                                        class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $project->is_enabled ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $project->is_enabled ? 'Enabled' : 'Disabled' }}
                                    </span>
                                </td>

                                <td class="px-4 py-4 text-sm text-gray-600">
                                    {{ $project->sort_order }}
                                </td>

                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.portfolios.projects.edit', [$portfolio, $project]) }}"
                                            class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50">
                                            Edit
                                        </a>

                                        <form method="POST"
                                            action="{{ route('admin.portfolios.projects.destroy', [$portfolio, $project]) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this project?')">
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
                                    No projects found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-gray-200 px-4 py-4">
                {{ $projects->links() }}
            </div>
        </div>
    </div>
@endsection
