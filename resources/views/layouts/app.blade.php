<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Page title: falls back to app name --}}
    <title>@yield('title', config('app.name', 'GroundedTime'))</title>

    {{--
        Tailwind Play CDN — development only.
        This script is a dynamic runtime that generates CSS on the fly, so
        Subresource Integrity (SRI) hashes cannot be applied to it.
        It MUST NOT be served in production; replace with a compiled
        CSS asset (npm run build) before deploying.
    --}}
    @if (app()->environment('local', 'testing'))
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    {{-- Additional head content from child views --}}
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen flex flex-col">

    {{-- Top navigation --}}
    @include('layouts._nav')

    {{-- Flash messages --}}
    @if (session('success'))
        <div class="max-w-4xl mx-auto mt-4 px-4">
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="max-w-4xl mx-auto mt-4 px-4">
            <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        </div>
    @endif

    {{-- Main content area --}}
    <main class="flex-1 max-w-4xl mx-auto w-full px-4 py-6">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="border-t border-gray-200 text-center text-sm text-gray-500 py-4">
        &copy; {{ date('Y') }} GroundedTime
    </footer>

    {{-- Scripts injected by child views --}}
    @stack('scripts')
</body>
</html>
