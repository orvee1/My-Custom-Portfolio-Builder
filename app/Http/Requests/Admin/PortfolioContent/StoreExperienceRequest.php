<?php

namespace App\Http\Requests\Admin\PortfolioContent;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreExperienceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'company_name' => ['required', 'string', 'max:180'],
            'job_title' => ['required', 'string', 'max:180'],
            'employment_type' => ['nullable', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:150'],
            'company_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_current' => ['required', 'boolean'],
            'summary' => ['nullable', 'string'],
            'achievements_text' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_enabled' => ['required', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_current' => $this->boolean('is_current'),
            'is_enabled' => $this->boolean('is_enabled'),
            'sort_order' => $this->input('sort_order', 0),
        ]);
    }
}
