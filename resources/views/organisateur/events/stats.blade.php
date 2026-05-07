@extends('layouts.app')

@section('title', 'Statistiques - ' . $event->title)

@section('header', 'Statistiques')

@section('header-actions')
    <a href="{{ route('organisateur.events.show', $event) }}"
       class="inline-flex items-center space-x-2 text-gray-600 hover:text-gray-900 font-medium transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        <span>Retour à l'événement</span>
    </a>
@endsection

@section('content')
<div class="space-y-6">

    {{-- Event Title --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-6 py-4">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-gray-900">{{ $event->title }}</h2>
                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($event->date_start)->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>

    {{-- Presence Rate --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Taux de présence</h3>
        @php
            $total = $event->guests()->count();
            $presents = $event->guests()->where('status', 'present')->count();
            $confirmes = $event->guests()->where('status', 'confirme')->count();
            $invites = $event->guests()->where('status', 'invite')->count();
            $annules = $event->guests()->where('status', 'annule')->count();
            $tauxPresence = $total > 0 ? round(($presents / $total) * 100) : 0;
            $tauxConfirme = $total > 0 ? round(($confirmes / $total) * 100) : 0;
        @endphp

        <div class="flex items-center justify-between mb-2">
            <span class="text-sm text-gray-600">Présents / Total invités</span>
            <span class="text-lg font-bold text-indigo-600">{{ $tauxPresence }}%</span>
        </div>
        <div class="w-full h-4 bg-gray-100 rounded-full overflow-hidden mb-6">
            <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full transition-all duration-1000"
                 style="width: {{ $tauxPresence }}%"></div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center p-4 bg-yellow-50 rounded-xl border border-yellow-100">
                <p class="text-2xl font-bold text-yellow-600">{{ $invites }}</p>
                <p class="text-xs text-yellow-600 font-medium mt-1">Invités</p>
                <div class="mt-2 h-1.5 bg-yellow-200 rounded-full overflow-hidden">
                    <div class="h-full bg-yellow-400 rounded-full" style="width: {{ $total > 0 ? round(($invites/$total)*100) : 0 }}%"></div>
                </div>
            </div>
            <div class="text-center p-4 bg-green-50 rounded-xl border border-green-100">
                <p class="text-2xl font-bold text-green-600">{{ $confirmes }}</p>
                <p class="text-xs text-green-600 font-medium mt-1">Confirmés</p>
                <div class="mt-2 h-1.5 bg-green-200 rounded-full overflow-hidden">
                    <div class="h-full bg-green-500 rounded-full" style="width: {{ $tauxConfirme }}%"></div>
                </div>
            </div>
            <div class="text-center p-4 bg-red-50 rounded-xl border border-red-100">
                <p class="text-2xl font-bold text-red-600">{{ $annules }}</p>
                <p class="text-xs text-red-600 font-medium mt-1">Annulés</p>
                <div class="mt-2 h-1.5 bg-red-200 rounded-full overflow-hidden">
                    <div class="h-full bg-red-500 rounded-full" style="width: {{ $total > 0 ? round(($annules/$total)*100) : 0 }}%"></div>
                </div>
            </div>
            <div class="text-center p-4 bg-purple-50 rounded-xl border border-purple-100">
                <p class="text-2xl font-bold text-purple-600">{{ $presents }}</p>
                <p class="text-xs text-purple-600 font-medium mt-1">Présents</p>
                <div class="mt-2 h-1.5 bg-purple-200 rounded-full overflow-hidden">
                    <div class="h-full bg-purple-500 rounded-full" style="width: {{ $tauxPresence }}%"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Scan History --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">Historique des scans</h3>
            <span class="text-sm text-gray-400">{{ $event->scanLogs->count() }} scans total</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Invité</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Agent</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Date / Heure</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Résultat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($event->scanLogs as $log)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $log->guest->name ?? 'Inconnu' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $log->agent->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($log->scanned_at)->format('d/m/Y H:i:s') }}</td>
                        <td class="px-6 py-4">
                            @if($log->success ?? true)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    Succès
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                    Échec
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-400 text-sm">Aucun scan enregistré</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
