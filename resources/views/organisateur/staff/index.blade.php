@extends('layouts.app')

@section('title', 'Staff - ' . $event->title)

@section('header', 'Gestion du Staff')

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

    {{-- Event Badge --}}
    <div class="bg-blue-50 border border-blue-100 rounded-xl px-5 py-3 flex items-center space-x-2">
        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
        </svg>
        <span class="text-blue-800 font-medium text-sm">Staff de l'événement : {{ $event->title }}</span>
    </div>


    {{-- Current Staff --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Agents assignés</h3>
        </div>
        @if($staff->isEmpty())
        <div class="px-6 py-12 text-center">
            <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <p class="text-gray-400 text-sm">Aucun agent assigné à cet événement</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Agent</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Assigné le</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($staff as $agent)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-white text-xs font-semibold">{{ strtoupper(substr($agent->name, 0, 1)) }}</span>
                                </div>
                                <span class="font-medium text-gray-900 text-sm">{{ $agent->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $agent->email }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($agent->pivot->assigned_at ?? $agent->created_at)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end">
                                <form action="{{ route('organisateur.events.staff.destroy', [$event, $agent]) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Retirer cet agent de l\'événement ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center space-x-1.5 px-3 py-1.5 bg-red-50 text-red-700 text-xs font-medium rounded-lg hover:bg-red-100 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        <span>Retirer</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    {{-- Add Agent Form --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-blue-50">
            <h3 class="text-lg font-semibold text-gray-900">Ajouter un agent</h3>
        </div>

        <form action="{{ route('organisateur.events.staff.store', $event) }}" method="POST" class="px-8 py-6">
            @csrf

            {{-- Agent Type Radio --}}
            <div class="mb-6">
                <p class="text-sm font-medium text-gray-700 mb-3">Type d'ajout</p>
                <div class="flex space-x-4">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="radio" name="action" value="existing" id="type_existing" checked
                               class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                        <span class="text-sm text-gray-700 font-medium">Agent existant</span>
                    </label>
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="radio" name="action" value="new" id="type_new"
                               class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                        <span class="text-sm text-gray-700 font-medium">Créer un nouvel agent</span>
                    </label>
                </div>
            </div>

            {{-- Existing Agent Select --}}
            <div id="existing-agent-section" class="space-y-4">
                <div>
                    <label for="agent_id" class="block text-sm font-medium text-gray-700 mb-1.5">Sélectionner un agent</label>
                    <select id="agent_id" name="user_id"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                        <option value="">Choisir un agent...</option>
                        @foreach($availableAgents as $agent)
                        <option value="{{ $agent->id }}">{{ $agent->name }} ({{ $agent->email }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- New Agent Fields --}}
            <div id="new-agent-section" class="space-y-4 hidden">
                <div>
                    <label for="agent_name" class="block text-sm font-medium text-gray-700 mb-1.5">Nom de l'agent <span class="text-red-500">*</span></label>
                    <input type="text" id="agent_name" name="name" value="{{ old('name') }}"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                        placeholder="Prénom Nom">
                </div>
                <div>
                    <label for="agent_email" class="block text-sm font-medium text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                    <input type="email" id="agent_email" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                        placeholder="agent@email.com">
                </div>
                <div>
                    <label for="agent_password" class="block text-sm font-medium text-gray-700 mb-1.5">Mot de passe <span class="text-red-500">*</span></label>
                    <input type="password" id="agent_password" name="password"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                        placeholder="Minimum 8 caractères">
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 mt-6 pt-4 border-t border-gray-100">
                <button type="submit"
                    class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl font-medium hover:bg-indigo-700 transition-colors shadow-sm inline-flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Ajouter l'agent</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

@push('scripts')
<script>
    const radioExisting = document.getElementById('type_existing');
    const radioNew = document.getElementById('type_new');
    const existingSection = document.getElementById('existing-agent-section');
    const newSection = document.getElementById('new-agent-section');

    radioExisting.addEventListener('change', function() {
        existingSection.classList.remove('hidden');
        newSection.classList.add('hidden');
    });

    radioNew.addEventListener('change', function() {
        existingSection.classList.add('hidden');
        newSection.classList.remove('hidden');
    });
</script>
@endpush
