<?php

namespace App\Http\Requests\Admin\PortfolioContent;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreSocialLinkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'platform' => ['required', 'string', 'max:50'],
            'label' => ['nullable', 'string', 'max:100'],
            'url' => ['required', 'url', 'max:500'],
            'icon' => ['nullable', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_enabled' => ['required', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_enabled' => $this->boolean('is_enabled'),
            'sort_order' => $this->input('sort_order', 0),
        ]);
    }
}
