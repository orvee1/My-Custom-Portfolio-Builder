@extends('layouts.admin')

@section('title', 'Edit Portfolio')

@section('content')
    @php
        $stats = old('stat_label')
            ? collect(old('stat_label'))
                ->map(function ($label, $index) {
                    return [
                        'label' => $label,
                        'value' => old('stat_value')[$index] ?? '',
                    ];
                })
                ->toArray()
            : $portfolio->highlight_stats ?? [];

        $theme = $portfolio->theme_settings ?? [];
        $setupItems = [
            'Identity' => filled($portfolio->portfolio_title) && filled($portfolio->full_name) && filled($portfolio->slug),
            'About' => filled($portfolio->short_bio) || filled($portfolio->about),
            'Projects' => $portfolio->projects()->exists(),
            'Experience' => $portfolio->experiences()->exists() || $portfolio->educations()->exists(),
            'Social' => $portfolio->socialLinks()->exists(),
        ];
        $completedSetupItems = collect($setupItems)->filter()->count();
        $templatePreviews = [
            'premium_modern' => [
                'name' => 'Premium Modern',
                'description' => 'Polished, sharp, and client-facing with strong contrast.',
                'swatches' => 'from-slate-950 via-slate-800 to-indigo-500',
                'badge' => 'Best for consultants and developers',
            ],
            'minimal_clean' => [
                'name' => 'Minimal Clean',
                'description' => 'Warm, quiet, and editorial with a refined presentation.',
                'swatches' => 'from-stone-100 via-orange-100 to-amber-200',
                'badge' => 'Best for designers and writers',
            ],
            'creative_dark' => [
                'name' => 'Creative Dark',
                'description' => 'Bold, dramatic, and portfolio-first with a studio feel.',
                'swatches' => 'from-slate-950 via-blue-950 to-fuchsia-700',
                'badge' => 'Best for creatives and visual brands',
            ],
        ];
    @endphp

    <div class="space-y-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Portfolio</h1>
                <p class="text-sm text-gray-500">
                    Manage profile details, theme, SEO, and public sharing settings.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.portfolios.preview', $portfolio) }}" target="_blank"
                    class="rounded-lg border border-indigo-300 px-4 py-2 text-sm font-semibold text-indigo-700 hover:bg-indigo-50">
                    Preview
                </a>

                @if ($portfolio->isPublished())
                    <a href="{{ $publicUrl }}" target="_blank"
                        class="rounded-lg border border-green-300 px-4 py-2 text-sm font-semibold text-green-700 hover:bg-green-50">
                        Open Public URL
                    </a>
                @endif

                <form method="POST" action="{{ route('admin.portfolios.toggle-publish', $portfolio) }}">
                    @csrf
                    @method('PATCH')

                    <button type="submit"
                        class="rounded-lg {{ $portfolio->status === 'published' ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} px-4 py-2 text-sm font-semibold text-white">
                        {{ $portfolio->status === 'published' ? 'Move to Draft' : 'Publish Portfolio' }}
                    </button>
                </form>
            </div>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Status</p>
                    <p class="mt-1 text-lg font-bold text-gray-900">{{ ucfirst($portfolio->status) }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Public URL</p>
                    <p class="mt-1 break-all text-sm text-indigo-700">
                        {{ $publicUrl }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Last Updated</p>
                    <p class="mt-1 text-sm text-gray-700">
                        {{ $portfolio->last_content_updated_at?->format('d M Y, h:i A') ?? $portfolio->updated_at?->format('d M Y, h:i A') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="overflow-hidden rounded-[2rem] border border-zinc-200 bg-[linear-gradient(135deg,#fff7ed,#ffffff_45%,#eef2ff)] shadow-sm">
            <div class="grid gap-8 px-6 py-7 lg:grid-cols-[1.1fr_0.9fr] lg:px-8">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.35em] text-orange-600">Portfolio Setup</p>
                    <h2 class="mt-3 text-3xl font-black text-zinc-950">
                        Make the first publish feel guided, not overwhelming.
                    </h2>
                    <p class="mt-3 max-w-2xl text-sm leading-7 text-zinc-600">
                        Complete the essentials below, add your strongest content sections, choose a template direction,
                        then preview before publishing.
                    </p>

                    <div class="mt-6 flex items-end gap-4">
                        <div>
                            <p class="text-4xl font-black text-zinc-950">{{ $completedSetupItems }}/{{ count($setupItems) }}</p>
                            <p class="text-sm text-zinc-500">core setup areas completed</p>
                        </div>
                        <div class="h-3 flex-1 rounded-full bg-white/80">
                            <div class="h-3 rounded-full bg-zinc-950 transition-all"
                                style="width: {{ (int) (($completedSetupItems / count($setupItems)) * 100) }}%"></div>
                        </div>
                    </div>
                </div>

                <div class="grid gap-3 sm:grid-cols-2">
                    @foreach ($setupItems as $label => $done)
                        <div
                            class="rounded-2xl border px-4 py-4 {{ $done ? 'border-emerald-200 bg-emerald-50 text-emerald-900' : 'border-zinc-200 bg-white/80 text-zinc-700' }}">
                            <p class="text-xs font-bold uppercase tracking-[0.25em] {{ $done ? 'text-emerald-600' : 'text-zinc-400' }}">
                                {{ $done ? 'Ready' : 'Pending' }}
                            </p>
                            <p class="mt-2 text-base font-bold">{{ $label }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Phase 4 content navigation --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-3 shadow-sm">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.portfolios.edit', $portfolio) }}"
                    class="rounded-lg px-4 py-2 text-sm font-semibold {{ request()->routeIs('admin.portfolios.edit') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    Basic Info
                </a>

                <a href="{{ route('admin.portfolios.projects.index', $portfolio) }}"
                    class="rounded-lg px-4 py-2 text-sm font-semibold {{ request()->routeIs('admin.portfolios.projects.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    Projects
                </a>

                <a href="{{ route('admin.portfolios.skills.index', $portfolio) }}"
                    class="rounded-lg px-4 py-2 text-sm font-semibold {{ request()->routeIs('admin.portfolios.skills.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    Skills
                </a>

                <a href="{{ route('admin.portfolios.experiences.index', $portfolio) }}"
                    class="rounded-lg px-4 py-2 text-sm font-semibold {{ request()->routeIs('admin.portfolios.experiences.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    Experiences
                </a>

                <a href="{{ route('admin.portfolios.educations.index', $portfolio) }}"
                    class="rounded-lg px-4 py-2 text-sm font-semibold {{ request()->routeIs('admin.portfolios.educations.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    Educations
                </a>

                <a href="{{ route('admin.portfolios.social-links.index', $portfolio) }}"
                    class="rounded-lg px-4 py-2 text-sm font-semibold {{ request()->routeIs('admin.portfolios.social-links.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    Social Links
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.portfolios.update', $portfolio) }}" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')

            <input type="hidden" name="resume_download_enabled" value="0">
            <input type="hidden" name="contact_form_enabled" value="0">
            <input type="hidden" name="show_social_links" value="0">
            <input type="hidden" name="show_cover_overlay" value="0">

            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900">Basic Information</h2>

                <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Portfolio Title *</label>
                        <input type="text" name="portfolio_title"
                            value="{{ old('portfolio_title', $portfolio->portfolio_title) }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('portfolio_title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Slug *</label>
                        <input type="text" name="slug" value="{{ old('slug', $portfolio->slug) }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        <p class="mt-1 text-xs text-gray-500">Example: {{ url('/p/john-doe') }}</p>
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Full Name *</label>
                        <input type="text" name="full_name" value="{{ old('full_name', $portfolio->full_name) }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        @error('full_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Profession Title</label>
                        <input type="text" name="profession_title"
                            value="{{ old('profession_title', $portfolio->profession_title) }}"
                            placeholder="Laravel Developer, UI Designer, Product Manager"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Brand Name</label>
                        <input type="text" name="brand_name" value="{{ old('brand_name', $portfolio->brand_name) }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Tagline</label>
                        <input type="text" name="tagline" value="{{ old('tagline', $portfolio->tagline) }}"
                            placeholder="I build clean, scalable, and conversion-focused digital products."
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-gray-700">Short Bio</label>
                        <textarea name="short_bio" rows="3"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">{{ old('short_bio', $portfolio->short_bio) }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-gray-700">About</label>
                        <textarea name="about" rows="6"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">{{ old('about', $portfolio->about) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900">Contact Information</h2>

                <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email', $portfolio->email) }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $portfolio->phone) }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">WhatsApp</label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp', $portfolio->whatsapp) }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Location</label>
                        <input type="text" name="location" value="{{ old('location', $portfolio->location) }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-gray-700">Website</label>
                        <input type="url" name="website" value="{{ old('website', $portfolio->website) }}"
                            placeholder="https://example.com"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900">Media & Resume</h2>

                <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-3">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Avatar</label>
                        @if ($portfolio->avatar)
                            <img src="{{ Storage::url($portfolio->avatar) }}"
                                class="mb-3 h-24 w-24 rounded-full object-cover">
                        @endif

                        <input type="file" name="avatar" accept="image/*"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                        @error('avatar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Cover Image</label>
                        @if ($portfolio->cover_image)
                            <img src="{{ Storage::url($portfolio->cover_image) }}"
                                class="mb-3 h-24 w-full rounded-lg object-cover">
                        @endif

                        <input type="file" name="cover_image" accept="image/*"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                        @error('cover_image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Resume / CV</label>
                        @if ($portfolio->resume_file)
                            <a href="{{ Storage::url($portfolio->resume_file) }}" target="_blank"
                                class="mb-3 inline-flex rounded-lg border border-indigo-300 px-3 py-2 text-xs font-semibold text-indigo-700">
                                View Current Resume
                            </a>
                        @endif

                        <input type="file" name="resume_file" accept=".pdf,.doc,.docx"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                        @error('resume_file')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900">Theme & Customization</h2>
                <p class="mt-2 text-sm text-gray-500">
                    Choose a visual direction first, then fine-tune the supporting style controls.
                </p>

                <div class="mt-6 grid gap-4 lg:grid-cols-3">
                    @foreach ($templatePreviews as $key => $templatePreview)
                        <label
                            class="group block cursor-pointer overflow-hidden rounded-[1.75rem] border transition {{ old('template_key', $portfolio->template_key) === $key ? 'border-zinc-950 ring-2 ring-zinc-950/10' : 'border-zinc-200 hover:border-zinc-400' }}">
                            <input type="radio" name="template_key" value="{{ $key }}" class="sr-only"
                                @checked(old('template_key', $portfolio->template_key) === $key)>

                            <div class="h-40 bg-gradient-to-br {{ $templatePreview['swatches'] }} p-5 text-white">
                                <div class="flex h-full flex-col justify-between">
                                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-white/75">
                                        {{ $templatePreview['name'] }}
                                    </p>
                                    <div class="space-y-2">
                                        <div class="h-3 w-24 rounded-full bg-white/90"></div>
                                        <div class="h-3 w-36 rounded-full bg-white/50"></div>
                                        <div class="h-16 rounded-2xl bg-white/12 backdrop-blur-sm"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white p-5">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="text-base font-bold text-zinc-950">{{ $templatePreview['name'] }}</p>
                                        <p class="mt-2 text-sm leading-6 text-zinc-600">{{ $templatePreview['description'] }}</p>
                                    </div>
                                </div>
                                <p class="mt-4 text-xs font-semibold uppercase tracking-[0.2em] text-zinc-400">
                                    {{ $templatePreview['badge'] }}
                                </p>
                            </div>
                        </label>
                    @endforeach
                </div>

                <div class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-3">

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Accent Color</label>
                        <input type="text" name="accent_color"
                            value="{{ old('accent_color', $portfolio->accent_color ?? '#4f46e5') }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Secondary Color</label>
                        <input type="text" name="secondary_color"
                            value="{{ old('secondary_color', $portfolio->secondary_color ?? '#111827') }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Font Family</label>
                        <input type="text" name="font_family"
                            value="{{ old('font_family', $portfolio->font_family ?? 'Inter') }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                        <p class="mt-1 text-xs text-gray-500">Try a strong display or editorial font family for a more branded look.</p>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Hero Layout</label>
                        <select name="hero_layout" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                            <option value="split" @selected(old('hero_layout', $theme['hero_layout'] ?? 'split') === 'split')>Split</option>
                            <option value="centered" @selected(old('hero_layout', $theme['hero_layout'] ?? '') === 'centered')>Centered</option>
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Split feels portfolio-like. Centered feels more personal-brand focused.</p>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Card Style</label>
                        <select name="card_style" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                            <option value="soft" @selected(old('card_style', $theme['card_style'] ?? 'soft') === 'soft')>Soft</option>
                            <option value="bordered" @selected(old('card_style', $theme['card_style'] ?? '') === 'bordered')>Bordered</option>
                            <option value="glass" @selected(old('card_style', $theme['card_style'] ?? '') === 'glass')>Glass</option>
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Controls the feel of project, skill, and content cards.</p>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Button Style</label>
                        <select name="button_style" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                            <option value="rounded" @selected(old('button_style', $theme['button_style'] ?? 'rounded') === 'rounded')>Rounded</option>
                            <option value="pill" @selected(old('button_style', $theme['button_style'] ?? '') === 'pill')>Pill</option>
                            <option value="sharp" @selected(old('button_style', $theme['button_style'] ?? '') === 'sharp')>Sharp</option>
                        </select>
                        <p class="mt-1 text-xs text-gray-500">A small change that strongly affects the brand tone.</p>
                    </div>

                    <div class="flex items-center pt-7">
                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" name="show_cover_overlay" value="1" @checked(old('show_cover_overlay', $theme['show_cover_overlay'] ?? true))
                                class="rounded border-gray-300 text-indigo-600">
                            <span class="text-sm font-medium text-gray-700">Cover overlay</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900">Highlight Stats</h2>

                <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                    @for ($i = 0; $i < 4; $i++)
                        <div class="grid grid-cols-2 gap-3">
                            <input type="text" name="stat_value[]" value="{{ $stats[$i]['value'] ?? '' }}"
                                placeholder="5+" class="rounded-lg border border-gray-300 px-3 py-2 text-sm">

                            <input type="text" name="stat_label[]" value="{{ $stats[$i]['label'] ?? '' }}"
                                placeholder="Years Experience"
                                class="rounded-lg border border-gray-300 px-3 py-2 text-sm">
                        </div>
                    @endfor
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900">SEO Settings</h2>

                <div class="mt-6 grid grid-cols-1 gap-6">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">SEO Title</label>
                        <input type="text" name="seo_title" value="{{ old('seo_title', $portfolio->seo_title) }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">SEO Description</label>
                        <textarea name="seo_description" rows="3" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">{{ old('seo_description', $portfolio->seo_description) }}</textarea>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">SEO Keywords</label>
                        <input type="text" name="seo_keywords"
                            value="{{ old('seo_keywords', $portfolio->seo_keywords) }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900">Public Settings</h2>

                <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-3">
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="resume_download_enabled" value="1"
                            @checked(old('resume_download_enabled', $portfolio->resume_download_enabled)) class="rounded border-gray-300 text-indigo-600">
                        <span class="text-sm font-medium text-gray-700">Allow resume download</span>
                    </label>

                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="contact_form_enabled" value="1" @checked(old('contact_form_enabled', $portfolio->contact_form_enabled))
                            class="rounded border-gray-300 text-indigo-600">
                        <span class="text-sm font-medium text-gray-700">Enable contact form</span>
                    </label>

                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="show_social_links" value="1" @checked(old('show_social_links', $portfolio->show_social_links))
                            class="rounded border-gray-300 text-indigo-600">
                        <span class="text-sm font-medium text-gray-700">Show social links</span>
                    </label>
                </div>
            </div>

            <div class="sticky bottom-0 z-20 rounded-2xl border border-gray-200 bg-white/95 p-4 shadow-lg backdrop-blur">
                <div class="flex flex-wrap items-center justify-end gap-3">
                    <a href="{{ auth()->user()->isSuperAdmin() ? route('admin.portfolios.index') : route('admin.dashboard') }}"
                        class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                        Cancel
                    </a>

                    <button type="submit"
                        class="rounded-lg bg-indigo-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
                        Save Portfolio
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
