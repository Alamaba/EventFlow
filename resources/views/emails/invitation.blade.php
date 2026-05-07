<x-mail::message>
# Vous êtes invité(e) !

Bonjour **{{ $guest->name }}**,

Vous êtes cordialement invité(e) à l'événement **{{ $event->title }}**.

**Date :** {{ $event->date_start->format('d/m/Y à H:i') }}
**Lieu :** {{ $event->venue }}
@if($event->address)
**Adresse :** {{ $event->address }}, {{ $event->city }}
@endif

<x-mail::button :url="$ticketUrl" color="success">
Voir mon ticket / QR Code
</x-mail::button>

Merci de confirmer votre présence via le lien ci-dessus.

Cordialement,<br>
L'équipe {{ config('app.name') }}
</x-mail::message>
