@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="space-y-6">
        <div class="rounded-2xl bg-gradient-to-r from-indigo-600 to-violet-600 p-6 text-white shadow-lg">
            <h2 class="text-2xl font-bold">Welcome back, {{ auth()->user()->name }}</h2>
            <p class="mt-2 text-sm text-indigo-100">
                Manage users, portfolios, resumes, and custom sections from your admin panel.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Total Admin Users</p>
                <h3 class="mt-2 text-3xl font-bold text-gray-900">12</h3>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Published Portfolios</p>
                <h3 class="mt-2 text-3xl font-bold text-gray-900">8</h3>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Uploaded Resumes</p>
                <h3 class="mt-2 text-3xl font-bold text-gray-900">20</h3>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Contact Messages</p>
                <h3 class="mt-2 text-3xl font-bold text-gray-900">15</h3>
            </div>
        </div>
    </div>
@endsection
