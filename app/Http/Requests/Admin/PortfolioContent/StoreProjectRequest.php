<?php

namespace App\Http\Requests\Admin\PortfolioContent;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        $portfolio = $this->route('portfolio');
        $project = $this->route('project');

        return [
            'title' => ['required', 'string', 'max:180'],
            'slug' => [
                'required',
                'string',
                'max:180',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('portfolio_projects', 'slug')
                    ->where('portfolio_id', $portfolio?->id)
                    ->ignore($project?->id),
            ],
            'project_type' => ['nullable', 'string', 'max:100'],
            'category' => ['nullable', 'string', 'max:100'],
            'short_description' => ['nullable', 'string', 'max:1000'],
            'long_description' => ['nullable', 'string'],
            'problem_statement' => ['nullable', 'string'],
            'solution_summary' => ['nullable', 'string'],
            'result_summary' => ['nullable', 'string'],
            'client_name' => ['nullable', 'string', 'max:150'],
            'project_url' => ['nullable', 'url', 'max:500'],
            'github_url' => ['nullable', 'url', 'max:500'],
            'figma_url' => ['nullable', 'url', 'max:500'],
            'case_study_url' => ['nullable', 'url', 'max:500'],
            'started_at' => ['nullable', 'date'],
            'ended_at' => ['nullable', 'date', 'after_or_equal:started_at'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'banner_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'tech_stack_text' => ['nullable', 'string'],
            'metrics_text' => ['nullable', 'string'],
            'is_featured' => ['required', 'boolean'],
            'is_enabled' => ['required', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => str($this->input('slug') ?: $this->input('title'))->slug()->toString(),
            'is_featured' => $this->boolean('is_featured'),
            'is_enabled' => $this->boolean('is_enabled'),
            'sort_order' => $this->input('sort_order', 0),
        ]);
    }
}
