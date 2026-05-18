<?php

namespace App\Http\Requests\Admin\PortfolioContent;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreSkillRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'category' => ['nullable', 'string', 'max:100'],
            'name' => ['required', 'string', 'max:120'],
            'proficiency' => ['nullable', 'integer', 'min:1', 'max:100'],
            'years_of_experience' => ['nullable', 'numeric', 'min:0', 'max:99'],
            'icon' => ['nullable', 'string', 'max:255'],
            'is_highlighted' => ['required', 'boolean'],
            'is_enabled' => ['required', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_highlighted' => $this->boolean('is_highlighted'),
            'is_enabled' => $this->boolean('is_enabled'),
            'sort_order' => $this->input('sort_order', 0),
        ]);
    }
}
