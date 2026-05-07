@extends('layouts.app')

@section('title', 'Invités - ' . $event->title)

@section('header', 'Invités')

@section('header-actions')
    <div class="flex items-center space-x-3">
        {{-- Send All --}}
        <form action="{{ route('organisateur.events.send-all-invitations', $event) }}" method="POST" class="inline"
              onsubmit="return confirm('Envoyer les invitations à tous les invités sans invitation envoyée ?')">
            @csrf
            <button type="submit"
                class="inline-flex items-center space-x-2 border border-indigo-200 text-indigo-700 bg-indigo-50 px-4 py-2 rounded-lg font-medium hover:bg-indigo-100 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <span>Envoyer tout</span>
            </button>
        </form>
        <a href="{{ route('organisateur.events.guests.create', $event) }}"
           class="inline-flex items-center space-x-2 bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Ajouter un invité</span>
        </a>
    </div>
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

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center space-x-2">
        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Nom</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Téléphone</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Invitation</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">QR Code</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
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
                                    'invite'    => 'bg-yellow-100 text-yellow-700',
                                    'confirme'  => 'bg-green-100 text-green-700',
                                    'annule'    => 'bg-red-100 text-red-700',
                                    'present'   => 'bg-purple-100 text-purple-700',
                                ];
                                $color = $statusColors[$guest->status] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">{{ ucfirst($guest->status) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($guest->invitation_sent_at)
                                <span class="inline-flex items-center text-xs text-green-600">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    {{ \Carbon\Carbon::parse($guest->invitation_sent_at)->format('d/m/Y') }}
                                </span>
                            @else
                                <span class="text-xs text-gray-400">Non envoyée</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($guest->ticket && $guest->ticket->qr_code_url)
                                <img src="{{ $guest->ticket->qr_code_url }}" alt="QR" class="w-10 h-10 rounded border border-gray-200">
                            @else
                                <span class="text-xs text-gray-400">Non généré</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end space-x-1">
                                {{-- Modifier --}}
                                <a href="{{ route('organisateur.guests.edit', $guest) }}"
                                   class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Modifier">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                {{-- Envoyer invitation --}}
                                @if($guest->email)
                                <form action="{{ route('organisateur.guests.send-invitation', $guest) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="p-1.5 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Envoyer invitation">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                                {{-- Supprimer --}}
                                <form action="{{ route('organisateur.guests.destroy', $guest) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Supprimer cet invité ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Supprimer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <p class="text-gray-400 font-medium">Aucun invité pour cet événement</p>
                            <a href="{{ route('organisateur.events.guests.create', $event) }}" class="mt-2 inline-block text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                                Ajouter le premier invité
                            </a>
                        </td>
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
