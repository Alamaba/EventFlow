@extends('layouts.app')

@section('title', 'Mes Événements')

@section('header', 'Mes Événements')

@section('content')
<div class="space-y-6">

    @if($events->isEmpty())
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 py-20 text-center">
        <div class="w-20 h-20 bg-indigo-50 rounded-2xl flex items-center justify-center mx-auto mb-5">
            <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucun événement assigné</h3>
        <p class="text-gray-500">Contactez votre organisateur pour être assigné à un événement</p>
    </div>
    @else

    {{-- Stats rapides --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center space-x-4">
            <div class="w-11 h-11 bg-indigo-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $events->count() }}</p>
                <p class="text-sm text-gray-500">Événements assignés</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center space-x-4">
            <div class="w-11 h-11 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $events->where('status', 'publie')->count() }}</p>
                <p class="text-sm text-gray-500">Événements publiés</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center space-x-4">
            <div class="w-11 h-11 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $events->sum('guests_count') }}</p>
                <p class="text-sm text-gray-500">Total invités</p>
            </div>
        </div>
    </div>

    {{-- Grille des événements --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach($events as $event)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-lg transition-all duration-300">

            {{-- Cover Image ou dégradé --}}
            <div class="h-44 relative overflow-hidden">
                @if($event->cover_image)
                    <img src="{{ Storage::url($event->cover_image) }}" alt="{{ $event->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    @php
                        $gradients = ['from-indigo-400 to-purple-500','from-pink-400 to-rose-500','from-cyan-400 to-blue-500','from-green-400 to-emerald-500','from-orange-400 to-amber-500','from-violet-400 to-purple-600'];
                        $gradient = $gradients[crc32($event->title) % count($gradients)];
                    @endphp
                    <div class="w-full h-full bg-gradient-to-br {{ $gradient }} flex items-center justify-center group-hover:scale-105 transition-transform duration-500">
                        <svg class="w-14 h-14 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif

                {{-- Badge statut --}}
                <div class="absolute top-3 right-3">
                    @php
                        $statusColors = [
                            'brouillon' => 'bg-gray-800/70 text-white',
                            'publie'    => 'bg-green-500/90 text-white',
                            'annule'    => 'bg-red-500/90 text-white',
                            'termine'   => 'bg-blue-500/90 text-white',
                        ];
                        $color = $statusColors[$event->status] ?? 'bg-gray-800/70 text-white';
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium backdrop-blur-sm {{ $color }}">
                        {{ ucfirst($event->status) }}
                    </span>
                </div>

                {{-- Badge type --}}
                @if($event->type)
                <div class="absolute top-3 left-3">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-white/90 text-gray-700 capitalize">
                        {{ $event->type }}
                    </span>
                </div>
                @endif

                {{-- Calendrier date --}}
                <div class="absolute bottom-3 left-3">
                    <div class="w-12 h-12 bg-white rounded-xl shadow-md flex flex-col items-center justify-center">
                        <span class="text-indigo-600 text-sm font-bold leading-none">{{ \Carbon\Carbon::parse($event->date_start)->format('d') }}</span>
                        <span class="text-gray-500 text-xs leading-none mt-0.5 uppercase">{{ \Carbon\Carbon::parse($event->date_start)->translatedFormat('M') }}</span>
                    </div>
                </div>
            </div>

            {{-- Contenu --}}
            <div class="p-5">
                <h3 class="font-bold text-gray-900 text-lg leading-tight truncate">{{ $event->title }}</h3>

                <div class="space-y-1.5 mt-3 text-sm text-gray-500">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($event->date_start)->format('d/m/Y H:i') }}</span>
                    </div>

                    @if($event->venue)
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="truncate">{{ $event->venue }}</span>
                    </div>
                    @endif

                    @if($event->organisateur)
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span class="truncate">{{ $event->organisateur->name }}</span>
                    </div>
                    @endif

                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>{{ $event->guests_count ?? 0 }}
                            @if($event->capacity) / {{ $event->capacity }} @endif
                            invités
                        </span>
                    </div>
                </div>

                {{-- Barre de progression capacité --}}
                @if($event->capacity > 0)
                <div class="mt-3">
                    @php $pct = min(100, round((($event->guests_count ?? 0) / $event->capacity) * 100)); @endphp
                    <div class="flex items-center justify-between text-xs text-gray-400 mb-1">
                        <span>Capacité</span>
                        <span>{{ $pct }}%</span>
                    </div>
                    <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-indigo-500 rounded-full transition-all" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
                @endif

                {{-- Actions --}}
                <div class="mt-4 pt-4 border-t border-gray-100 flex items-center gap-2">
                    <a href="{{ route('agent.events.guests', $event) }}"
                       class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 border border-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>Invités</span>
                    </a>
                    <a href="{{ route('agent.events.scan', $event) }}"
                       class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                        <span>Scanner</span>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @endif
</div>
@endsection
