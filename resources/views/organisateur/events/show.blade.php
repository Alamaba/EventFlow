@extends('layouts.app')

@section('title', $event->title)

@section('header', $event->title)

@section('header-actions')
    <div class="flex items-center space-x-3">
        @if($event->status === 'brouillon')
        <form action="{{ route('organisateur.events.publish', $event) }}" method="POST" class="inline">
            @csrf
            <button type="submit"
                class="inline-flex items-center space-x-2 bg-green-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-700 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Publier l'événement</span>
            </button>
        </form>
        @endif
        <a href="{{ route('organisateur.events.edit', $event) }}"
           class="inline-flex items-center space-x-2 border border-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-50 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            <span>Modifier</span>
        </a>
        <a href="{{ route('organisateur.events.index') }}"
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

    {{-- Event Header --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="relative h-56 md:h-72">
            @if($event->cover_image)
                <img src="{{ Storage::url($event->cover_image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
            @else
                @php
                    $gradients = ['from-indigo-500 to-purple-600','from-pink-500 to-rose-600','from-cyan-500 to-blue-600'];
                    $gradient = $gradients[crc32($event->title) % count($gradients)];
                @endphp
                <div class="w-full h-full bg-gradient-to-br {{ $gradient }}"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
            @endif

            <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                <div class="flex items-end justify-between">
                    <div>
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="px-2.5 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs font-medium capitalize">{{ $event->type }}</span>
                            @php
                                $statusColors = ['brouillon'=>'bg-gray-500/80','publie'=>'bg-green-500/80','annule'=>'bg-red-500/80','termine'=>'bg-blue-500/80'];
                                $color = $statusColors[$event->status] ?? 'bg-gray-500/80';
                            @endphp
                            <span class="px-2.5 py-1 {{ $color }} backdrop-blur-sm rounded-full text-xs font-medium">{{ ucfirst($event->status) }}</span>
                        </div>
                        <h1 class="text-2xl md:text-3xl font-bold">{{ $event->title }}</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 py-5">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                <div class="flex items-center space-x-2 text-gray-600">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ \Carbon\Carbon::parse($event->date_start)->format('d/m/Y H:i') }}</span>
                </div>
                @if($event->venue)
                <div class="flex items-center space-x-2 text-gray-600">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    </svg>
                    <span>{{ $event->venue }}</span>
                </div>
                @endif
                @if($event->city)
                <div class="flex items-center space-x-2 text-gray-600">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                    </svg>
                    <span>{{ $event->city }}</span>
                </div>
                @endif
                <div class="flex items-center space-x-2 text-gray-600">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>{{ $event->capacity }} places</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        @php
            $miniStats = [
                ['label' => 'Total Invités', 'value' => $stats['guests_total'], 'color' => 'text-indigo-600', 'bg' => 'bg-indigo-50'],
                ['label' => 'Confirmés', 'value' => $stats['guests_confirmes'], 'color' => 'text-green-600', 'bg' => 'bg-green-50'],
                ['label' => 'Présents', 'value' => $stats['guests_presents'], 'color' => 'text-purple-600', 'bg' => 'bg-purple-50'],
                ['label' => 'Tickets Validés', 'value' => $stats['tickets_valides'], 'color' => 'text-blue-600', 'bg' => 'bg-blue-50'],
                ['label' => 'Taux de présence', 'value' => $stats['taux_presence'] . '%', 'color' => 'text-orange-600', 'bg' => 'bg-orange-50'],
            ];
        @endphp
        @foreach($miniStats as $stat)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 text-center">
            <div class="text-2xl font-bold {{ $stat['color'] }}">{{ $stat['value'] }}</div>
            <div class="text-xs text-gray-500 mt-1">{{ $stat['label'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- Action Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Gerer les invites --}}
        <a href="{{ route('organisateur.events.guests.index', $event) }}"
           class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:border-indigo-200 transition-all">
            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-4 group-hover:bg-indigo-200 transition-colors">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900 mb-1">Gérer les invités</h3>
            <p class="text-sm text-gray-500">Ajouter, modifier et gérer vos invités</p>
        </a>

        {{-- Gerer les tickets --}}
        <a href="{{ route('organisateur.events.tickets.index', $event) }}"
           class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:border-purple-200 transition-all">
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4 group-hover:bg-purple-200 transition-colors">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900 mb-1">Gérer les tickets</h3>
            <p class="text-sm text-gray-500">QR codes et validations des entrées</p>
        </a>

        {{-- Gerer le staff --}}
        <a href="{{ route('organisateur.events.staff.index', $event) }}"
           class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:border-blue-200 transition-all">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4 group-hover:bg-blue-200 transition-colors">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900 mb-1">Gérer le staff</h3>
            <p class="text-sm text-gray-500">Agents de contrôle et scanners</p>
        </a>

        {{-- Statistiques --}}
        <a href="{{ route('organisateur.events.stats', $event) }}"
           class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:border-green-200 transition-all">
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4 group-hover:bg-green-200 transition-colors">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900 mb-1">Statistiques</h3>
            <p class="text-sm text-gray-500">Analyses et rapports de présence</p>
        </a>
    </div>

    {{-- Description --}}
    @if($event->description)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-3">Description</h3>
        <p class="text-gray-600 leading-relaxed">{{ $event->description }}</p>
    </div>
    @endif

</div>
@endsection
