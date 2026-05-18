<x-layouts::auth :title="__('Login')">
    <div>
        <div class="mb-8">
            <p
                class="mb-3 inline-flex rounded-full bg-indigo-500/10 px-3 py-1 text-xs font-bold uppercase tracking-widest text-indigo-300">
                Welcome back
            </p>

            <h1 class="text-3xl font-black tracking-tight text-white">
                Sign in to your dashboard
            </h1>

            <p class="mt-3 text-sm leading-6 text-slate-400">
                Manage your portfolio, resume, projects, skills, and public profile.
            </p>
        </div>

        @if (session('status'))
            <div class="mb-5 rounded-2xl border border-green-400/20 bg-green-400/10 px-4 py-3 text-sm text-green-200">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-5 rounded-2xl border border-red-400/20 bg-red-400/10 px-4 py-3 text-sm text-red-200">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="mb-2 block text-sm font-semibold text-slate-200">
                    Email address
                </label>

                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    autocomplete="email" placeholder="admin@example.com"
                    class="w-full rounded-2xl border border-white/10 bg-white/10 px-4 py-3 text-sm text-white placeholder:text-slate-500 outline-none transition focus:border-indigo-400 focus:bg-white/[0.13] focus:ring-4 focus:ring-indigo-500/20">

                @error('email')
                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <div class="mb-2 flex items-center justify-between">
                    <label for="password" class="block text-sm font-semibold text-slate-200">
                        Password
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" wire:navigate
                            class="text-xs font-semibold text-indigo-300 hover:text-indigo-200">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <input id="password" type="password" name="password" required autocomplete="current-password"
                    placeholder="••••••••"
                    class="w-full rounded-2xl border border-white/10 bg-white/10 px-4 py-3 text-sm text-white placeholder:text-slate-500 outline-none transition focus:border-indigo-400 focus:bg-white/[0.13] focus:ring-4 focus:ring-indigo-500/20">

                @error('password')
                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="remember"
                        class="rounded border-white/20 bg-white/10 text-indigo-500 focus:ring-indigo-500">
                    <span class="text-sm text-slate-400">Remember me</span>
                </label>
            </div>

            <button type="submit"
                class="group relative flex w-full items-center justify-center overflow-hidden rounded-2xl bg-indigo-500 px-5 py-3.5 text-sm font-black text-white shadow-lg shadow-indigo-950/30 transition hover:bg-indigo-400">
                <span class="absolute inset-0 translate-y-full bg-white/20 transition group-hover:translate-y-0"></span>
                <span class="relative">Sign in</span>
            </button>
        </form>

        @if (Route::has('register'))
            <p class="mt-8 text-center text-sm text-slate-400">
                Need an account?
                <a href="{{ route('register') }}" wire:navigate class="font-bold text-indigo-300 hover:text-indigo-200">
                    Request access
                </a>
            </p>
        @endif
    </div>
</x-layouts::auth>
