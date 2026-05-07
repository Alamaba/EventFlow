<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ticket — {{ $ticket->event->title }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            background-color: #312e81;
        }

        .page {
            padding: 30px 24px;
        }

        /* ── Card ── */
        .card {
            width: 480px;
            margin: 0 auto;
            border-radius: 24px;
            overflow: hidden;
            background: #ffffff;
        }

        /* ── Header ── */
        .header {
            background-color: #5345e5;
            background-image: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            padding: 24px 28px 22px;
            color: #ffffff;
        }
        .header-top {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }
        .header-top td { vertical-align: middle; }
        .ticket-label {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #c7d2fe;
        }
        .status-pill {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }
        .pill-actif    { background-color: rgba(74,222,128,0.25);  color: #86efac; border: 1px solid rgba(74,222,128,0.3); }
        .pill-valide   { background-color: rgba(96,165,250,0.25);  color: #bfdbfe; border: 1px solid rgba(96,165,250,0.3); }
        .pill-annule   { background-color: rgba(248,113,113,0.25); color: #fecaca; border: 1px solid rgba(248,113,113,0.3); }
        .pill-confirme { background-color: rgba(74,222,128,0.25);  color: #86efac; border: 1px solid rgba(74,222,128,0.3); }

        .event-title {
            font-size: 21px;
            font-weight: 900;
            color: #ffffff;
            margin-bottom: 14px;
            line-height: 1.25;
        }

        .meta-row {
            margin-bottom: 7px;
        }
        .meta-svg {
            display: inline-block;
            vertical-align: middle;
            margin-right: 6px;
        }
        .meta-text {
            font-size: 10px;
            color: #c7d2fe;
            vertical-align: middle;
        }

        /* ── Tear line ── */
        .tear-wrap {
            background-color: #f9fafb;
            position: relative;
            height: 22px;
            overflow: hidden;
        }
        .tear-line {
            border-top: 2px dashed #ddd6fe;
            margin: 10px 20px 0;
        }
        .tear-circle-left {
            position: absolute;
            left: -11px;
            top: 0;
            width: 22px;
            height: 22px;
            background-color: #312e81;
            border-radius: 50%;
        }
        .tear-circle-right {
            position: absolute;
            right: -11px;
            top: 0;
            width: 22px;
            height: 22px;
            background-color: #312e81;
            border-radius: 50%;
        }

        /* ── Body ── */
        .body {
            background-color: #ffffff;
            padding: 22px 28px 18px;
        }
        .body-table { width: 100%; border-collapse: collapse; }
        .body-table td { vertical-align: top; }
        .guest-col { padding-right: 18px; }
        .qr-col    { width: 114px; text-align: center; }

        .section-lbl {
            font-size: 8px;
            font-weight: 700;
            letter-spacing: 1.8px;
            text-transform: uppercase;
            color: #9ca3af;
            margin-bottom: 4px;
        }
        .guest-name {
            font-size: 19px;
            font-weight: 900;
            color: #111827;
            margin-bottom: 2px;
        }
        .guest-email {
            font-size: 10px;
            color: #6b7280;
            margin-bottom: 13px;
        }

        .uuid-box {
            background-color: #f3f4f6;
            border-radius: 8px;
            padding: 8px 10px;
        }
        .uuid-lbl {
            font-size: 8px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #9ca3af;
            margin-bottom: 3px;
        }
        .uuid-val {
            font-family: 'Courier New', monospace;
            font-size: 8px;
            color: #374151;
            word-break: break-all;
        }

        .qr-frame {
            border: 4px solid #e0e7ff;
            border-radius: 12px;
            padding: 4px;
            display: inline-block;
            background-color: #fff;
        }
        .qr-frame img { display: block; width: 100px; height: 100px; }
        .qr-hint {
            font-size: 8px;
            color: #9ca3af;
            margin-top: 5px;
        }

        /* ── Info grid ── */
        .divider {
            border-top: 1px solid #f3f4f6;
            margin: 14px 0 10px;
        }
        .info-table { width: 100%; border-collapse: collapse; }
        .info-table td { width: 50%; padding: 4px 8px 4px 0; vertical-align: top; }
        .info-lbl {
            font-size: 8px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #9ca3af;
            margin-bottom: 2px;
        }
        .info-val {
            font-size: 11px;
            font-weight: 600;
            color: #374151;
        }

        /* ── Status banner ── */
        .banner-wrap {
            margin: 0 28px 18px;
            border-radius: 12px;
            padding: 11px 16px;
        }
        .banner-confirme { background-color: #f0fdf4; border: 1px solid #bbf7d0; }
        .banner-valide   { background-color: #eff6ff; border: 1px solid #bfdbfe; }
        .banner-annule   { background-color: #fef2f2; border: 1px solid #fecaca; }
        .banner-actif    { background-color: #f5f3ff; border: 1px solid #ddd6fe; }

        .banner-table { width: 100%; border-collapse: collapse; }
        .banner-table td { vertical-align: middle; }
        .banner-icon-cell { width: 26px; }

        .banner-text { font-size: 10px; font-weight: 600; }
        .color-confirme { color: #166534; }
        .color-valide   { color: #1e40af; }
        .color-annule   { color: #991b1b; }
        .color-actif    { color: #5b21b6; }

        /* ── Footer ── */
        .footer {
            background-color: #f8fafc;
            border-top: 1px solid #e5e7eb;
            padding: 10px 28px;
        }
        .footer-table { width: 100%; border-collapse: collapse; }
        .footer-table td { vertical-align: middle; }
        .footer-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .fb-confirme { background-color: #d1fae5; color: #065f46; }
        .fb-valide   { background-color: #dbeafe; color: #1e40af; }
        .fb-annule   { background-color: #fee2e2; color: #991b1b; }
        .fb-actif    { background-color: #ede9fe; color: #5b21b6; }
        .footer-powered { font-size: 8px; color: #9ca3af; text-align: right; }

    </style>
</head>
<body>
@php
    use chillerlan\QRCode\QRCode;
    use chillerlan\QRCode\QROptions;
    use chillerlan\QRCode\Output\QRGdImagePNG;

    $qrUrl = route('ticket.show', $ticket->uuid);

    $options = new QROptions;
    $options->outputInterface  = QRGdImagePNG::class;
    $options->outputBase64     = true;
    $options->scale            = 5;
    $options->imageTransparent = false;

    $dataUri  = (new QRCode($options))->render($qrUrl);
    $qrBase64 = str_replace('data:image/png;base64,', '', $dataUri);

    $ticketStatus  = $ticket->status;
    $guestStatus   = $ticket->guest->status;
    $displayStatus = ($ticketStatus === 'actif' && $guestStatus === 'confirme') ? 'confirme' : $ticketStatus;

    $statusLabel = match($displayStatus) {
        'confirme' => 'Confirmé',
        'valide'   => 'Validé',
        'annule'   => 'Annulé',
        default    => 'Actif',
    };

    $bannerText = match($displayStatus) {
        'confirme' => 'Votre présence est confirmée ! À bientôt.',
        'valide'   => "Votre ticket a été validé à l'entrée.",
        'annule'   => 'Votre participation a été annulée.',
        default    => 'En attente de confirmation.',
    };
@endphp

<div class="page">

    <div class="card">

        {{-- ===== HEADER ===== --}}
        <div class="header">
            <table class="header-top">
                <tr>
                    <td class="ticket-label">Ticket d'invitation</td>
                    <td style="text-align:right;">
                        <span class="status-pill pill-{{ $displayStatus }}">{{ $statusLabel }}</span>
                    </td>
                </tr>
            </table>

            <div class="event-title">{{ $ticket->event->title }}</div>

            {{-- Date --}}
            <div class="meta-row">
                <svg class="meta-svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#c7d2fe" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                <span class="meta-text">{{ ucfirst(\Carbon\Carbon::parse($ticket->event->date_start)->locale('fr')->isoFormat('dddd DD MMMM YYYY [à] HH:mm')) }}</span>
            </div>

            {{-- Venue --}}
            @if($ticket->event->venue)
            <div class="meta-row">
                <svg class="meta-svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#c7d2fe" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
                <span class="meta-text">{{ $ticket->event->venue }}{{ $ticket->event->city ? ', '.$ticket->event->city : '' }}</span>
            </div>
            @endif
        </div>

        {{-- ===== TEAR LINE ===== --}}
        <div class="tear-wrap">
            <div class="tear-circle-left"></div>
            <div class="tear-line"></div>
            <div class="tear-circle-right"></div>
        </div>

        {{-- ===== BODY ===== --}}
        <div class="body">
            <table class="body-table">
                <tr>
                    <td class="guest-col">
                        <div class="section-lbl">Invité(e)</div>
                        <div class="guest-name">{{ $ticket->guest->name }}</div>
                        @if($ticket->guest->email)
                        <div class="guest-email">{{ $ticket->guest->email }}</div>
                        @endif
                        <div class="uuid-box">
                            <div class="uuid-lbl">UUID du ticket</div>
                            <div class="uuid-val">{{ $ticket->uuid }}</div>
                        </div>
                    </td>
                    <td class="qr-col">
                        <div class="qr-frame">
                            <img src="data:image/png;base64,{{ $qrBase64 }}" alt="QR Code">
                        </div>
                        <div class="qr-hint">Scannez-moi</div>
                    </td>
                </tr>
            </table>

            <div class="divider"></div>

            <table class="info-table">
                <tr>
                    <td>
                        <div class="info-lbl">Type d'événement</div>
                        <div class="info-val">{{ ucfirst($ticket->event->type) }}</div>
                    </td>
                    <td>
                        <div class="info-lbl">Émis le</div>
                        <div class="info-val">{{ $ticket->created_at->format('d/m/Y H:i') }}</div>
                    </td>
                </tr>
                @if($ticket->event->is_paid && $ticket->event->price)
                <tr>
                    <td>
                        <div class="info-lbl">Tarif</div>
                        <div class="info-val">{{ number_format($ticket->event->price, 0) }} {{ $ticket->event->currency }}</div>
                    </td>
                    <td>
                        @if($ticket->validated_at)
                        <div class="info-lbl">Validé le</div>
                        <div class="info-val">{{ \Carbon\Carbon::parse($ticket->validated_at)->format('d/m/Y H:i') }}</div>
                        @endif
                    </td>
                </tr>
                @elseif($ticket->validated_at)
                <tr>
                    <td>
                        <div class="info-lbl">Validé le</div>
                        <div class="info-val">{{ \Carbon\Carbon::parse($ticket->validated_at)->format('d/m/Y H:i') }}</div>
                    </td>
                    <td></td>
                </tr>
                @endif
            </table>
        </div>

        {{-- ===== STATUS BANNER ===== --}}
        <div class="banner-wrap banner-{{ $displayStatus }}">
            <table class="banner-table">
                <tr>
                    <td class="banner-icon-cell">
                        @if($displayStatus === 'confirme' || $displayStatus === 'actif')
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor" style="color:{{ $displayStatus === 'confirme' ? '#16a34a' : '#7c3aed' }};">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        @elseif($displayStatus === 'valide')
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="#2563eb">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        @else
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="#dc2626">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        @endif
                    </td>
                    <td>
                        <span class="banner-text color-{{ $displayStatus }}">{{ $bannerText }}</span>
                    </td>
                </tr>
            </table>
        </div>

        {{-- ===== FOOTER ===== --}}
        <div class="footer">
            <table class="footer-table">
                <tr>
                    <td>
                        <span class="footer-badge fb-{{ $displayStatus }}">{{ $statusLabel }}</span>
                    </td>
                    <td class="footer-powered">Généré par EventFlow &mdash; {{ date('Y') }}</td>
                </tr>
            </table>
        </div>

    </div>{{-- .card --}}

</div>
</body>
</html>
