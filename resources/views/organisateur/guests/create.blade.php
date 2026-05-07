@extends('layouts.app')

@section('title', 'Ajouter un invité')

@section('header', 'Ajouter un invité')

@section('header-actions')
    <a href="{{ route('organisateur.events.guests.index', $event) }}"
       class="inline-flex items-center space-x-2 text-gray-600 hover:text-gray-900 font-medium transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        <span>Retour aux invités</span>
    </a>
@endsection

@section('content')
<div class="max-w-xl mx-auto">

    {{-- Event Context --}}
    <div class="mb-4 bg-indigo-50 border border-indigo-100 rounded-xl px-5 py-3 flex items-center space-x-2">
        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <span class="text-indigo-800 font-medium text-sm">{{ $event->title }}</span>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-5 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-purple-50">
            <h2 class="text-lg font-semibold text-gray-900">Informations de l'invité</h2>
            <p class="text-sm text-gray-500 mt-0.5">Un QR code sera généré automatiquement</p>
        </div>

        <form action="{{ route('organisateur.events.guests.store', $event) }}" method="POST" class="px-8 py-6 space-y-5">
            @csrf

            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Nom complet <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('name') border-red-400 @enderror"
                    placeholder="ex: Fatima Zahra El Mansouri">
                @error('name')
                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Email
                    <span class="text-gray-400 font-normal">(pour recevoir l'invitation)</span>
                </label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('email') border-red-400 @enderror"
                    placeholder="exemple@email.com">
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

            {{-- Note --}}
            <div>
                <label for="note" class="block text-sm font-medium text-gray-700 mb-1.5">Note</label>
                <textarea id="note" name="note" rows="3"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors resize-none"
                    placeholder="Informations supplémentaires (VIP, allergies, besoins spéciaux...)">{{ old('note') }}</textarea>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                <a href="{{ route('organisateur.events.guests.index', $event) }}"
                   class="px-5 py-2.5 border border-gray-200 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition-colors">
                    Annuler
                </a>
                <button type="submit"
                    class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl font-medium hover:bg-indigo-700 transition-colors shadow-sm inline-flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Ajouter l'invité</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
