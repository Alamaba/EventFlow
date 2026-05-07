@extends('layouts.app')

@section('title', 'Détails organisateur')

@section('header', $organisateur->name)

@section('header-actions')
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.organisateurs.edit', $organisateur) }}"
           class="inline-flex items-center space-x-2 border border-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-50 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            <span>Modifier</span>
        </a>
        <a href="{{ route('admin.organisateurs.index') }}"
           class="inline-flex items-center space-x-2 text-gray-600 hover:text-gray-900 font-medium transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Retour</span>
        </a>
    </div>
@endsection

@section('content')
<div class="space-y-6">

    {{-- Profile Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-8">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">{{ strtoupper(substr($organisateur->name, 0, 1)) }}</span>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white">{{ $organisateur->name }}</h2>
                    <p class="text-indigo-200">{{ $organisateur->email }}</p>
                    <div class="mt-2">
                        @if($organisateur->is_active)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-400/20 text-green-100 border border-green-400/30">
                                <span class="w-1.5 h-1.5 bg-green-300 rounded-full mr-1.5"></span>Compte actif
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-400/20 text-red-100 border border-red-400/30">
                                <span class="w-1.5 h-1.5 bg-red-300 rounded-full mr-1.5"></span>Compte inactif
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="px-8 py-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Téléphone</p>
                    <p class="text-gray-900 font-medium">{{ $organisateur->phone ?? 'Non renseigné' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Inscrit le</p>
                    <p class="text-gray-900 font-medium">{{ $organisateur->created_at->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Dernière connexion</p>
                    <p class="text-gray-900 font-medium">{{ $organisateur->last_login_at ? $organisateur->last_login_at->diffForHumans() : 'Jamais' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Events List --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">
                Événements
                <span class="ml-2 text-sm font-medium text-gray-400">({{ $organisateur->events->count() }})</span>
            </h3>
        </div>

        @if($organisateur->events->isEmpty())
        <div class="px-6 py-16 text-center">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-gray-400 font-medium">Aucun événement créé</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Titre</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Lieu</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($organisateur->events as $event)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 text-sm">{{ $event->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600 capitalize">{{ $event->type }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($event->date_start)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $event->venue ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = ['brouillon'=>'bg-gray-100 text-gray-700','publie'=>'bg-green-100 text-green-700','annule'=>'bg-red-100 text-red-700','termine'=>'bg-blue-100 text-blue-700'];
                                $color = $statusColors[$event->status] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">{{ ucfirst($event->status) }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</div>
@endsection
