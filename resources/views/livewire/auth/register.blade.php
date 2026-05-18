<x-layouts::auth :title="__('Register')">
    <div>
        <div class="mb-8">
            <p
                class="mb-3 inline-flex rounded-full bg-indigo-500/10 px-3 py-1 text-xs font-bold uppercase tracking-widest text-indigo-300">
                Request access
            </p>

            <h1 class="text-3xl font-black tracking-tight text-white">
                Create your portfolio account
            </h1>

            <p class="mt-3 text-sm leading-6 text-slate-400">
                Submit your account request. A super admin will review and approve your access.
            </p>
        </div>

        <div class="mb-5 rounded-2xl border border-yellow-400/20 bg-yellow-400/10 px-4 py-3 text-sm text-yellow-100">
            After registration, your account will stay pending until a super admin approves it.
        </div>

        @if ($errors->any())
            <div class="mb-5 rounded-2xl border border-red-400/20 bg-red-400/10 px-4 py-3 text-sm text-red-200">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="mb-2 block text-sm font-semibold text-slate-200">
                    Full name
                </label>

                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    autocomplete="name" placeholder="Your full name"
                    class="w-full rounded-2xl border border-white/10 bg-white/10 px-4 py-3 text-sm text-white placeholder:text-slate-500 outline-none transition focus:border-indigo-400 focus:bg-white/[0.13] focus:ring-4 focus:ring-indigo-500/20">

                @error('name')
                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="mb-2 block text-sm font-semibold text-slate-200">
                    Email address
                </label>

                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    autocomplete="email" placeholder="you@example.com"
                    class="w-full rounded-2xl border border-white/10 bg-white/10 px-4 py-3 text-sm text-white placeholder:text-slate-500 outline-none transition focus:border-indigo-400 focus:bg-white/[0.13] focus:ring-4 focus:ring-indigo-500/20">

                @error('email')
                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="mb-2 block text-sm font-semibold text-slate-200">
                    Password
                </label>

                <input id="password" type="password" name="password" required autocomplete="new-password"
                    placeholder="••••••••"
                    class="w-full rounded-2xl border border-white/10 bg-white/10 px-4 py-3 text-sm text-white placeholder:text-slate-500 outline-none transition focus:border-indigo-400 focus:bg-white/[0.13] focus:ring-4 focus:ring-indigo-500/20">

                @error('password')
                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-200">
                    Confirm password
                </label>

                <input id="password_confirmation" type="password" name="password_confirmation" required
                    autocomplete="new-password" placeholder="••••••••"
                    class="w-full rounded-2xl border border-white/10 bg-white/10 px-4 py-3 text-sm text-white placeholder:text-slate-500 outline-none transition focus:border-indigo-400 focus:bg-white/[0.13] focus:ring-4 focus:ring-indigo-500/20">
            </div>

            <button type="submit"
                class="group relative flex w-full items-center justify-center overflow-hidden rounded-2xl bg-indigo-500 px-5 py-3.5 text-sm font-black text-white shadow-lg shadow-indigo-950/30 transition hover:bg-indigo-400">
                <span class="absolute inset-0 translate-y-full bg-white/20 transition group-hover:translate-y-0"></span>
                <span class="relative">Submit for approval</span>
            </button>
        </form>

        <p class="mt-8 text-center text-sm text-slate-400">
            Already approved?
            <a href="{{ route('login') }}" wire:navigate class="font-bold text-indigo-300 hover:text-indigo-200">
                Sign in
            </a>
        </p>
    </div>
</x-layouts::auth>
