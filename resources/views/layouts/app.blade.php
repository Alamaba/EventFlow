<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — EventFlow</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-slate-50 font-sans antialiased">

@php $role = auth()->user()?->role; $user = auth()->user(); @endphp

<div class="flex h-full">

    {{-- ===== SIDEBAR ===== --}}
    <aside id="sidebar"
        class="fixed inset-y-0 left-0 z-40 flex flex-col w-64 bg-slate-900 shadow-2xl
               transition-transform duration-300 -translate-x-full md:translate-x-0 md:static md:flex">

        {{-- Logo --}}
        <div class="flex items-center h-16 px-5 border-b border-slate-700/50 flex-shrink-0">
            <a href="{{ route($role . '.dashboard') }}" class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/30">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-white font-bold text-lg tracking-tight">
                    <span class="text-indigo-400">Event</span>Flow
                </span>
            </a>
            {{-- Mobile close --}}
            <button id="sidebar-close" class="ml-auto md:hidden text-slate-400 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-4 overflow-y-auto space-y-0.5">
            @if($role === 'admin')
                @include('layouts.partials.nav-admin')
            @elseif($role === 'organisateur')
                @include('layouts.partials.nav-organisateur')
            @elseif($role === 'agent')
                @include('layouts.partials.nav-agent')
            @endif
        </nav>

        {{-- User card --}}
        <div class="p-3 border-t border-slate-700/50 flex-shrink-0">
            <a href="{{ route('profile.edit') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-800 transition-colors group">
                <img src="{{ $user->avatar_url }}" alt="" class="w-9 h-9 rounded-xl ring-2 ring-indigo-500/40 flex-shrink-0">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-white truncate">{{ $user->name }}</p>
                    <p class="text-xs text-slate-400 capitalize">{{ $user->role }}</p>
                </div>
                <svg class="w-4 h-4 text-slate-500 group-hover:text-slate-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="mt-1">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-slate-400 hover:text-red-400 hover:bg-red-500/10 text-xs font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Se déconnecter
                </button>
            </form>
        </div>
    </aside>

    {{-- Overlay mobile --}}
    <div id="sidebar-overlay" class="fixed inset-0 z-30 bg-black/50 hidden md:hidden"></div>

    {{-- ===== MAIN ===== --}}
    <div class="flex flex-col flex-1 min-w-0 overflow-hidden">

        {{-- TOPBAR --}}
        <header class="flex items-center h-16 px-4 md:px-6 bg-white border-b border-gray-100 shadow-sm flex-shrink-0 gap-4">

            {{-- Mobile hamburger --}}
            <button id="sidebar-open" class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            {{-- Page title --}}
            <div class="flex-1 min-w-0">
                <h1 class="text-base font-semibold text-gray-800 truncate">@yield('header', 'Dashboard')</h1>
            </div>

            {{-- Right actions --}}
            <div class="flex items-center gap-2">
                @yield('header-actions')

                {{-- Profile avatar --}}
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 ml-2 pl-3 border-l border-gray-100">
                    <img src="{{ $user->avatar_url }}" alt="" class="w-8 h-8 rounded-lg ring-2 ring-indigo-100">
                    <span class="hidden sm:block text-sm font-medium text-gray-700 max-w-[100px] truncate">{{ $user->name }}</span>
                </a>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="flex-1 overflow-y-auto p-4 md:p-6">

            @if(session('success'))
                <div class="mb-5 flex items-center gap-3 px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-sm">
                    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-5 flex items-center gap-3 px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-red-800 text-sm">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9a1 1 0 012 0v4a1 1 0 11-2 0V9zm1-5a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif
            @if(session('info'))
                <div class="mb-5 flex items-center gap-3 px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl text-blue-800 text-sm">
                    <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('info') }}
                </div>
            @endif
            @if($errors->any())
                <div class="mb-5 px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-red-800 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script>
    const sidebar        = document.getElementById('sidebar');
    const overlay        = document.getElementById('sidebar-overlay');
    const openBtn        = document.getElementById('sidebar-open');
    const closeBtn       = document.getElementById('sidebar-close');

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    }
    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    }

    openBtn?.addEventListener('click', openSidebar);
    closeBtn?.addEventListener('click', closeSidebar);
    overlay?.addEventListener('click', closeSidebar);
</script>

@stack('scripts')
</body>
</html>
