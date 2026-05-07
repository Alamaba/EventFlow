@extends('layouts.app')

@section('title', 'Scanner QR - ' . $event->title)

@section('header', 'Scanner QR Code')

@section('header-actions')
    <div class="flex items-center space-x-3">
        <span class="text-sm font-medium text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full">{{ $event->title }}</span>
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
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Scanner Area --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-purple-50 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900">Scanner la caméra</h2>
            <button id="start-scan-btn"
                class="inline-flex items-center space-x-2 bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition-colors text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.069A1 1 0 0121 8.82V15.18a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
                <span>Activer la caméra</span>
            </button>
        </div>

        <div class="p-6">
            {{-- Camera Container --}}
            <div class="relative">
                <div id="camera-container" class="hidden">
                    <div class="relative bg-black rounded-2xl overflow-hidden" style="max-height: 380px;">
                        <video id="qr-video" class="w-full" playsinline autoplay muted></video>
                        {{-- Scan overlay --}}
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <div class="relative w-56 h-56">
                                <div class="absolute top-0 left-0 w-8 h-8 border-t-4 border-l-4 border-white rounded-tl-lg"></div>
                                <div class="absolute top-0 right-0 w-8 h-8 border-t-4 border-r-4 border-white rounded-tr-lg"></div>
                                <div class="absolute bottom-0 left-0 w-8 h-8 border-b-4 border-l-4 border-white rounded-bl-lg"></div>
                                <div class="absolute bottom-0 right-0 w-8 h-8 border-b-4 border-r-4 border-white rounded-br-lg"></div>
                                <div id="scan-line" class="absolute top-0 left-0 right-0 h-0.5 bg-indigo-400 opacity-75" style="animation: scan-move 2s linear infinite;"></div>
                            </div>
                        </div>
                    </div>
                    <canvas id="qr-canvas" class="hidden"></canvas>
                    <div class="mt-3 flex items-center justify-between">
                        <p class="text-sm text-gray-500 flex items-center space-x-1.5">
                            <span class="inline-block w-2 h-2 bg-green-400 rounded-full" id="camera-status-dot"></span>
                            <span id="camera-status-text">Caméra active - pointez vers un QR code</span>
                        </p>
                        <button id="stop-scan-btn"
                            class="text-sm text-red-600 hover:text-red-700 font-medium">
                            Arrêter
                        </button>
                    </div>
                </div>

                <div id="camera-placeholder" class="flex flex-col items-center justify-center h-56 border-2 border-dashed border-gray-200 rounded-2xl">
                    <svg class="w-16 h-16 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.069A1 1 0 0121 8.82V15.18a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-gray-400 text-sm font-medium">Cliquez sur "Activer la caméra" pour scanner</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Result Display --}}
    <div id="scan-result" class="hidden">
        <div id="result-success" class="hidden bg-green-50 border border-green-200 rounded-2xl p-6">
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-green-800">Accès autorisé !</h3>
                    <div id="guest-info" class="mt-2 space-y-1">
                        <p class="text-green-700 font-medium text-lg" id="guest-name"></p>
                        <p class="text-green-600 text-sm" id="guest-email"></p>
                        <p class="text-green-600 text-sm" id="guest-status"></p>
                    </div>
                </div>
            </div>
        </div>

        <div id="result-error" class="hidden bg-red-50 border border-red-200 rounded-2xl p-6">
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-red-800">Accès refusé</h3>
                    <p class="text-red-600 mt-1" id="error-message"></p>
                </div>
            </div>
        </div>

        <div class="mt-3 flex justify-center">
            <button id="scan-again-btn"
                class="px-5 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors text-sm">
                Scanner à nouveau
            </button>
        </div>
    </div>

    {{-- Manual Input --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Saisie manuelle</h3>
            <p class="text-sm text-gray-500 mt-0.5">Si le scanner ne fonctionne pas, entrez l'UUID manuellement</p>
        </div>
        <div class="px-6 py-5">
            <form id="manual-form" class="flex space-x-3">
                @csrf
                <input type="text" id="manual-uuid" name="uuid"
                    class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors font-mono text-sm"
                    placeholder="Entrez l'UUID du ticket...">
                <button type="submit"
                    class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-medium hover:bg-indigo-700 transition-colors inline-flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Valider</span>
                </button>
            </form>
            <div id="manual-result" class="mt-4 hidden"></div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>
<style>
    @keyframes scan-move {
        0% { top: 0; }
        100% { top: calc(100% - 2px); }
    }
</style>
<script>
    const SCAN_URL = "{{ route('agent.scan.process') }}";
    const CSRF_TOKEN = "{{ csrf_token() }}";
    const EVENT_ID = {{ $event->id }};

    let video = document.getElementById('qr-video');
    let canvas = document.getElementById('qr-canvas');
    let ctx = canvas.getContext('2d');
    let scanning = false;
    let stream = null;
    let scanTimer = null;
    let lastScan = null;

    document.getElementById('start-scan-btn').addEventListener('click', startScanner);
    document.getElementById('stop-scan-btn').addEventListener('click', stopScanner);
    document.getElementById('scan-again-btn').addEventListener('click', function() {
        document.getElementById('scan-result').classList.add('hidden');
        document.getElementById('result-success').classList.add('hidden');
        document.getElementById('result-error').classList.add('hidden');
        if (stream) resumeScanning();
    });

    function startScanner() {
        navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
            .then(function(s) {
                stream = s;
                video.srcObject = stream;
                video.play();
                document.getElementById('camera-placeholder').classList.add('hidden');
                document.getElementById('camera-container').classList.remove('hidden');
                scanning = true;
                lastScan = null;
                scanFrame();
            })
            .catch(function(err) {
                alert('Impossible d\'accéder à la caméra: ' + err.message);
            });
    }

    function stopScanner() {
        scanning = false;
        if (stream) {
            stream.getTracks().forEach(t => t.stop());
            stream = null;
        }
        if (scanTimer) clearTimeout(scanTimer);
        document.getElementById('camera-container').classList.add('hidden');
        document.getElementById('camera-placeholder').classList.remove('hidden');
    }

    function resumeScanning() {
        lastScan = null;
        scanning = true;
        if (stream) scanFrame();
        else startScanner();
    }

    function scanFrame() {
        if (!scanning) return;
        if (video.readyState === video.HAVE_ENOUGH_DATA) {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            const code = jsQR(imageData.data, imageData.width, imageData.height);
            if (code && code.data && code.data !== lastScan) {
                lastScan = code.data;
                scanning = false;
                processQR(code.data);
                return;
            }
        }
        scanTimer = setTimeout(scanFrame, 100);
    }

    function processQR(uuid) {
        fetch(SCAN_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ uuid: uuid, event_id: EVENT_ID })
        })
        .then(res => res.json())
        .then(data => showResult(data))
        .catch(err => showResult({ success: false, message: 'Erreur de connexion' }));
    }

    function showResult(data) {
        const resultEl = document.getElementById('scan-result');
        const successEl = document.getElementById('result-success');
        const errorEl = document.getElementById('result-error');

        resultEl.classList.remove('hidden');
        if (data.success) {
            successEl.classList.remove('hidden');
            errorEl.classList.add('hidden');
            document.getElementById('guest-name').textContent = data.guest?.name ?? '';
            document.getElementById('guest-email').textContent = data.guest?.email ?? '';
            document.getElementById('guest-status').textContent = data.message ?? 'Ticket validé avec succès';
        } else {
            errorEl.classList.remove('hidden');
            successEl.classList.add('hidden');
            document.getElementById('error-message').textContent = data.message ?? 'Ticket invalide ou déjà utilisé';
        }

        setTimeout(() => {
            resultEl.classList.add('hidden');
            successEl.classList.add('hidden');
            errorEl.classList.add('hidden');
            resumeScanning();
        }, 4000);
    }

    // Manual form
    document.getElementById('manual-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const uuid = document.getElementById('manual-uuid').value.trim();
        if (!uuid) return;
        processManual(uuid);
    });

    function processManual(uuid) {
        fetch(SCAN_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ uuid: uuid, event_id: EVENT_ID })
        })
        .then(res => res.json())
        .then(data => {
            const el = document.getElementById('manual-result');
            el.classList.remove('hidden');
            if (data.success) {
                el.innerHTML = `<div class="bg-green-50 border border-green-200 rounded-xl px-4 py-3 text-green-700 flex items-center space-x-2">
                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <div><strong>${data.guest?.name ?? ''}</strong> — ${data.message ?? 'Validé'}</div>
                </div>`;
            } else {
                el.innerHTML = `<div class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 text-red-700 flex items-center space-x-2">
                    <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9a1 1 0 012 0v4a1 1 0 11-2 0V9zm1-5a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/></svg>
                    <span>${data.message ?? 'Ticket invalide'}</span>
                </div>`;
            }
            document.getElementById('manual-uuid').value = '';
            setTimeout(() => el.classList.add('hidden'), 5000);
        });
    }
</script>
@endpush
