<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ trim($__env->yieldContent('title', 'Authentication')) }} | Portfolio Builder</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="min-h-screen bg-slate-950 text-white antialiased">
    <div class="relative min-h-screen overflow-hidden">
        {{-- Background effects --}}
        <div class="absolute inset-0">
            <div class="absolute left-[-10%] top-[-20%] h-96 w-96 rounded-full bg-indigo-600/30 blur-3xl"></div>
            <div class="absolute bottom-[-20%] right-[-10%] h-96 w-96 rounded-full bg-fuchsia-600/20 blur-3xl"></div>
            <div
                class="absolute left-1/2 top-1/2 h-72 w-72 -translate-x-1/2 -translate-y-1/2 rounded-full bg-cyan-500/10 blur-3xl">
            </div>
        </div>

        <div
            class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(99,102,241,0.14),transparent_35%),linear-gradient(to_bottom_right,rgba(15,23,42,0.98),rgba(2,6,23,0.98))]">
        </div>

        <div class="relative grid min-h-screen lg:grid-cols-2">
            {{-- Left branding section --}}
            <section class="hidden flex-col justify-between p-10 lg:flex xl:p-14">
                <div>
                    <a href="{{ route('welcome') }}" class="inline-flex items-center gap-3">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-xl font-black text-slate-950 shadow-xl">
                            P
                        </div>

                        <div>
                            <p class="text-lg font-black tracking-tight">
                                Portfolio Builder
                            </p>
                            <p class="text-xs font-medium text-slate-400">
                                Build, publish, and share your professional identity
                            </p>
                        </div>
                    </a>
                </div>

                <div class="max-w-xl">
                    <div
                        class="mb-6 inline-flex rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm font-semibold text-indigo-200 backdrop-blur">
                        Premium portfolio management platform
                    </div>

                    <h1 class="text-5xl font-black leading-tight tracking-tight xl:text-6xl">
                        Create portfolios that look sharp, modern, and professional.
                    </h1>

                    <p class="mt-6 max-w-lg text-lg leading-8 text-slate-300">
                        Manage projects, skills, resumes, experience, education, and custom sections from one elegant
                        admin panel.
                    </p>

                    <div class="mt-10 grid grid-cols-3 gap-4">
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                            <p class="text-3xl font-black text-white">01</p>
                            <p class="mt-2 text-sm text-slate-400">Create profile</p>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                            <p class="text-3xl font-black text-white">02</p>
                            <p class="mt-2 text-sm text-slate-400">Add content</p>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                            <p class="text-3xl font-black text-white">03</p>
                            <p class="mt-2 text-sm text-slate-400">Publish URL</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between border-t border-white/10 pt-6 text-sm text-slate-400">
                    <p>© {{ date('Y') }} Portfolio Builder</p>
                    <p>Laravel + Tailwind CSS</p>
                </div>
            </section>

            {{-- Right auth card --}}
            <section class="flex min-h-screen items-center justify-center px-6 py-10 sm:px-8 lg:px-12">
                <div class="w-full max-w-md">
                    <div class="mb-8 text-center lg:hidden">
                        <a href="{{ route('welcome') }}" class="inline-flex items-center justify-center gap-3">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-xl font-black text-slate-950 shadow-xl">
                                P
                            </div>
                            <span class="text-xl font-black">Portfolio Builder</span>
                        </a>
                    </div>

                    <div
                        class="rounded-[2rem] border border-white/10 bg-white/[0.07] p-6 shadow-2xl shadow-indigo-950/30 backdrop-blur-xl sm:p-8">
                        @yield('content')
                    </div>

                    <p class="mt-8 text-center text-xs leading-6 text-slate-500">
                        Secure access for portfolio admins and super admins.
                    </p>
                </div>
            </section>
        </div>
    </div>
</body>

</html>
