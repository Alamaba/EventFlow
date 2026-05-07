@extends('layouts.app')

@section('title', 'Tickets - ' . $event->title)

@section('header', 'Tickets')

@section('header-actions')
    <form action="{{ route('organisateur.events.tickets.generate-all', $event) }}" method="POST" class="inline">
        @csrf
        <button type="submit"
            class="inline-flex items-center space-x-2 bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
            </svg>
            <span>Générer tous les QR</span>
        </button>
    </form>
@endsection

@section('content')
<div class="space-y-4">

    {{-- Event Badge --}}
    <div class="bg-indigo-50 border border-indigo-100 rounded-xl px-5 py-3 flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span class="text-indigo-800 font-medium text-sm">{{ $event->title }}</span>
        </div>
        <a href="{{ route('organisateur.events.show', $event) }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">Voir l'événement</a>
    </div>


    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Invité</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">UUID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">QR Code</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Validé le</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($tickets as $ticket)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-white text-xs font-semibold">{{ strtoupper(substr($ticket->guest->name ?? '?', 0, 1)) }}</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 text-sm">{{ $ticket->guest->name ?? 'Inconnu' }}</p>
                                    <p class="text-xs text-gray-400">{{ $ticket->guest->email ?? '' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <code class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded font-mono">
                                {{ substr($ticket->uuid, 0, 8) }}...
                            </code>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = ['actif'=>'bg-green-100 text-green-700','valide'=>'bg-blue-100 text-blue-700','annule'=>'bg-red-100 text-red-700'];
                                $color = $statusColors[$ticket->status] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">{{ ucfirst($ticket->status) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($ticket->qr_code_url)
                                <img src="{{ $ticket->qr_code_url }}" alt="QR Code" class="w-14 h-14 rounded-lg border border-gray-200 object-cover">
                            @else
                                <div class="w-14 h-14 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $ticket->validated_at ? \Carbon\Carbon::parse($ticket->validated_at)->format('d/m/Y H:i') : '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end">
                                <a href="{{ route('ticket.download', $ticket->uuid) }}" target="_blank"
                                   class="inline-flex items-center space-x-1.5 px-3 py-1.5 bg-indigo-50 text-indigo-700 text-xs font-medium rounded-lg hover:bg-indigo-100 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    <span>PDF</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                            </svg>
                            <p class="text-gray-400 font-medium">Aucun ticket généré</p>
                            <p class="text-sm text-gray-400 mt-1">Utilisez le bouton "Générer tous les QR" pour créer les tickets</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($tickets) && method_exists($tickets, 'hasPages') && $tickets->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $tickets->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
