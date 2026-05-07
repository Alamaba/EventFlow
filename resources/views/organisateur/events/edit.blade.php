@extends('layouts.app')

@section('title', 'Modifier l\'événement')

@section('header', 'Modifier : ' . $event->title)

@section('header-actions')
    <div class="flex items-center space-x-3">
        <a href="{{ route('organisateur.events.show', $event) }}"
           class="inline-flex items-center space-x-2 text-gray-600 hover:text-gray-900 font-medium transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Retour</span>
        </a>
    </div>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <form action="{{ route('organisateur.events.update', $event) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PATCH')

        {{-- Basic Info --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-8 py-5 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-purple-50">
                <h2 class="text-lg font-semibold text-gray-900">Informations générales</h2>
            </div>
            <div class="px-8 py-6 space-y-5">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Titre de l'événement <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title', $event->title) }}" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-lg @error('title') border-red-400 @enderror">
                    @error('title')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
                    <textarea id="description" name="description" rows="4"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors resize-none">{{ old('description', $event->description) }}</textarea>
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Type d'événement <span class="text-red-500">*</span>
                    </label>
                    <select id="type" name="type" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                        @foreach(['mariage'=>'Mariage','ceremonie'=>'Cérémonie','conference'=>'Conférence','anniversaire'=>'Anniversaire','concert'=>'Concert','autre'=>'Autre'] as $val => $label)
                        <option value="{{ $val }}" {{ old('type', $event->type) == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Current Cover --}}
                @if($event->cover_image)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Image actuelle</label>
                    <img src="{{ Storage::url($event->cover_image) }}" alt="Cover" class="h-32 w-auto rounded-xl object-cover border border-gray-200">
                </div>
                @endif

                <div>
                    <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-1.5">{{ $event->cover_image ? 'Changer l\'image' : 'Image de couverture' }}</label>
                    <input type="file" id="cover_image" name="cover_image" accept="image/*"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-sm text-gray-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>
            </div>
        </div>

        {{-- Date & Location --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-8 py-5 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-pink-50">
                <h2 class="text-lg font-semibold text-gray-900">Date et lieu</h2>
            </div>
            <div class="px-8 py-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="date_start" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Date de début <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" id="date_start" name="date_start"
                            value="{{ old('date_start', \Carbon\Carbon::parse($event->date_start)->format('Y-m-d\TH:i')) }}" required
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    </div>

                    <div>
                        <label for="date_end" class="block text-sm font-medium text-gray-700 mb-1.5">Date de fin</label>
                        <input type="datetime-local" id="date_end" name="date_end"
                            value="{{ old('date_end', $event->date_end ? \Carbon\Carbon::parse($event->date_end)->format('Y-m-d\TH:i') : '') }}"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    </div>

                    <div>
                        <label for="venue" class="block text-sm font-medium text-gray-700 mb-1.5">Nom du lieu</label>
                        <input type="text" id="venue" name="venue" value="{{ old('venue', $event->venue) }}"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    </div>

                    <div>
                        <label for="capacity" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Capacité <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="capacity" name="capacity" value="{{ old('capacity', $event->capacity) }}" min="1" required
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1.5">Adresse</label>
                        <input type="text" id="address" name="address" value="{{ old('address', $event->address) }}"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    </div>

                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1.5">Ville</label>
                        <input type="text" id="city" name="city" value="{{ old('city', $event->city) }}"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    </div>
                </div>
            </div>
        </div>

        {{-- Pricing --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-8 py-5 border-b border-gray-100 bg-gradient-to-r from-green-50 to-emerald-50">
                <h2 class="text-lg font-semibold text-gray-900">Tarification</h2>
            </div>
            <div class="px-8 py-6 space-y-5">
                <div class="flex items-center space-x-3">
                    <input type="checkbox" id="is_paid" name="is_paid" value="1" {{ old('is_paid', $event->is_paid) ? 'checked' : '' }}
                        class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 cursor-pointer">
                    <label for="is_paid" class="text-sm font-medium text-gray-700 cursor-pointer">Événement payant</label>
                </div>

                <div id="pricing-fields" class="{{ old('is_paid', $event->is_paid) ? '' : 'hidden' }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 p-4 bg-gray-50 rounded-xl">
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-1.5">Prix du ticket</label>
                            <div class="relative">
                                <input type="number" id="price" name="price" value="{{ old('price', $event->price) }}" min="0" step="0.01"
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors pr-16">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                    <span class="text-gray-400 text-sm font-medium" id="currency-display">DJF</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="currency" class="block text-sm font-medium text-gray-700 mb-1.5">Devise</label>
                            <select id="currency" name="currency"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                <option value="DJF" selected>DJF - Franc djiboutien</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('organisateur.events.show', $event) }}"
               class="px-6 py-2.5 border border-gray-200 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition-colors">
                Annuler
            </a>
            <button type="submit"
                class="px-8 py-2.5 bg-indigo-600 text-white rounded-xl font-medium hover:bg-indigo-700 transition-colors shadow-sm inline-flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Enregistrer les modifications</span>
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const isPaidCheckbox = document.getElementById('is_paid');
    const pricingFields = document.getElementById('pricing-fields');
    const currencySelect = document.getElementById('currency');
    const currencyDisplay = document.getElementById('currency-display');

    isPaidCheckbox.addEventListener('change', function() {
        pricingFields.classList.toggle('hidden', !this.checked);
    });

    currencySelect.addEventListener('change', function() {
        currencyDisplay.textContent = this.value;
    });
</script>
@endpush
