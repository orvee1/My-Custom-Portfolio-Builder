<?php

namespace App\Http\Requests\Admin\Portfolio;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdatePortfolioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        $portfolio = $this->route('portfolio');

        return [
            'slug' => [
                'required',
                'string',
                'max:150',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('portfolios', 'slug')->ignore($portfolio?->id),
            ],

            'portfolio_title' => ['required', 'string', 'max:150'],
            'full_name' => ['required', 'string', 'max:150'],
            'profession_title' => ['nullable', 'string', 'max:150'],
            'brand_name' => ['nullable', 'string', 'max:150'],
            'tagline' => ['nullable', 'string', 'max:255'],

            'email' => ['nullable', 'email:rfc', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'whatsapp' => ['nullable', 'string', 'max:30'],
            'location' => ['nullable', 'string', 'max:150'],
            'website' => ['nullable', 'url', 'max:255'],

            'short_bio' => ['nullable', 'string', 'max:1000'],
            'about' => ['nullable', 'string'],

            'template_key' => ['required', 'string', 'max:100'],
            'accent_color' => ['nullable', 'string', 'max:30'],
            'secondary_color' => ['nullable', 'string', 'max:30'],
            'font_family' => ['nullable', 'string', 'max:100'],

            'resume_download_enabled' => ['required', 'boolean'],
            'contact_form_enabled' => ['required', 'boolean'],
            'show_social_links' => ['required', 'boolean'],

            'seo_title' => ['nullable', 'string', 'max:160'],
            'seo_description' => ['nullable', 'string', 'max:500'],
            'seo_keywords' => ['nullable', 'string', 'max:500'],

            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'resume_file' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],

            'stat_label' => ['nullable', 'array'],
            'stat_label.*' => ['nullable', 'string', 'max:80'],
            'stat_value' => ['nullable', 'array'],
            'stat_value.*' => ['nullable', 'string', 'max:80'],

            'hero_layout' => ['nullable', 'string', 'max:50'],
            'card_style' => ['nullable', 'string', 'max:50'],
            'button_style' => ['nullable', 'string', 'max:50'],
            'show_cover_overlay' => ['required', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => str($this->input('slug'))->slug()->toString(),

            'resume_download_enabled' => $this->boolean('resume_download_enabled'),
            'contact_form_enabled' => $this->boolean('contact_form_enabled'),
            'show_social_links' => $this->boolean('show_social_links'),
            'show_cover_overlay' => $this->boolean('show_cover_overlay'),
        ]);
    }

    public function messages(): array
    {
        return [
            'slug.regex' => 'The slug may only contain lowercase letters, numbers, and hyphens.',
        ];
    }
}
