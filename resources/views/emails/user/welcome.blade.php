@component('mail::message')
# Gracias por tu registro en {{ config('app.name') }}

Hola {{ $user->name }}, gracias por registrarte en {{ config('app.name') }}.
@endcomponent
