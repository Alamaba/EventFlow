<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Invitation — {{ $event->title }}</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
  * { margin:0; padding:0; box-sizing:border-box; }
  body { font-family: 'Inter', Arial, sans-serif; background:#f1f5f9; color:#1e293b; }
  a { color: inherit; text-decoration: none; }
</style>
</head>
<body style="background:#f1f5f9; padding: 32px 16px;">

<table width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" role="presentation" style="max-width:600px; width:100%;">

  {{-- ===== HEADER LOGO ===== --}}
  <tr>
    <td align="center" style="padding: 0 0 24px 0;">
      <table cellpadding="0" cellspacing="0" role="presentation">
        <tr>
          <td style="background: linear-gradient(135deg,#6366f1,#8b5cf6); border-radius:12px; padding:10px 14px; display:inline-block;">
            <span style="color:#fff; font-size:13px; font-weight:800; letter-spacing:-0.3px;">
              <span style="color:#c7d2fe;">Event</span>Flow
            </span>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  {{-- ===== MAIN CARD ===== --}}
  <tr>
    <td style="background:#ffffff; border-radius:20px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,0.08);">

      {{-- Hero banner --}}
      <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
          <td style="background: linear-gradient(135deg, #312e81 0%, #4f46e5 50%, #7c3aed 100%); padding: 48px 40px 40px; text-align:center;">

            {{-- Badge --}}
            <div style="display:inline-block; background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.25); border-radius:100px; padding:6px 16px; margin-bottom:20px;">
              <span style="color:#e0e7ff; font-size:11px; font-weight:600; letter-spacing:1.2px; text-transform:uppercase;">Invitation personnelle</span>
            </div>

            {{-- Title --}}
            <h1 style="color:#ffffff; font-size:28px; font-weight:800; line-height:1.2; margin-bottom:8px; letter-spacing:-0.5px;">
              {{ $event->title }}
            </h1>
            <p style="color:#c7d2fe; font-size:14px; font-weight:400; margin-bottom:28px;">
              Vous êtes officiellement invité(e) à cet événement
            </p>

            {{-- Date pill --}}
            <table cellpadding="0" cellspacing="0" role="presentation" style="margin:0 auto;">
              <tr>
                <td style="background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.2); border-radius:10px; padding:12px 20px;">
                  <table cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                      <td style="padding-right:16px; border-right:1px solid rgba(255,255,255,0.2);">
                        <p style="color:#a5b4fc; font-size:10px; font-weight:600; text-transform:uppercase; letter-spacing:0.8px; margin-bottom:2px;">Date</p>
                        <p style="color:#fff; font-size:13px; font-weight:700;">{{ $event->date_start->locale('fr')->isoFormat('DD MMM YYYY') }}</p>
                      </td>
                      <td style="padding-left:16px;">
                        <p style="color:#a5b4fc; font-size:10px; font-weight:600; text-transform:uppercase; letter-spacing:0.8px; margin-bottom:2px;">Heure</p>
                        <p style="color:#fff; font-size:13px; font-weight:700;">{{ $event->date_start->format('H:i') }}</p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        {{-- Greeting --}}
        <tr>
          <td style="padding: 36px 40px 0;">
            <p style="font-size:15px; color:#64748b; margin-bottom:8px;">Bonjour,</p>
            <h2 style="font-size:22px; font-weight:800; color:#0f172a; margin-bottom:16px;">{{ $guest->name }} 👋</h2>
            <p style="font-size:14px; color:#475569; line-height:1.7;">
              Nous avons le plaisir de vous convier à <strong style="color:#4f46e5;">{{ $event->title }}</strong>.
              Votre présence nous honorerait. Cliquez sur le bouton ci-dessous pour consulter votre ticket et confirmer votre participation.
            </p>
          </td>
        </tr>

        {{-- Event details --}}
        <tr>
          <td style="padding: 24px 40px;">
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                   style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:14px; overflow:hidden;">
              <tr>
                <td style="padding:20px 24px;">
                  <p style="font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:#94a3b8; margin-bottom:14px;">Détails de l'événement</p>

                  {{-- Date row --}}
                  <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom:10px;">
                    <tr>
                      <td width="32" style="vertical-align:top; padding-top:2px;">
                        <table cellpadding="0" cellspacing="0" role="presentation" style="width:28px; height:28px;">
                          <tr><td style="width:28px; height:28px; background:#ede9fe; border-radius:8px; text-align:center; vertical-align:middle; font-size:15px; line-height:28px;">📅</td></tr>
                        </table>
                      </td>
                      <td style="padding-left:12px; vertical-align:top;">
                        <p style="font-size:11px; color:#94a3b8; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Date et heure</p>
                        <p style="font-size:14px; color:#1e293b; font-weight:600; margin-top:2px;">
                          {{ ucfirst($event->date_start->locale('fr')->isoFormat('dddd DD MMMM YYYY [à] HH:mm')) }}
                        </p>
                      </td>
                    </tr>
                  </table>

                  @if($event->venue)
                  {{-- Venue row --}}
                  <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom:10px;">
                    <tr>
                      <td width="32" style="vertical-align:top; padding-top:2px;">
                        <table cellpadding="0" cellspacing="0" role="presentation" style="width:28px; height:28px;">
                          <tr><td style="width:28px; height:28px; background:#ede9fe; border-radius:8px; text-align:center; vertical-align:middle; font-size:15px; line-height:28px;">📍</td></tr>
                        </table>
                      </td>
                      <td style="padding-left:12px; vertical-align:top;">
                        <p style="font-size:11px; color:#94a3b8; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Lieu</p>
                        <p style="font-size:14px; color:#1e293b; font-weight:600; margin-top:2px;">
                          {{ $event->venue }}{{ $event->city ? ', ' . $event->city : '' }}
                        </p>
                        @if($event->address)
                          <p style="font-size:12px; color:#64748b; margin-top:2px;">{{ $event->address }}</p>
                        @endif
                      </td>
                    </tr>
                  </table>
                  @endif

                  @if($event->is_paid && $event->price)
                  {{-- Price row --}}
                  <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                      <td width="32" style="vertical-align:top; padding-top:2px;">
                        <table cellpadding="0" cellspacing="0" role="presentation" style="width:28px; height:28px;">
                          <tr><td style="width:28px; height:28px; background:#ede9fe; border-radius:8px; text-align:center; vertical-align:middle; font-size:15px; line-height:28px;">💳</td></tr>
                        </table>
                      </td>
                      <td style="padding-left:12px; vertical-align:top;">
                        <p style="font-size:11px; color:#94a3b8; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Tarif</p>
                        <p style="font-size:14px; color:#1e293b; font-weight:600; margin-top:2px;">
                          {{ number_format($event->price, 0) }} {{ $event->currency }}
                        </p>
                      </td>
                    </tr>
                  </table>
                  @endif

                </td>
              </tr>
            </table>
          </td>
        </tr>

        {{-- CTA Button --}}
        <tr>
          <td style="padding: 4px 40px 36px; text-align:center;">
            <a href="{{ $ticketUrl }}"
               style="display:inline-block; background: linear-gradient(135deg,#4f46e5,#7c3aed); color:#fff; font-size:15px; font-weight:700; padding:16px 40px; border-radius:14px; letter-spacing:0.2px; box-shadow:0 4px 14px rgba(79,70,229,0.4);">
              Voir mon ticket &amp; QR Code →
            </a>
            <p style="font-size:12px; color:#94a3b8; margin-top:12px;">
              Ou copiez ce lien : <a href="{{ $ticketUrl }}" style="color:#6366f1; text-decoration:underline; word-break:break-all;">{{ $ticketUrl }}</a>
            </p>
          </td>
        </tr>

        {{-- Divider --}}
        <tr>
          <td style="padding: 0 40px;">
            <hr style="border:none; border-top:1px solid #e2e8f0;">
          </td>
        </tr>

        {{-- Info note --}}
        <tr>
          <td style="padding: 24px 40px 32px;">
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                   style="background:#eff6ff; border-left:3px solid #6366f1; border-radius:0 10px 10px 0; padding:0;">
              <tr>
                <td style="padding:14px 18px;">
                  <p style="font-size:13px; color:#1e40af; font-weight:600; margin-bottom:4px;">ℹ️ Comment utiliser votre ticket ?</p>
                  <p style="font-size:12px; color:#3b82f6; line-height:1.6;">
                    Votre ticket contient un QR code unique. Présentez-le à l'entrée de l'événement — sous format numérique ou imprimé. Il sera scanné par notre équipe pour valider votre accès.
                  </p>
                </td>
              </tr>
            </table>
          </td>
        </tr>

      </table>
    </td>
  </tr>

  {{-- ===== FOOTER ===== --}}
  <tr>
    <td style="padding: 24px 0; text-align:center;">
      <p style="font-size:12px; color:#94a3b8; margin-bottom:4px;">
        Cet email a été envoyé par <strong style="color:#6366f1;">EventFlow</strong>
      </p>
      <p style="font-size:11px; color:#cbd5e1;">
        &copy; {{ date('Y') }} EventFlow — Plateforme de gestion d'événements
      </p>
    </td>
  </tr>

</table>
</td></tr>
</table>

</body>
</html>
