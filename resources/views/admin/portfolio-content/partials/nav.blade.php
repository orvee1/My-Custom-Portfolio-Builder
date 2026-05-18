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

        <a href="{{ route('admin.portfolios.experiences.index', $portfolio) }}"
           class="rounded-lg px-4 py-2 text-sm font-semibold {{ request()->routeIs('admin.portfolios.experiences.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
            Experiences
        </a>

        <a href="{{ route('admin.portfolios.educations.index', $portfolio) }}"
           class="rounded-lg px-4 py-2 text-sm font-semibold {{ request()->routeIs('admin.portfolios.educations.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
            Educations
        </a>

        <a href="{{ route('admin.portfolios.skills.index', $portfolio) }}"
           class="rounded-lg px-4 py-2 text-sm font-semibold {{ request()->routeIs('admin.portfolios.skills.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
            Skills
        </a>

        <a href="{{ route('admin.portfolios.social-links.index', $portfolio) }}"
           class="rounded-lg px-4 py-2 text-sm font-semibold {{ request()->routeIs('admin.portfolios.social-links.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
            Social Links
        </a>
    </div>
</div>
