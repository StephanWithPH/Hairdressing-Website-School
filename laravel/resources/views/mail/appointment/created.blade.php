<div>
    <p>Geachte {{ $appointment->firstname }} {{ $appointment->lastname }},</p>
    <p>Uw afspraak bij {{ env('APP_NAME') }} is succesvol aangemaakt. We verzoeken u de onderstaande gegevens te bekijken op fouten en zo nodig aan te passen via de onderstaande link.</p>
    {{ route('editappointment', $appointment->hash )}}
    <p><strong>Behandelingen:</strong></p>
    <ul style="list-style-type: '- '; padding-left: 0;">
        @forelse($appointment->treatments as $treatment)
            <li style="padding-left: 0;">{{ $treatment->name }}</li>
        @empty
            <li style="padding-left: 0;">Geen</li>
        @endforelse
    </ul>
    <p><strong>Opmerkingen:</strong><br/>
        @if(isset($appointment->comments))
            {{ $appointment->comments }}
        @else
            {{ __('Geen') }}
        @endif
    </p>
    <p><strong>Datum:</strong> {{ \Carbon\Carbon::parse($appointment->date)->format('d-m-Y') }}</p>
    <p><strong>Tijd:</strong> {{ explode(":", $appointment->time_from)[0] }}:{{ explode(":", $appointment->time_from)[1] }} - {{ explode(":", $appointment->time_until)[0] }}:{{ explode(":", $appointment->time_until)[1] }}</p>
    <p>Met vriendelijke groet,</p>
    <p>{{ env('APP_NAME') }}</p>
</div>
