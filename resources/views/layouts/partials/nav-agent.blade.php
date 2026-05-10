<p class="px-3 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Principal</p>

<a href="{{ route('agent.dashboard') }}"
   class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150
          {{ request()->routeIs('agent.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/25' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
    @if(request()->routeIs('agent.dashboard'))
        <span class="absolute left-0 inset-y-2 w-0.5 bg-indigo-300 rounded-r-full"></span>
    @endif
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm10 0a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zm10-3a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-7z"/>
    </svg>
    <span>Tableau de bord</span>
</a>

<div class="mt-4 mb-2">
    <p class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Activité</p>
</div>

<a href="{{ route('agent.events.index') }}"
   class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150
          {{ request()->routeIs('agent.events.index') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/25' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
    @if(request()->routeIs('agent.events.index'))
        <span class="absolute left-0 inset-y-2 w-0.5 bg-indigo-300 rounded-r-full"></span>
    @endif
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
    </svg>
    <span>Mes événements</span>
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
