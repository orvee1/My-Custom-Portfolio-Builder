@csrf
@if (isset($user))
    @method('PUT')
@endif

<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
    <div>
        <label class="mb-1 block text-sm font-medium text-gray-700">
            Name <span class="text-red-500">*</span>
        </label>
        <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}"
            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-1 block text-sm font-medium text-gray-700">
            Email <span class="text-red-500">*</span>
        </label>
        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}"
            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
        @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', isset($user) ? $user->is_active : true))
                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
            <span class="text-sm font-medium text-gray-700">Active user</span>
        </label>
        @error('is_active')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-1 block text-sm font-medium text-gray-700">
            Password {{ isset($user) ? '' : '*' }}
        </label>
        <input type="password" name="password"
            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
        @if (isset($user))
            <p class="mt-1 text-xs text-gray-500">Leave blank to keep the current password.</p>
        @endif
        @error('password')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-1 block text-sm font-medium text-gray-700">
            Confirm Password {{ isset($user) ? '' : '*' }}
        </label>
        <input type="password" name="password_confirmation"
            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
    </div>
</div>

<div class="mt-6 flex items-center gap-3">
    <button type="submit"
        class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
        {{ isset($user) ? 'Update Admin' : 'Create Admin' }}
    </button>

    <a href="{{ route('admin.users.index') }}"
        class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">
        Cancel
    </a>
</div>
