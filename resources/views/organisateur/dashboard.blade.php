@extends('layouts.app')

@section('title', 'Mon tableau de bord')

@section('header', 'Tableau de bord')

@section('header-actions')
    <a href="{{ route('organisateur.events.create') }}"
       class="inline-flex items-center space-x-2 bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition-colors shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <span>Créer un événement</span>
    </a>
@endsection

@section('content')
<div class="space-y-8">

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['events_total'] }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Événements</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['events_publie'] }}</p>
            <p class="text-sm text-gray-500 mt-1">Publiés</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['guests_total'] }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Invités</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['tickets_valides'] }}</p>
            <p class="text-sm text-gray-500 mt-1">Tickets Validés</p>
        </div>

        <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl shadow-sm p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-white">{{ number_format($stats['revenus'], 0) }}</p>
            <p class="text-sm text-white/80 mt-1">Revenus (DJF)</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Upcoming Events --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Prochains Événements</h3>
                <a href="{{ route('organisateur.events.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">Voir tout</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($upcomingEvents as $event)
                <div class="px-6 py-4 flex items-center space-x-4 hover:bg-gray-50 transition-colors">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-xl flex flex-col items-center justify-center flex-shrink-0">
                        <span class="text-white text-xs font-bold">{{ \Carbon\Carbon::parse($event->date_start)->format('d') }}</span>
                        <span class="text-white/80 text-xs">{{ \Carbon\Carbon::parse($event->date_start)->format('M') }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-900 text-sm truncate">{{ $event->title }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $event->venue }}</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="text-sm font-semibold text-indigo-600">{{ $event->guests_count ?? 0 }}</p>
                        <p class="text-xs text-gray-400">invités</p>
                    </div>
                </div>
                @empty
                <div class="px-6 py-10 text-center text-gray-400 text-sm">Aucun événement à venir</div>
                @endforelse
            </div>
        </div>

        {{-- Recent Events Grid --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Événements Récents</h3>
            </div>
            <div class="p-4 grid grid-cols-1 gap-3">
                @forelse($events as $event)
                <a href="{{ route('organisateur.events.show', $event) }}"
                   class="block p-4 border border-gray-100 rounded-xl hover:border-indigo-200 hover:bg-indigo-50/30 transition-all group">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-900 text-sm truncate group-hover:text-indigo-700 transition-colors">{{ $event->title }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ \Carbon\Carbon::parse($event->date_start)->format('d/m/Y H:i') }}</p>
                        </div>
                        @php
                            $statusColors = ['brouillon'=>'bg-gray-100 text-gray-600','publie'=>'bg-green-100 text-green-700','annule'=>'bg-red-100 text-red-700','termine'=>'bg-blue-100 text-blue-700'];
                            $color = $statusColors[$event->status] ?? 'bg-gray-100 text-gray-600';
                        @endphp
                        <span class="ml-2 flex-shrink-0 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $color }}">{{ ucfirst($event->status) }}</span>
                    </div>
                    <div class="mt-2 flex items-center space-x-3 text-xs text-gray-500">
                        <span>{{ $event->guests_count ?? 0 }} invités</span>
                        <span>•</span>
                        <span>{{ $event->venue ?? 'Lieu non défini' }}</span>
                    </div>
                </a>
                @empty
                <div class="py-8 text-center text-gray-400 text-sm">Aucun événement récent</div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
