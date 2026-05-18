<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Portfolio Builder') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#f7f0e8] text-zinc-950 antialiased">
        <div class="absolute inset-x-0 top-0 -z-10 overflow-hidden">
            <div class="mx-auto h-80 max-w-7xl bg-[radial-gradient(circle_at_top_left,_rgba(234,88,12,0.22),_transparent_34%),radial-gradient(circle_at_top_right,_rgba(20,184,166,0.16),_transparent_28%),linear-gradient(180deg,_rgba(255,255,255,0.92),_rgba(247,240,232,0.8))]"></div>
        </div>

        <header class="mx-auto flex max-w-7xl items-center justify-between px-6 py-6 lg:px-8">
            <a href="{{ route('welcome') }}" class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-zinc-950 text-lg font-black text-white">
                    PB
                </div>
                <div>
                    <p class="text-sm font-black uppercase tracking-[0.25em] text-orange-600">Portfolio Builder</p>
                    <p class="text-xs text-zinc-500">Launch a portfolio that feels premium</p>
                </div>
            </a>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="rounded-full border border-zinc-300 bg-white px-5 py-2.5 text-sm font-semibold text-zinc-900 transition hover:-translate-y-0.5 hover:shadow-lg">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="rounded-full border border-zinc-300 bg-white px-5 py-2.5 text-sm font-semibold text-zinc-900 transition hover:-translate-y-0.5 hover:shadow-lg">
                        Sign In
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="rounded-full bg-zinc-950 px-5 py-2.5 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-orange-600 hover:shadow-lg">
                            Start Building
                        </a>
                    @endif
                @endauth
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-6 pb-16 pt-6 lg:px-8 lg:pb-24">
            <section class="grid gap-12 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
                <div class="max-w-2xl">
                    <p class="inline-flex rounded-full border border-orange-200 bg-orange-50 px-4 py-1 text-xs font-bold uppercase tracking-[0.3em] text-orange-700">
                        Built For Creators, Developers, Designers
                    </p>

                    <h1 class="mt-8 font-serif text-5xl leading-none tracking-tight text-zinc-950 md:text-7xl">
                        Your portfolio should look hired before you are.
                    </h1>

                    <p class="mt-6 max-w-xl text-lg leading-8 text-zinc-600">
                        Create a polished personal site with guided setup, section-based editing, and public portfolio templates
                        that feel intentional from day one.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-4">
                        @auth
                            <a href="{{ route('admin.portfolios.mine') }}"
                                class="rounded-full bg-zinc-950 px-6 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-orange-600 hover:shadow-xl">
                                Open My Portfolio
                            </a>
                        @else
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="rounded-full bg-zinc-950 px-6 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-orange-600 hover:shadow-xl">
                                    Create Your Portfolio
                                </a>
                            @endif

                            <a href="{{ route('login') }}"
                                class="rounded-full border border-zinc-300 bg-white px-6 py-3 text-sm font-semibold text-zinc-900 transition hover:-translate-y-0.5 hover:shadow-lg">
                                Continue Setup
                            </a>
                        @endauth
                    </div>

                    <div class="mt-12 grid gap-4 sm:grid-cols-3">
                        <div class="rounded-3xl border border-white/70 bg-white/75 p-5 shadow-sm backdrop-blur">
                            <p class="text-3xl font-black text-zinc-950">3</p>
                            <p class="mt-2 text-sm text-zinc-600">Ready-made portfolio directions</p>
                        </div>
                        <div class="rounded-3xl border border-white/70 bg-white/75 p-5 shadow-sm backdrop-blur">
                            <p class="text-3xl font-black text-zinc-950">6</p>
                            <p class="mt-2 text-sm text-zinc-600">Content sections to build your story</p>
                        </div>
                        <div class="rounded-3xl border border-white/70 bg-white/75 p-5 shadow-sm backdrop-blur">
                            <p class="text-3xl font-black text-zinc-950">1</p>
                            <p class="mt-2 text-sm text-zinc-600">Public link you can share anywhere</p>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="absolute -left-6 top-10 h-32 w-32 rounded-full bg-orange-300/40 blur-3xl"></div>
                    <div class="absolute -right-6 bottom-10 h-40 w-40 rounded-full bg-teal-300/30 blur-3xl"></div>

                    <div class="relative overflow-hidden rounded-[2rem] border border-zinc-200 bg-white shadow-2xl">
                        <div class="border-b border-zinc-200 bg-zinc-950 px-6 py-4 text-white">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p class="text-xs uppercase tracking-[0.35em] text-orange-300">Live Preview</p>
                                    <p class="mt-1 text-lg font-bold">Premium portfolio templates</p>
                                </div>
                                <div class="rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-white/80">
                                    /p/your-name
                                </div>
                            </div>
                        </div>

                        <div class="grid gap-6 p-6">
                            <div class="rounded-[1.75rem] bg-[linear-gradient(135deg,_#111827,_#1f2937_45%,_#ea580c_160%)] p-6 text-white">
                                <p class="text-xs font-bold uppercase tracking-[0.3em] text-orange-300">Creative Dark</p>
                                <h2 class="mt-3 text-3xl font-black">Bold, editorial, high contrast.</h2>
                                <div class="mt-8 flex gap-3">
                                    <span class="rounded-full bg-white/10 px-3 py-1 text-xs">Featured work</span>
                                    <span class="rounded-full bg-white/10 px-3 py-1 text-xs">Case studies</span>
                                </div>
                            </div>

                            <div class="grid gap-4 md:grid-cols-2">
                                <div class="rounded-[1.5rem] border border-zinc-200 bg-[#fff9f2] p-5">
                                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-orange-600">Minimal Clean</p>
                                    <p class="mt-3 text-xl font-black text-zinc-950">Quiet, refined, product-minded.</p>
                                </div>

                                <div class="rounded-[1.5rem] border border-zinc-200 bg-[#f3f7ff] p-5">
                                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-blue-600">Premium Modern</p>
                                    <p class="mt-3 text-xl font-black text-zinc-950">Sharp, polished, conversion-ready.</p>
                                </div>
                            </div>

                            <div class="rounded-[1.5rem] border border-dashed border-zinc-300 bg-zinc-50 p-5">
                                <p class="text-sm font-semibold text-zinc-900">Guided setup inside the dashboard</p>
                                <p class="mt-2 text-sm leading-6 text-zinc-600">
                                    Start with your identity, add projects and experience, choose a template, preview instantly, then publish.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mt-20 grid gap-6 lg:grid-cols-3">
                <div class="rounded-[2rem] border border-zinc-200 bg-white p-8 shadow-sm">
                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-orange-600">Step 1</p>
                    <h2 class="mt-4 text-2xl font-black text-zinc-950">Set up your identity</h2>
                    <p class="mt-3 text-sm leading-7 text-zinc-600">
                        Add your title, bio, contact details, colors, and a public slug with a setup flow that feels closer to a product wizard than a raw admin form.
                    </p>
                </div>

                <div class="rounded-[2rem] border border-zinc-200 bg-white p-8 shadow-sm">
                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-teal-600">Step 2</p>
                    <h2 class="mt-4 text-2xl font-black text-zinc-950">Build your sections</h2>
                    <p class="mt-3 text-sm leading-7 text-zinc-600">
                        Organize projects, skills, experience, education, and social links as clean modular content blocks that can be turned on or off.
                    </p>
                </div>

                <div class="rounded-[2rem] border border-zinc-200 bg-white p-8 shadow-sm">
                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-blue-600">Step 3</p>
                    <h2 class="mt-4 text-2xl font-black text-zinc-950">Publish and share</h2>
                    <p class="mt-3 text-sm leading-7 text-zinc-600">
                        Preview before launch, then publish a public page that already feels designed instead of looking like a starter template.
                    </p>
                </div>
            </section>
        </main>
    </body>
</html>
