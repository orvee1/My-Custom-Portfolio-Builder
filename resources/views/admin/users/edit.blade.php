@extends('layouts.admin')

@section('title', 'Edit Admin User')

@section('content')
<div class="mx-auto max-w-4xl space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Edit Admin User</h1>
        <p class="text-sm text-gray-500">
            Update admin account information.
        </p>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @include('admin.users._form', ['user' => $user])
        </form>
    </div>
</div>
@endsection
