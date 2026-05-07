<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement - {{ $event->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">

    {{-- Header --}}
    <div class="bg-white border-b border-gray-200 sticky top-0 z-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="font-bold text-gray-900">EventFlow</span>
            </div>
            <div class="flex items-center space-x-2 text-sm text-gray-500">
                <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                </svg>
                <span>Paiement sécurisé</span>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

            {{-- Form --}}
            <div class="lg:col-span-3">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100">
                        <h2 class="text-xl font-bold text-gray-900">Vos informations</h2>
                        <p class="text-sm text-gray-500 mt-1">Ces informations seront utilisées pour votre ticket</p>
                    </div>

                    <form action="{{ route('payment.process') }}" method="POST" class="px-8 py-6 space-y-5">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">

                        {{-- Name --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Nom complet <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('name') border-red-400 @enderror"
                                placeholder="Prénom Nom">
                            @error('name')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('email') border-red-400 @enderror"
                                placeholder="votre@email.com">
                            <p class="mt-1 text-xs text-gray-400">Votre ticket sera envoyé à cette adresse</p>
                            @error('email')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1.5">Téléphone</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                placeholder="+212 6xx xxx xxx">
                        </div>

                        {{-- Terms --}}
                        <div class="flex items-start space-x-3 pt-2">
                            <input type="checkbox" id="terms" name="terms" required
                                class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 mt-0.5 cursor-pointer">
                            <label for="terms" class="text-sm text-gray-600 cursor-pointer">
                                J'accepte les <a href="#" class="text-indigo-600 hover:underline">conditions d'utilisation</a> et la <a href="#" class="text-indigo-600 hover:underline">politique de confidentialité</a>
                            </label>
                        </div>

                        {{-- Submit --}}
                        <div class="pt-2">
                            <button type="submit"
                                class="w-full py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-bold text-lg hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                <span>Payer {{ number_format($event->price, 0) }} {{ $event->currency ?? 'DJF' }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-24">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900">Récapitulatif</h3>
                    </div>

                    {{-- Event Card --}}
                    <div class="p-6 space-y-4">
                        <div class="rounded-xl overflow-hidden border border-gray-100">
                            @if($event->cover_image)
                                <img src="{{ Storage::url($event->cover_image) }}" alt="{{ $event->title }}" class="w-full h-28 object-cover">
                            @else
                                <div class="w-full h-28 bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
                                    <svg class="w-10 h-10 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="p-4">
                                <h4 class="font-bold text-gray-900 text-sm">{{ $event->title }}</h4>
                                <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($event->date_start)->format('d/m/Y H:i') }}</p>
                                @if($event->venue)
                                <p class="text-xs text-gray-500">{{ $event->venue }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Prix du ticket</span>
                                <span class="font-medium">{{ number_format($event->price, 0) }} {{ $event->currency ?? 'DJF' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Frais de service</span>
                                <span class="font-medium text-green-600">Gratuit</span>
                            </div>
                            <div class="border-t border-gray-100 pt-2 flex justify-between font-bold text-lg">
                                <span>Total</span>
                                <span class="text-indigo-600">{{ number_format($event->price, 0) }} {{ $event->currency ?? 'DJF' }}</span>
                            </div>
                        </div>

                        <div class="bg-indigo-50 rounded-xl p-3 flex items-start space-x-2">
                            <svg class="w-4 h-4 text-indigo-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                            <p class="text-xs text-indigo-700">Vous recevrez votre ticket avec QR code par email immédiatement après le paiement.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>
