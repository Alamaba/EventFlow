@php
function navItem(string $label, string $route, string $icon, string $pattern): string {
    $active = request()->routeIs($pattern);
    $base   = 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 group';
    $cls    = $active
        ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/25'
        : 'text-slate-400 hover:bg-slate-800 hover:text-white';
    $left   = $active ? '<span class="absolute left-0 inset-y-2 w-0.5 bg-indigo-300 rounded-r-full"></span>' : '';
    return '<a href="' . route($route) . '" class="relative ' . $base . ' ' . $cls . '">' . $left . $icon . '<span>' . $label . '</span></a>';
}
@endphp

<p class="px-3 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Principal</p>

<a href="{{ route('admin.dashboard') }}"
   class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150
          {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/25' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
    @if(request()->routeIs('admin.dashboard'))
        <span class="absolute left-0 inset-y-2 w-0.5 bg-indigo-300 rounded-r-full"></span>
    @endif
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm10 0a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zm10-3a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-7z"/>
    </svg>
    <span>Tableau de bord</span>
</a>

<div class="mt-4 mb-2">
    <p class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Gestion</p>
</div>

<a href="{{ route('admin.organisateurs.index') }}"
   class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150
          {{ request()->routeIs('admin.organisateurs.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/25' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
    @if(request()->routeIs('admin.organisateurs.*'))
        <span class="absolute left-0 inset-y-2 w-0.5 bg-indigo-300 rounded-r-full"></span>
    @endif
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
    </svg>
    <span>Organisateurs</span>
</a>

<a href="{{ route('admin.events.index') }}"
   class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150
          {{ request()->routeIs('admin.events.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/25' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
    @if(request()->routeIs('admin.events.*'))
        <span class="absolute left-0 inset-y-2 w-0.5 bg-indigo-300 rounded-r-full"></span>
    @endif
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
    </svg>
    <span>Événements</span>
</a>

<div class="mt-4 mb-2">
    <p class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Compte</p>
</div>

<a href="{{ route('profile.edit') }}"
   class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150
          {{ request()->routeIs('profile.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/25' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
    @if(request()->routeIs('profile.*'))
        <span class="absolute left-0 inset-y-2 w-0.5 bg-indigo-300 rounded-r-full"></span>
    @endif
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
    </svg>
    <span>Mon profil</span>
</a>
