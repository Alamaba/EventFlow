<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon ticket - {{ $ticket->event->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-indigo-900 via-purple-900 to-indigo-800 min-h-screen flex items-center justify-center py-12 px-4">

    <div class="w-full max-w-md">
        {{-- Header logo --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center space-x-2">
                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-white font-bold text-xl">EventFlow</span>
            </div>
        </div>

        {{-- Ticket Card --}}
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">

            {{-- Top section - Event Info --}}
            <div class="bg-gradient-to-br from-indigo-600 to-purple-700 px-8 py-8 text-white">
                @php
                    $statusColors = ['actif'=>'bg-green-400/20 text-green-100 border-green-400/30','valide'=>'bg-blue-400/20 text-blue-100 border-blue-400/30','annule'=>'bg-red-400/20 text-red-100 border-red-400/30'];
                    $statusColor = $statusColors[$ticket->status] ?? 'bg-gray-400/20 text-gray-100 border-gray-400/30';
                @endphp
                <div class="flex items-center justify-between mb-4">
                    <span class="text-indigo-200 text-xs font-semibold uppercase tracking-wider">Ticket d'invitation</span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border {{ $statusColor }}">
                        {{ ucfirst($ticket->status) }}
                    </span>
                </div>
                <h1 class="text-2xl font-extrabold leading-tight mb-3">{{ $ticket->event->title }}</h1>
                <div class="space-y-2">
                    <div class="flex items-center space-x-2 text-indigo-200 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($ticket->event->date_start)->format('l d F Y, H:i') }}</span>
                    </div>
                    @if($ticket->event->venue)
                    <div class="flex items-center space-x-2 text-indigo-200 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        </svg>
                        <span>{{ $ticket->event->venue }}{{ $ticket->event->city ? ', ' . $ticket->event->city : '' }}</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Divider with dots --}}
            <div class="relative flex items-center bg-gray-50">
                <div class="w-6 h-6 bg-gradient-to-br from-indigo-900 to-purple-900 rounded-full absolute -left-3"></div>
                <div class="flex-1 border-t-2 border-dashed border-gray-200 mx-4"></div>
                <div class="w-6 h-6 bg-gradient-to-br from-indigo-900 to-purple-900 rounded-full absolute -right-3"></div>
            </div>

            {{-- Guest Info & QR --}}
            <div class="px-8 py-6 bg-white">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Invité(e)</p>
                        <p class="text-xl font-bold text-gray-900">{{ $ticket->guest->name }}</p>
                        @if($ticket->guest->email)
                        <p class="text-sm text-gray-500 mt-0.5">{{ $ticket->guest->email }}</p>
                        @endif
                        <div class="mt-3">
                            <p class="text-xs text-gray-400">UUID du ticket</p>
                            <code class="text-xs font-mono text-gray-600 bg-gray-100 px-2 py-1 rounded mt-0.5 block break-all">{{ $ticket->uuid }}</code>
                        </div>
                    </div>

                    @if($ticket->qr_code_url)
                    <div class="ml-4 flex-shrink-0">
                        <div class="border-4 border-indigo-100 rounded-xl p-1">
                            <img src="{{ $ticket->qr_code_url }}" alt="QR Code" class="w-24 h-24">
                        </div>
                        <p class="text-xs text-gray-400 text-center mt-1">Scannez-moi</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- RSVP Section --}}
            @if($ticket->status === 'annule')
            <div class="px-8 pb-6 bg-white">
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 flex items-center space-x-3">
                    <svg class="w-6 h-6 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                    <p class="text-red-700 font-medium text-sm">Votre participation a été annulée.</p>
                </div>
            </div>
            @elseif($ticket->status === 'valide')
            <div class="px-8 pb-6 bg-white">
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-center space-x-3">
                    <svg class="w-6 h-6 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <p class="text-blue-700 font-medium text-sm">Votre ticket a été validé à l'entrée.</p>
                </div>
            </div>
            @elseif($ticket->guest->status === 'confirme')
            <div class="px-8 pb-6 bg-white">
                <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center space-x-3">
                    <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <p class="text-green-700 font-medium text-sm">Votre présence est confirmée ! À bientôt.</p>
                </div>
            </div>
            @else
            <div class="px-8 pb-8 bg-white">
                <div class="border-t border-gray-100 pt-6">
                    <p class="text-sm font-semibold text-gray-700 mb-4 text-center">Confirmez votre présence</p>
                    <div class="grid grid-cols-2 gap-3">
                        <form action="{{ route('ticket.rsvp', $ticket->uuid) }}" method="POST">
                            @csrf
                            <input type="hidden" name="action" value="confirm">
                            <button type="submit"
                                class="w-full py-3 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700 transition-colors flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Confirmer</span>
                            </button>
                        </form>
                        <form action="{{ route('ticket.rsvp', $ticket->uuid) }}" method="POST">
                            @csrf
                            <input type="hidden" name="action" value="decline">
                            <button type="submit"
                                class="w-full py-3 border-2 border-red-200 text-red-600 rounded-xl font-semibold hover:bg-red-50 transition-colors flex items-center justify-center space-x-2"
                                onclick="return confirm('Êtes-vous sûr de vouloir décliner cette invitation ?')">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                <span>Décliner</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            {{-- Download PDF --}}
            <div class="px-8 pb-8 bg-white">
                <a href="{{ route('ticket.download', $ticket->uuid) }}" target="_blank"
                   class="w-full flex items-center justify-center space-x-2 py-3 border-2 border-indigo-200 text-indigo-700 rounded-xl font-semibold hover:bg-indigo-50 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    <span>Télécharger mon ticket PDF</span>
                </a>
            </div>
        </div>

        <p class="text-center text-indigo-300 text-xs mt-6">Powered by EventFlow &mdash; {{ date('Y') }}</p>
    </div>

</body>
</html>
