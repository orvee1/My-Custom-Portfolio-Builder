<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-slate-950 text-white antialiased">
    <div class="relative min-h-screen overflow-hidden">
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute -left-24 -top-24 h-96 w-96 rounded-full bg-indigo-600/30 blur-3xl"></div>
            <div class="absolute -bottom-28 -right-20 h-96 w-96 rounded-full bg-fuchsia-500/20 blur-3xl"></div>
            <div
                class="absolute left-1/2 top-1/2 h-72 w-72 -translate-x-1/2 -translate-y-1/2 rounded-full bg-cyan-500/10 blur-3xl">
            </div>
        </div>

        <div
            class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(99,102,241,0.18),transparent_32%),linear-gradient(135deg,rgba(2,6,23,0.98),rgba(15,23,42,0.98))]">
        </div>

        <div class="relative grid min-h-screen lg:grid-cols-[1.05fr_0.95fr]">
            <section class="hidden flex-col justify-between p-10 lg:flex xl:p-14">
                <a href="{{ route('welcome') }}" class="inline-flex items-center gap-3" wire:navigate>
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-xl font-black text-slate-950 shadow-xl">
                        PB
                    </div>

                    <div>
                        <p class="text-lg font-black tracking-tight">
                            Portfolio Builder
                        </p>
                        <p class="text-xs font-medium text-slate-400">
                            Premium portfolio SaaS platform
                        </p>
                    </div>
                </a>

                <div class="max-w-2xl">
                    <div
                        class="mb-6 inline-flex rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm font-semibold text-indigo-200 backdrop-blur">
                        Built for professionals, creators, developers, and agencies
                    </div>

                    <h1 class="text-5xl font-black leading-tight tracking-tight xl:text-6xl">
                        Build a portfolio that feels premium before visitors even scroll.
                    </h1>

                    <p class="mt-6 max-w-xl text-lg leading-8 text-slate-300">
                        Manage public profile, projects, skills, education, experience, resume, and shareable portfolio
                        URLs from one polished dashboard.
                    </p>

                    <div class="mt-10 grid grid-cols-3 gap-4">
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                            <p class="text-3xl font-black text-white">01</p>
                            <p class="mt-2 text-sm text-slate-400">Register</p>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                            <p class="text-3xl font-black text-white">02</p>
                            <p class="mt-2 text-sm text-slate-400">Approval</p>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                            <p class="text-3xl font-black text-white">03</p>
                            <p class="mt-2 text-sm text-slate-400">Publish</p>
                        </div>
                    </div>

                    <div class="mt-10 rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                        <p class="text-sm font-bold text-white">
                            Marketplace-ready idea
                        </p>
                        <p class="mt-2 text-sm leading-6 text-slate-400">
                            Super admin approval keeps the platform controlled, premium, and safer for paid SaaS or
                            marketplace deployment.
                        </p>
                    </div>
                </div>

                <div class="flex items-center justify-between border-t border-white/10 pt-6 text-sm text-slate-400">
                    <p>© {{ date('Y') }} Portfolio Builder</p>
                    <p>Laravel + Tailwind CSS</p>
                </div>
            </section>

            <section class="flex min-h-screen items-center justify-center px-6 py-10 sm:px-8 lg:px-12">
                <div class="w-full max-w-md">
                    <div class="mb-8 text-center lg:hidden">
                        <a href="{{ route('welcome') }}" class="inline-flex items-center justify-center gap-3"
                            wire:navigate>
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-xl font-black text-slate-950 shadow-xl">
                                PB
                            </div>
                            <span class="text-xl font-black">Portfolio Builder</span>
                        </a>
                    </div>

                    <div
                        class="rounded-[2rem] border border-white/10 bg-white/[0.07] p-6 shadow-2xl shadow-indigo-950/30 backdrop-blur-xl sm:p-8">
                        {{ $slot }}
                    </div>

                    <p class="mt-8 text-center text-xs leading-6 text-slate-500">
                        Secure access for portfolio admins and super admins.
                    </p>
                </div>
            </section>
        </div>
    </div>

    @persist('toast')
        <flux:toast.group>
            <flux:toast />
        </flux:toast.group>
    @endpersist

    @fluxScripts
</body>

</html>
