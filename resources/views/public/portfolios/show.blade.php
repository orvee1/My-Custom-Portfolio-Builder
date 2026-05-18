@php
    $projects = $portfolio->enabledProjects ?? collect();
    $skills = $portfolio->enabledSkills ?? collect();
    $experiences = $portfolio->enabledExperiences ?? collect();
    $educations = $portfolio->enabledEducations ?? collect();
    $socialLinks = $portfolio->enabledSocialLinks ?? collect();

    $accent = $portfolio->accent_color ?: '#ea580c';
    $secondary = $portfolio->secondary_color ?: '#111827';
    $fontFamily = $portfolio->font_family ?: 'Instrument Sans';
    $theme = $portfolio->theme_settings ?? [];
    $heroLayout = $theme['hero_layout'] ?? 'split';
    $cardStyle = $theme['card_style'] ?? 'soft';
    $buttonStyle = $theme['button_style'] ?? 'rounded';
    $showCoverOverlay = (bool) ($theme['show_cover_overlay'] ?? true);
    $stats = collect($portfolio->highlight_stats ?? [])
        ->filter(fn ($stat) => filled($stat['label'] ?? null) || filled($stat['value'] ?? null))
        ->values();

    $templates = [
        'premium_modern' => [
            'page' => 'bg-[#f6f7fb] text-zinc-950',
            'surface' => 'bg-white border border-zinc-200 shadow-[0_24px_90px_-48px_rgba(15,23,42,0.4)]',
            'soft' => 'bg-white',
            'muted' => 'text-zinc-600',
            'section' => 'bg-white',
            'sectionAlt' => 'bg-[#eef2ff]',
            'hero' => 'from-zinc-950 via-zinc-900 to-zinc-800 text-white',
            'pill' => 'bg-white/10 text-white border border-white/15',
        ],
        'minimal_clean' => [
            'page' => 'bg-[#f5f1ea] text-zinc-950',
            'surface' => 'bg-[#fffaf4] border border-[#eadfce] shadow-[0_20px_80px_-52px_rgba(120,53,15,0.35)]',
            'soft' => 'bg-[#fffdf9]',
            'muted' => 'text-stone-600',
            'section' => 'bg-[#fffaf4]',
            'sectionAlt' => 'bg-[#f0ebe3]',
            'hero' => 'from-[#2b221b] via-[#403127] to-[#6a4a33] text-[#fff8ef]',
            'pill' => 'bg-white/10 text-white border border-white/15',
        ],
        'creative_dark' => [
            'page' => 'bg-[#0b1020] text-white',
            'surface' => 'bg-white/6 border border-white/10 shadow-[0_30px_100px_-55px_rgba(0,0,0,0.95)] backdrop-blur',
            'soft' => 'bg-white/5',
            'muted' => 'text-slate-300',
            'section' => 'bg-[#0f172d]',
            'sectionAlt' => 'bg-[#121b34]',
            'hero' => 'from-[#080b16] via-[#10192f] to-[#1a2440] text-white',
            'pill' => 'bg-white/8 text-white border border-white/10',
        ],
    ];

    $template = $templates[$portfolio->template_key] ?? $templates['premium_modern'];

    $buttonClass = match ($buttonStyle) {
        'pill' => 'rounded-full',
        'sharp' => 'rounded-md',
        default => 'rounded-2xl',
    };

    $cardClass = match ($cardStyle) {
        'glass' => $template['surface'],
        'bordered' => 'border border-current/10 bg-transparent',
        default => $template['surface'],
    };

    $heroAlignment = $heroLayout === 'centered'
        ? 'mx-auto max-w-4xl text-center'
        : 'grid gap-10 lg:grid-cols-[1.1fr_0.9fr] lg:items-end';

    $displayTitle = $portfolio->brand_name ?: $portfolio->full_name;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $portfolio->seo_title ?: $portfolio->portfolio_title }}</title>
        @if ($portfolio->seo_description)
            <meta name="description" content="{{ $portfolio->seo_description }}">
        @endif

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="{{ $template['page'] }}" style="font-family: '{{ $fontFamily }}', sans-serif;">
        <div class="min-h-screen">
            <header class="mx-auto flex max-w-7xl items-center justify-between px-6 py-6 lg:px-8">
                <a href="{{ $isPreview ? route('admin.portfolios.edit', $portfolio) : '#' }}"
                    class="text-sm font-black uppercase tracking-[0.35em]"
                    style="color: {{ $accent }}">
                    {{ $displayTitle }}
                </a>

                <div class="flex items-center gap-3">
                    @if ($portfolio->website)
                        <a href="{{ $portfolio->website }}" target="_blank"
                            class="{{ $buttonClass }} border border-current/15 px-4 py-2 text-sm font-semibold {{ $template['muted'] }}">
                            Website
                        </a>
                    @endif

                    @if ($isPreview)
                        <a href="{{ route('admin.portfolios.edit', $portfolio) }}"
                            class="{{ $buttonClass }} bg-white px-4 py-2 text-sm font-semibold text-zinc-950">
                            Back To Editor
                        </a>
                    @endif
                </div>
            </header>

            <main>
                <section class="relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br {{ $template['hero'] }}"></div>
                    <div class="absolute inset-0"
                        style="background:
                            radial-gradient(circle at top left, {{ $accent }}33, transparent 30%),
                            radial-gradient(circle at bottom right, {{ $secondary }}33, transparent 26%);">
                    </div>

                    @if ($portfolio->cover_image)
                        <div class="absolute inset-0">
                            <img src="{{ Storage::url($portfolio->cover_image) }}" alt="{{ $portfolio->portfolio_title }}"
                                class="h-full w-full object-cover opacity-20">
                            @if ($showCoverOverlay)
                                <div class="absolute inset-0 bg-zinc-950/65"></div>
                            @endif
                        </div>
                    @endif

                    <div class="relative mx-auto max-w-7xl px-6 pb-24 pt-12 lg:px-8 lg:pb-28">
                        <div class="{{ $heroAlignment }}">
                            <div class="{{ $heroLayout === 'centered' ? '' : 'max-w-2xl' }}">
                                <p class="inline-flex {{ $buttonClass }} {{ $template['pill'] }} px-4 py-1 text-xs font-bold uppercase tracking-[0.3em]">
                                    {{ $portfolio->portfolio_title }}
                                </p>

                                <h1 class="mt-7 text-5xl font-black leading-none md:text-7xl">
                                    {{ $portfolio->full_name }}
                                </h1>

                                @if ($portfolio->profession_title)
                                    <p class="mt-5 text-2xl font-semibold" style="color: {{ $accent }}">
                                        {{ $portfolio->profession_title }}
                                    </p>
                                @endif

                                @if ($portfolio->tagline)
                                    <p class="mx-auto mt-6 max-w-2xl text-lg leading-8 text-white/75">
                                        {{ $portfolio->tagline }}
                                    </p>
                                @endif

                                <div class="mt-8 flex flex-wrap gap-3 {{ $heroLayout === 'centered' ? 'justify-center' : '' }}">
                                    @if ($portfolio->email)
                                        <a href="mailto:{{ $portfolio->email }}"
                                            class="{{ $buttonClass }} bg-white px-5 py-3 text-sm font-semibold text-zinc-950 transition hover:-translate-y-0.5">
                                            Contact Me
                                        </a>
                                    @endif

                                    @if ($portfolio->resume_download_enabled && $portfolio->resume_file)
                                        <a href="{{ Storage::url($portfolio->resume_file) }}" target="_blank"
                                            class="{{ $buttonClass }} border border-white/20 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-white/10">
                                            Download Resume
                                        </a>
                                    @endif
                                </div>

                                @if ($socialLinks->count() && $portfolio->show_social_links)
                                    <div class="mt-8 flex flex-wrap gap-3 {{ $heroLayout === 'centered' ? 'justify-center' : '' }}">
                                        @foreach ($socialLinks as $socialLink)
                                            <a href="{{ $socialLink->url }}" target="_blank"
                                                class="{{ $buttonClass }} border border-white/15 bg-white/5 px-4 py-2 text-sm font-medium text-white/80 transition hover:bg-white/10 hover:text-white">
                                                {{ $socialLink->label ?: $socialLink->platform }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            @if ($heroLayout !== 'centered')
                                <div class="lg:justify-self-end">
                                    <div class="relative overflow-hidden {{ $buttonClass }} border border-white/10 bg-white/8 p-5 shadow-2xl backdrop-blur">
                                        @if ($portfolio->avatar)
                                            <img src="{{ Storage::url($portfolio->avatar) }}" alt="{{ $portfolio->full_name }}"
                                                class="h-80 w-full rounded-[inherit] object-cover md:h-[28rem] md:w-[22rem]">
                                        @else
                                            <div
                                                class="flex h-80 w-full items-center justify-center rounded-[inherit] bg-white/10 text-8xl font-black text-white/30 md:h-[28rem] md:w-[22rem]">
                                                {{ strtoupper(substr($portfolio->full_name, 0, 1)) }}
                                            </div>
                                        @endif

                                        @if ($portfolio->location || $portfolio->phone)
                                            <div class="mt-4 grid gap-3 text-sm text-white/80">
                                                @if ($portfolio->location)
                                                    <p>{{ $portfolio->location }}</p>
                                                @endif
                                                @if ($portfolio->phone)
                                                    <p>{{ $portfolio->phone }}</p>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if ($stats->count())
                            <div class="mt-14 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                                @foreach ($stats as $stat)
                                    <div class="{{ $buttonClass }} border border-white/10 bg-white/8 p-5 backdrop-blur">
                                        <p class="text-3xl font-black" style="color: {{ $accent }}">
                                            {{ $stat['value'] ?? '' }}
                                        </p>
                                        <p class="mt-2 text-sm text-white/70">
                                            {{ $stat['label'] ?? '' }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </section>

                @if ($portfolio->short_bio || $portfolio->about)
                    <section class="{{ $template['section'] }} py-20">
                        <div class="mx-auto max-w-5xl px-6 lg:px-8">
                            <p class="text-xs font-bold uppercase tracking-[0.35em]" style="color: {{ $accent }}">
                                About
                            </p>

                            @if ($portfolio->short_bio)
                                <h2 class="mt-4 text-3xl font-black md:text-5xl">
                                    {{ $portfolio->short_bio }}
                                </h2>
                            @endif

                            @if ($portfolio->about)
                                <div class="mt-8 max-w-none text-lg leading-8 {{ $template['muted'] }}">
                                    {!! nl2br(e($portfolio->about)) !!}
                                </div>
                            @endif
                        </div>
                    </section>
                @endif

                @if ($skills->count())
                    <section class="{{ $template['sectionAlt'] }} py-20">
                        <div class="mx-auto max-w-6xl px-6 lg:px-8">
                            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.35em]" style="color: {{ $accent }}">
                                        Skills
                                    </p>
                                    <h2 class="mt-4 text-4xl font-black">Core expertise</h2>
                                </div>
                                <p class="max-w-2xl text-sm leading-6 {{ $template['muted'] }}">
                                    The strongest tools, technologies, and capabilities behind this work.
                                </p>
                            </div>

                            <div class="mt-10 grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                                @foreach ($skills as $skill)
                                    <div class="{{ $buttonClass }} {{ $cardClass }} p-5">
                                        <div class="flex items-start justify-between gap-4">
                                            <div>
                                                <h3 class="text-lg font-black">{{ $skill->name }}</h3>
                                                @if ($skill->category)
                                                    <p class="mt-1 text-sm {{ $template['muted'] }}">{{ $skill->category }}</p>
                                                @endif
                                            </div>
                                            @if ($skill->icon)
                                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl {{ $template['soft'] }} text-lg">
                                                    {{ $skill->icon }}
                                                </div>
                                            @endif
                                        </div>

                                        @if ($skill->proficiency)
                                            <div class="mt-6">
                                                <div class="mb-2 flex items-center justify-between text-xs font-semibold {{ $template['muted'] }}">
                                                    <span>Proficiency</span>
                                                    <span style="color: {{ $accent }}">{{ $skill->proficiency }}%</span>
                                                </div>
                                                <div class="h-2 rounded-full bg-black/10">
                                                    <div class="h-2 rounded-full" style="width: {{ $skill->proficiency }}%; background-color: {{ $accent }}"></div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($skill->years_of_experience)
                                            <p class="mt-4 text-xs font-semibold {{ $template['muted'] }}">
                                                {{ $skill->years_of_experience }} years experience
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                @endif

                @if ($projects->count())
                    <section class="{{ $template['section'] }} py-20">
                        <div class="mx-auto max-w-7xl px-6 lg:px-8">
                            <p class="text-xs font-bold uppercase tracking-[0.35em]" style="color: {{ $accent }}">
                                Projects
                            </p>
                            <h2 class="mt-4 text-4xl font-black">Selected work</h2>

                            <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                                @foreach ($projects as $project)
                                    <article class="{{ $buttonClass }} {{ $cardClass }} overflow-hidden">
                                        @if ($project->thumbnail)
                                            <img src="{{ Storage::url($project->thumbnail) }}" class="h-56 w-full object-cover" alt="{{ $project->title }}">
                                        @else
                                            <div class="flex h-56 items-center justify-center {{ $template['soft'] }}">
                                                <span class="text-5xl font-black opacity-25">{{ strtoupper(substr($project->title, 0, 1)) }}</span>
                                            </div>
                                        @endif

                                        <div class="p-6">
                                            @if ($project->category)
                                                <p class="text-xs font-bold uppercase tracking-[0.3em]" style="color: {{ $accent }}">
                                                    {{ $project->category }}
                                                </p>
                                            @endif

                                            <h3 class="mt-3 text-2xl font-black">{{ $project->title }}</h3>

                                            @if ($project->short_description)
                                                <p class="mt-3 text-sm leading-6 {{ $template['muted'] }}">
                                                    {{ $project->short_description }}
                                                </p>
                                            @endif

                                            @if ($project->tech_stack)
                                                <div class="mt-5 flex flex-wrap gap-2">
                                                    @foreach ($project->tech_stack as $tech)
                                                        <span class="{{ $buttonClass }} {{ $template['soft'] }} px-3 py-1 text-xs font-semibold {{ $template['muted'] }}">
                                                            {{ $tech }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif

                                            <div class="mt-6 flex flex-wrap gap-4 text-sm font-bold">
                                                @if ($project->project_url)
                                                    <a href="{{ $project->project_url }}" target="_blank" style="color: {{ $accent }}">Live</a>
                                                @endif
                                                @if ($project->github_url)
                                                    <a href="{{ $project->github_url }}" target="_blank" style="color: {{ $accent }}">GitHub</a>
                                                @endif
                                                @if ($project->case_study_url)
                                                    <a href="{{ $project->case_study_url }}" target="_blank" style="color: {{ $accent }}">Case Study</a>
                                                @endif
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    </section>
                @endif

                @if ($experiences->count() || $educations->count())
                    <section class="{{ $template['sectionAlt'] }} py-20">
                        <div class="mx-auto grid max-w-7xl gap-10 px-6 lg:grid-cols-2 lg:px-8">
                            @if ($experiences->count())
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.35em]" style="color: {{ $accent }}">
                                        Experience
                                    </p>
                                    <h2 class="mt-4 text-4xl font-black">Work history</h2>

                                    <div class="mt-8 space-y-5">
                                        @foreach ($experiences as $experience)
                                            <div class="{{ $buttonClass }} {{ $cardClass }} p-6">
                                                <div class="flex gap-4">
                                                    @if ($experience->company_logo)
                                                        <img src="{{ Storage::url($experience->company_logo) }}"
                                                            class="h-14 w-14 rounded-2xl object-cover"
                                                            alt="{{ $experience->company_name }}">
                                                    @endif

                                                    <div>
                                                        <h3 class="text-xl font-black">{{ $experience->job_title }}</h3>
                                                        <p class="mt-1 font-semibold {{ $template['muted'] }}">{{ $experience->company_name }}</p>
                                                        <p class="mt-1 text-sm {{ $template['muted'] }}">
                                                            {{ $experience->start_date?->format('M Y') ?: 'N/A' }}
                                                            -
                                                            {{ $experience->is_current ? 'Present' : ($experience->end_date?->format('M Y') ?: 'N/A') }}
                                                            @if ($experience->location)
                                                                · {{ $experience->location }}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>

                                                @if ($experience->summary)
                                                    <p class="mt-4 text-sm leading-6 {{ $template['muted'] }}">
                                                        {{ $experience->summary }}
                                                    </p>
                                                @endif

                                                @if ($experience->achievements)
                                                    <ul class="mt-4 list-disc space-y-1 pl-5 text-sm {{ $template['muted'] }}">
                                                        @foreach ($experience->achievements as $achievement)
                                                            <li>{{ $achievement }}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($educations->count())
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.35em]" style="color: {{ $accent }}">
                                        Education
                                    </p>
                                    <h2 class="mt-4 text-4xl font-black">Academic background</h2>

                                    <div class="mt-8 space-y-5">
                                        @foreach ($educations as $education)
                                            <div class="{{ $buttonClass }} {{ $cardClass }} p-6">
                                                <div class="flex gap-4">
                                                    @if ($education->institution_logo)
                                                        <img src="{{ Storage::url($education->institution_logo) }}"
                                                            class="h-14 w-14 rounded-2xl object-cover"
                                                            alt="{{ $education->institution_name }}">
                                                    @endif

                                                    <div>
                                                        <h3 class="text-xl font-black">
                                                            {{ $education->degree ?: $education->institution_name }}
                                                        </h3>
                                                        <p class="mt-1 font-semibold {{ $template['muted'] }}">{{ $education->institution_name }}</p>

                                                        @if ($education->field_of_study)
                                                            <p class="mt-1 text-sm {{ $template['muted'] }}">{{ $education->field_of_study }}</p>
                                                        @endif

                                                        <p class="mt-1 text-sm {{ $template['muted'] }}">
                                                            {{ $education->start_date?->format('M Y') ?: 'N/A' }}
                                                            -
                                                            {{ $education->is_current ? 'Present' : ($education->end_date?->format('M Y') ?: 'N/A') }}
                                                        </p>

                                                        @if ($education->grade)
                                                            <p class="mt-1 text-sm font-semibold {{ $template['muted'] }}">
                                                                Grade: {{ $education->grade }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>

                                                @if ($education->description)
                                                    <p class="mt-4 text-sm leading-6 {{ $template['muted'] }}">
                                                        {{ $education->description }}
                                                    </p>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </section>
                @endif

                <section class="{{ $template['section'] }} py-20">
                    <div class="mx-auto max-w-5xl px-6 lg:px-8">
                        <div class="{{ $buttonClass }} {{ $cardClass }} p-8 md:p-12">
                            <p class="text-xs font-bold uppercase tracking-[0.35em]" style="color: {{ $accent }}">
                                Contact
                            </p>
                            <h2 class="mt-4 text-3xl font-black md:text-4xl">
                                Let us build something memorable.
                            </h2>

                            <div class="mt-8 grid gap-4 md:grid-cols-2">
                                @if ($portfolio->email)
                                    <a href="mailto:{{ $portfolio->email }}"
                                        class="{{ $buttonClass }} {{ $template['soft'] }} border border-current/10 p-5 transition hover:-translate-y-0.5">
                                        <p class="text-sm {{ $template['muted'] }}">Email</p>
                                        <p class="mt-1 font-bold">{{ $portfolio->email }}</p>
                                    </a>
                                @endif

                                @if ($portfolio->phone)
                                    <div class="{{ $buttonClass }} {{ $template['soft'] }} border border-current/10 p-5">
                                        <p class="text-sm {{ $template['muted'] }}">Phone</p>
                                        <p class="mt-1 font-bold">{{ $portfolio->phone }}</p>
                                    </div>
                                @endif

                                @if ($portfolio->location)
                                    <div class="{{ $buttonClass }} {{ $template['soft'] }} border border-current/10 p-5">
                                        <p class="text-sm {{ $template['muted'] }}">Location</p>
                                        <p class="mt-1 font-bold">{{ $portfolio->location }}</p>
                                    </div>
                                @endif

                                @if ($portfolio->website)
                                    <a href="{{ $portfolio->website }}" target="_blank"
                                        class="{{ $buttonClass }} {{ $template['soft'] }} border border-current/10 p-5 transition hover:-translate-y-0.5">
                                        <p class="text-sm {{ $template['muted'] }}">Website</p>
                                        <p class="mt-1 font-bold">{{ $portfolio->website }}</p>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </body>
</html>
