@extends('layouts.app')

@section('title', 'Mes Événements')

@section('header', 'Mes Événements')

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
<div class="space-y-6">

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center space-x-2">
        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if($events->isEmpty())
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 py-20 text-center">
        <div class="w-20 h-20 bg-indigo-50 rounded-2xl flex items-center justify-center mx-auto mb-5">
            <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucun événement pour l'instant</h3>
        <p class="text-gray-500 mb-6">Commencez par créer votre premier événement</p>
        <a href="{{ route('organisateur.events.create') }}"
           class="inline-flex items-center space-x-2 bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-medium hover:bg-indigo-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Créer mon premier événement</span>
        </a>
    </div>
    @else

    {{-- Events Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach($events as $event)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-lg transition-all duration-300">
            {{-- Cover Image or Gradient Placeholder --}}
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

                {{-- Status Badge --}}
                <div class="absolute top-3 right-3">
                    @php
                        $statusColors = ['brouillon'=>'bg-gray-800/70 text-white','publie'=>'bg-green-500/90 text-white','annule'=>'bg-red-500/90 text-white','termine'=>'bg-blue-500/90 text-white'];
                        $color = $statusColors[$event->status] ?? 'bg-gray-800/70 text-white';
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium backdrop-blur-sm {{ $color }}">{{ ucfirst($event->status) }}</span>
                </div>

                {{-- Type Badge --}}
                <div class="absolute top-3 left-3">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-white/90 text-gray-700 capitalize">{{ $event->type }}</span>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-5">
                <h3 class="font-bold text-gray-900 text-lg leading-tight mb-1 truncate">{{ $event->title }}</h3>

                <div class="space-y-1.5 mt-3 text-sm text-gray-500">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
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
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>{{ $event->guests_count ?? 0 }} / {{ $event->capacity }} invités</span>
                    </div>
                </div>

                {{-- Progress bar --}}
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
                <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between space-x-2">
                    <a href="{{ route('organisateur.events.show', $event) }}"
                       class="flex-1 text-center text-sm font-medium text-indigo-600 hover:text-indigo-700 hover:bg-indigo-50 py-1.5 rounded-lg transition-colors">
                        Voir
                    </a>
                    <a href="{{ route('organisateur.events.edit', $event) }}"
                       class="flex-1 text-center text-sm font-medium text-gray-600 hover:text-gray-700 hover:bg-gray-50 py-1.5 rounded-lg transition-colors">
                        Modifier
                    </a>
                    @if($event->status === 'brouillon')
                    <form action="{{ route('organisateur.events.publish', $event) }}" method="POST" class="flex-1">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full text-sm font-medium text-green-600 hover:text-green-700 hover:bg-green-50 py-1.5 rounded-lg transition-colors">
                            Publier
                        </button>
                    </form>
                    @endif
                    <form action="{{ route('organisateur.events.destroy', $event) }}" method="POST" class="flex-1"
                          onsubmit="return confirm('Supprimer cet événement ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full text-sm font-medium text-red-500 hover:text-red-600 hover:bg-red-50 py-1.5 rounded-lg transition-colors">
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($events->hasPages())
    <div class="mt-6">
        {{ $events->links() }}
    </div>
    @endif

    @endif
</div>
@endsection
