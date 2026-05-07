@extends('layouts.app')

@section('title', 'Tableau de bord Admin')

@section('header', 'Tableau de bord')

@section('header-actions')
    <span class="text-sm text-gray-500">Dernière mise à jour : {{ now()->format('d/m/Y H:i') }}</span>
@endsection

@section('content')
<div class="space-y-8">

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Organisateurs --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center space-x-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Organisateurs</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['organisateurs'] }}</p>
            </div>
        </div>

        {{-- Agents --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center space-x-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Agents</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['agents'] }}</p>
            </div>
        </div>

        {{-- Total Events --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center space-x-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Événements</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['events_total'] }}</p>
            </div>
        </div>

        {{-- Published Events --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center space-x-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Événements Publiés</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['events_publie'] }}</p>
            </div>
        </div>

        {{-- Draft Events --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center space-x-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Brouillons</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['events_brouillon'] }}</p>
            </div>
        </div>

        {{-- Total Tickets --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center space-x-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Tickets</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['tickets_total'] }}</p>
            </div>
        </div>

        {{-- Validated Tickets --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center space-x-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Tickets Validés</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['tickets_valides'] }}</p>
            </div>
        </div>

        {{-- Revenue --}}
        <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl shadow-sm p-6 flex items-center space-x-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-white/80">Revenus</p>
                <p class="text-2xl font-bold text-white">{{ number_format($stats['revenus'], 0) }} DJF</p>
            </div>
        </div>
    </div>

    {{-- Recent Events & Organisateurs --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Recent Events --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Événements Récents</h3>
                <a href="{{ route('admin.events.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">Voir tout</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Titre</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Organisateur</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($recentEvents as $event)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-900 text-sm">{{ $event->title }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600 capitalize">{{ $event->type }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($event->date_start)->format('d/m/Y') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'brouillon' => 'bg-gray-100 text-gray-700',
                                        'publie'    => 'bg-green-100 text-green-700',
                                        'annule'    => 'bg-red-100 text-red-700',
                                        'termine'   => 'bg-blue-100 text-blue-700',
                                    ];
                                    $color = $statusColors[$event->status] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600">{{ $event->organisateur->name ?? '-' }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400 text-sm">Aucun événement récent</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Recent Organisateurs --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Organisateurs Récents</h3>
                <a href="{{ route('admin.organisateurs.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">Voir tout</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($recentOrganisateurs as $org)
                <div class="px-6 py-4 flex items-center space-x-3 hover:bg-gray-50 transition-colors">
                    <div class="w-9 h-9 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-white text-sm font-semibold">{{ strtoupper(substr($org->name, 0, 1)) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $org->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $org->email }}</p>
                    </div>
                    <span class="text-xs font-medium text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full flex-shrink-0">
                        {{ $org->events_count }} év.
                    </span>
                </div>
                @empty
                <div class="px-6 py-8 text-center text-gray-400 text-sm">Aucun organisateur</div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
