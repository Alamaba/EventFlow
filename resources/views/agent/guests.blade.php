@extends('layouts.app')

@section('title', 'Invités - ' . $event->title)

@section('header', 'Liste des invités')

@section('header-actions')
    <div class="flex items-center space-x-3">
        <span class="text-sm font-medium text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full">{{ $event->title }}</span>
        <a href="{{ route('agent.events.scan', $event) }}"
           class="inline-flex items-center space-x-2 bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition-colors shadow-sm text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
            </svg>
            <span>Scanner</span>
        </a>
        <a href="{{ route('agent.dashboard') }}"
           class="inline-flex items-center space-x-2 text-gray-600 hover:text-gray-900 font-medium transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Retour</span>
        </a>
    </div>
@endsection

@section('content')
<div class="space-y-4">

    {{-- Event Info --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-6 py-4">
        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
            <div class="flex items-center space-x-1.5">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>{{ \Carbon\Carbon::parse($event->date_start)->format('d/m/Y H:i') }}</span>
            </div>
            @if($event->venue)
            <div class="flex items-center space-x-1.5">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                </svg>
                <span>{{ $event->venue }}</span>
            </div>
            @endif
            <div class="flex items-center space-x-1.5">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span>{{ $guests->count() }} invités</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Nom</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Téléphone</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($guests as $guest)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-white text-xs font-semibold">{{ strtoupper(substr($guest->name, 0, 1)) }}</span>
                                </div>
                                <span class="font-medium text-gray-900 text-sm">{{ $guest->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $guest->email ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $guest->phone ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = [
                                    'invite'   => 'bg-yellow-100 text-yellow-700',
                                    'confirme' => 'bg-green-100 text-green-700',
                                    'annule'   => 'bg-red-100 text-red-700',
                                    'present'  => 'bg-purple-100 text-purple-700',
                                ];
                                $color = $statusColors[$guest->status] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                {{ ucfirst($guest->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-400 text-sm">Aucun invité trouvé</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($guests) && method_exists($guests, 'hasPages') && $guests->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $guests->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
