<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement annulé - EventFlow</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center py-12 px-4">

    <div class="w-full max-w-lg text-center">

        {{-- Cancel Icon --}}
        <div class="mb-8">
            <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6 relative">
                <div class="w-20 h-20 bg-red-500 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <div class="absolute inset-0 rounded-full border-4 border-red-200"></div>
            </div>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden mb-6">
            <div class="bg-gradient-to-br from-red-500 to-rose-600 px-8 py-8 text-white">
                <h1 class="text-3xl font-extrabold mb-2">Paiement annulé</h1>
                <p class="text-red-100 text-lg">Votre paiement n'a pas été complété</p>
            </div>

            <div class="px-8 py-8">
                <p class="text-gray-600 text-base leading-relaxed mb-6">
                    Ne vous inquiétez pas — aucun montant n'a été débité de votre compte. Vous pouvez réessayer à tout moment.
                </p>

                <div class="space-y-3">
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl">
                        <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        <p class="text-sm text-gray-600">Aucun paiement n'a été effectué</p>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-blue-50 rounded-xl">
                        <svg class="w-5 h-5 text-blue-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                        <p class="text-sm text-gray-600">Les places pour cet événement sont toujours disponibles</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            @if(isset($event))
            <a href="{{ route('payment.checkout', $event) }}"
               class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 bg-indigo-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-indigo-700 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <span>Réessayer le paiement</span>
            </a>
            @else
            <a href="{{ url('/')  }}"
               class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 bg-indigo-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-indigo-700 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <span>Réessayer</span>
            </a>
            @endif

            <a href="{{ url('/')  }}"
               class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 border border-gray-200 text-gray-700 px-8 py-3 rounded-xl font-semibold hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Retour à l'accueil</span>
            </a>
        </div>

        <p class="mt-8 text-xs text-gray-400">
            Problème persistant ? <a href="mailto:support@eventflow.ma" class="text-indigo-600 hover:underline">Contactez notre support</a>
        </p>
    </div>

</body>
</html>
