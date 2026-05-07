<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ticket - {{ $ticket->event->title }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 12px; color: #1f2937; background: #eef2ff; }
        .page { padding: 28px; }
        .ticket { width: 520px; margin: 0 auto; border-radius: 14px; overflow: hidden; border: 1.5px solid #c7d2fe; }

        /* Header */
        .header { background-color: #4f46e5; padding: 26px 28px 20px; color: #fff; }
        .brand { font-size: 9px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: rgba(255,255,255,0.55); margin-bottom: 10px; }
        .event-title { font-size: 19px; font-weight: 900; color: #fff; margin-bottom: 14px; line-height: 1.3; }
        .header-table { width: 100%; border-collapse: collapse; }
        .header-table td { padding: 1px 0; font-size: 10px; color: rgba(255,255,255,0.75); vertical-align: top; }
        .header-table td.lbl { font-weight: 700; color: rgba(255,255,255,0.5); width: 55px; }
        .status-pill { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 8px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; }
        .pill-actif   { background: rgba(74,222,128,0.25); color: #a7f3d0; }
        .pill-valide  { background: rgba(96,165,250,0.25); color: #bfdbfe; }
        .pill-annule  { background: rgba(248,113,113,0.25); color: #fecaca; }
        .pill-confirme{ background: rgba(74,222,128,0.25); color: #a7f3d0; }

        /* Tear line */
        .tear { height: 0; border-top: 2px dashed #a5b4fc; background: #fff; position: relative; }

        /* Body */
        .body { background: #fff; padding: 20px 28px 16px; }
        .body-table { width: 100%; border-collapse: collapse; }
        .body-table td { vertical-align: top; }
        .guest-col { padding-right: 14px; }
        .qr-col { width: 106px; text-align: center; }

        .section-label { font-size: 8px; font-weight: 700; letter-spacing: 1.8px; text-transform: uppercase; color: #9ca3af; margin-bottom: 4px; }
        .guest-name   { font-size: 17px; font-weight: 900; color: #111827; margin-bottom: 2px; }
        .guest-email  { font-size: 10px; color: #6b7280; margin-bottom: 10px; }

        .uuid-box { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 6px; padding: 7px 10px; }
        .uuid-lbl { font-size: 8px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: #9ca3af; margin-bottom: 2px; }
        .uuid-val { font-family: 'Courier New', monospace; font-size: 8px; color: #374151; word-break: break-all; }

        .qr-frame { border: 3px solid #e0e7ff; border-radius: 8px; padding: 3px; display: inline-block; background: #fff; }
        .qr-frame img { display: block; width: 96px; height: 96px; }
        .qr-hint { font-size: 8px; color: #9ca3af; margin-top: 4px; }

        /* Info grid */
        .info-row { margin-top: 14px; padding-top: 12px; border-top: 1px solid #f3f4f6; }
        .info-table { width: 100%; border-collapse: collapse; }
        .info-table td { padding: 3px 8px 3px 0; vertical-align: top; width: 50%; }
        .info-lbl { font-size: 8px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: #9ca3af; margin-bottom: 2px; }
        .info-val { font-size: 11px; font-weight: 600; color: #374151; }

        /* Footer */
        .footer { background: #f8fafc; border-top: 1px solid #e5e7eb; padding: 10px 28px; }
        .footer-table { width: 100%; border-collapse: collapse; }
        .footer-table td { vertical-align: middle; }
        .footer-table td:last-child { text-align: right; }
        .fs-badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 9px; font-weight: 700; text-transform: uppercase; }
        .fs-actif    { background: #d1fae5; color: #065f46; }
        .fs-valide   { background: #dbeafe; color: #1e40af; }
        .fs-annule   { background: #fee2e2; color: #991b1b; }
        .fs-confirme { background: #d1fae5; color: #065f46; }
        .powered { font-size: 9px; color: #9ca3af; }
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
@endphp
<div class="page">
<div class="ticket">

    {{-- HEADER --}}
    <div class="header">
        <table style="width:100%;border-collapse:collapse;margin-bottom:8px;">
            <tr>
                <td class="brand">EventFlow &mdash; Ticket d'entrée</td>
                <td style="text-align:right;vertical-align:top;">
                    <span class="status-pill pill-{{ $displayStatus }}">
                        @if($displayStatus==='confirme') Confirmé
                        @elseif($displayStatus==='valide') Validé
                        @elseif($displayStatus==='annule') Annulé
                        @else Actif @endif
                    </span>
                </td>
            </tr>
        </table>
        <div class="event-title">{{ $ticket->event->title }}</div>
        <table class="header-table">
            <tr><td class="lbl">Date</td><td>{{ \Carbon\Carbon::parse($ticket->event->date_start)->format('d/m/Y à H:i') }}</td></tr>
            @if($ticket->event->venue)
            <tr><td class="lbl">Lieu</td><td>{{ $ticket->event->venue }}{{ $ticket->event->city ? ', '.$ticket->event->city : '' }}</td></tr>
            @endif
            @if($ticket->event->address)
            <tr><td class="lbl">Adresse</td><td>{{ $ticket->event->address }}</td></tr>
            @endif
        </table>
    </div>

    {{-- TEAR LINE --}}
    <div class="tear"></div>

    {{-- BODY --}}
    <div class="body">
        <table class="body-table">
            <tr>
                <td class="guest-col">
                    <div class="section-label">Invité(e)</div>
                    <div class="guest-name">{{ $ticket->guest->name }}</div>
                    @if($ticket->guest->email)
                    <div class="guest-email">{{ $ticket->guest->email }}</div>
                    @endif
                    <div class="uuid-box">
                        <div class="uuid-lbl">Identifiant unique (UUID)</div>
                        <div class="uuid-val">{{ $ticket->uuid }}</div>
                    </div>
                </td>
                <td class="qr-col">
                    <div class="qr-frame">
                        <img src="data:image/png;base64,{{ $qrBase64 }}" alt="QR Code">
                    </div>
                    <div class="qr-hint">Scannez à l'entrée</div>
                </td>
            </tr>
        </table>

        <div class="info-row">
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
                @if($ticket->event->is_paid)
                <tr>
                    <td>
                        <div class="info-lbl">Prix</div>
                        <div class="info-val">{{ number_format($ticket->event->price, 0) }} {{ $ticket->event->currency }}</div>
                    </td>
                    <td></td>
                </tr>
                @endif
                @if($ticket->validated_at)
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
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        <table class="footer-table">
            <tr>
                <td>
                    <span class="fs-badge fs-{{ $displayStatus }}">
                        @if($displayStatus==='confirme') Confirmé
                        @elseif($displayStatus==='valide') Validé
                        @elseif($displayStatus==='annule') Annulé
                        @else Actif @endif
                    </span>
                </td>
                <td class="powered">Généré par EventFlow &mdash; {{ date('Y') }}</td>
            </tr>
        </table>
    </div>

</div>
</div>
</body>
</html>
