@extends('layouts.admin')

@section('title', 'Create Admin User')

@section('content')
<div class="mx-auto max-w-4xl space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Create Admin User</h1>
        <p class="text-sm text-gray-500">
            Create a new admin account. A draft portfolio will be created automatically.
        </p>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @include('admin.users._form')
        </form>
    </div>
</div>
@endsection
