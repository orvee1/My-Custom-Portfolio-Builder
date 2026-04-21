<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ trim($__env->yieldContent('title', 'Admin Panel')) }} | Portfolio Builder</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('styles')
</head>

<body class="bg-gray-100 text-gray-800 antialiased">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen">
        <!-- Mobile overlay -->
        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-black/50 lg:hidden"
            @click="sidebarOpen = false" style="display: none;"></div>

        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r border-gray-200 bg-white shadow-xl transition-transform duration-300 lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            <!-- Brand -->
            <div class="flex h-20 items-center justify-between border-b border-gray-200 px-6">
                <div>
                    <a href="{{ url('/admin') }}" class="text-xl font-extrabold tracking-tight text-gray-900">
                        Portfolio<span class="text-indigo-600">Admin</span>
                    </a>
                    <p class="mt-1 text-xs text-gray-500">Manage portfolio platform</p>
                </div>

                <button type="button"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 lg:hidden"
                    @click="sidebarOpen = false">
                    ✕
                </button>
            </div>

            <!-- Logged user info -->
            <div class="border-b border-gray-200 px-6 py-5">
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100 text-lg font-bold text-indigo-700">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>

                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-gray-900">
                            {{ auth()->user()->name ?? 'User' }}
                        </p>
                        <p class="truncate text-xs text-gray-500">
                            {{ auth()->user()->email ?? '' }}
                        </p>
                        <span
                            class="mt-1 inline-flex rounded-full px-2 py-0.5 text-[11px] font-semibold
                            {{ auth()->user()?->role === 'super_admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ ucfirst(str_replace('_', ' ', auth()->user()->role ?? 'admin')) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto px-4 py-5">
                <div class="space-y-1">
                    <p class="px-3 pb-2 text-[11px] font-bold uppercase tracking-[0.2em] text-gray-400">
                        Main
                    </p>

                    <a href="{{ url('/admin') }}"
                        class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-100 hover:text-gray-900">
                        <span class="text-base">🏠</span>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('admin.profile.edit') }}"
                        class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-100 hover:text-gray-900">
                        <span class="text-base">👤</span>
                        <span>My Profile</span>
                    </a>
                </div>

                @if (auth()->user()?->isSuperAdmin())
                    <div class="mt-6 space-y-1">
                        <p class="px-3 pb-2 text-[11px] font-bold uppercase tracking-[0.2em] text-gray-400">
                            Super Admin
                        </p>

                        <a href="{{ route('admin.users.index') }}"
                            class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-100 hover:text-gray-900">
                            <span class="text-base">👥</span>
                            <span>Admin Users</span>
                        </a>
                    </div>
                @endif

                <div class="mt-6 space-y-1">
                    <p class="px-3 pb-2 text-[11px] font-bold uppercase tracking-[0.2em] text-gray-400">
                        Portfolio
                    </p>

                    <a href="#"
                        class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-100 hover:text-gray-900">
                        <span class="text-base">🗂️</span>
                        <span>My Portfolio</span>
                    </a>

                    <a href="#"
                        class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-100 hover:text-gray-900">
                        <span class="text-base">📄</span>
                        <span>Resume / CV</span>
                    </a>

                    <a href="#"
                        class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-100 hover:text-gray-900">
                        <span class="text-base">🧩</span>
                        <span>Custom Sections</span>
                    </a>
                </div>
            </nav>

            <!-- Bottom -->
            <div class="border-t border-gray-200 p-4">
                <a href="{{ url('/') }}" target="_blank"
                    class="mb-3 flex items-center justify-center rounded-xl border border-gray-300 px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                    View Website
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex w-full items-center justify-center rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-red-700">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main wrapper -->
        <div class="lg:pl-72">
            <!-- Topbar -->
            <header class="sticky top-0 z-30 border-b border-gray-200 bg-white/90 backdrop-blur">
                <div class="flex h-20 items-center justify-between px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-3">
                        <button type="button"
                            class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 lg:hidden"
                            @click="sidebarOpen = true">
                            ☰
                        </button>

                        <div>
                            <h1 class="text-lg font-bold text-gray-900">
                                @yield('title', 'Admin Panel')
                            </h1>
                            <p class="text-xs text-gray-500">
                                Portfolio Builder Administration
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="hidden text-right sm:block">
                            <p class="text-sm font-semibold text-gray-900">
                                {{ auth()->user()->name ?? '' }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ ucfirst(str_replace('_', ' ', auth()->user()->role ?? 'admin')) }}
                            </p>
                        </div>

                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-full bg-indigo-100 font-bold text-indigo-700">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page content -->
            <main class="p-4 sm:p-6 lg:p-8">
                @if (session('success'))
                    <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <ul class="list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')

    <!-- Alpine.js for sidebar toggle -->
    <script defer src="//unpkg.com/alpinejs"></script>
</body>

</html>
