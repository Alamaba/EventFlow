<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement réussi - EventFlow</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center py-12 px-4">

    <div class="w-full max-w-lg text-center">

        {{-- Success Icon --}}
        <div class="mb-8">
            <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 relative">
                <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div class="absolute inset-0 rounded-full border-4 border-green-200"></div>
            </div>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden mb-6">
            <div class="bg-gradient-to-br from-green-500 to-emerald-600 px-8 py-8 text-white">
                <h1 class="text-3xl font-extrabold mb-2">Paiement réussi !</h1>
                <p class="text-green-100 text-lg">Votre inscription a été confirmée</p>
            </div>

            <div class="px-8 py-8">
                <div class="space-y-4 text-left">
                    <div class="flex items-start space-x-3 p-4 bg-green-50 rounded-xl">
                        <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Ticket envoyé par email</p>
                            <p class="text-gray-500 text-sm mt-0.5">Vérifiez votre boîte de réception (et les spams)</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3 p-4 bg-blue-50 rounded-xl">
                        <svg class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">QR Code unique généré</p>
                            <p class="text-gray-500 text-sm mt-0.5">Présentez votre QR code à l'entrée de l'événement</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3 p-4 bg-indigo-50 rounded-xl">
                        <svg class="w-5 h-5 text-indigo-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"/></svg>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">Paiement enregistré</p>
                            <p class="text-gray-500 text-sm mt-0.5">Une confirmation de paiement a été envoyée</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ url('/')  }}"
               class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 bg-indigo-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-indigo-700 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Retour à l'accueil</span>
            </a>
        </div>

        <p class="mt-8 text-xs text-gray-400">
            Vous avez une question ? <a href="mailto:support@eventflow.ma" class="text-indigo-600 hover:underline">Contactez-nous</a>
        </p>
    </div>

</body>
</html>
