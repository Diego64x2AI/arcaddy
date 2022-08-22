@component('mail::message')
<img src="{{ asset('storage/'.$cliente->logo) }}" style="width:100%;max-width: 400px; height:auto;display:inline-block" alt="{{ $cliente->cliente }}"><br>
# Gracias por registrarte a {{ $cliente->cliente }}

Hola {{ $user->name }}, presenta este qr en el evento como boleto de acceso personalizado.

<div style="text-align: center;">
<img src="{{ asset('storage/qrcodes/'.$cliente->slug.'.png?'.time()) }}" style="width:100%;max-width: 400px; height:auto;display:inline-block" alt="{{ $cliente->cliente }}"><br>
<a href="{{ route('cliente', ['slug' => $cliente->slug]) }}" target="_blank">{{ route('cliente', ['slug' => $cliente->slug]) }}</a>
</div>
<br>
<div style="text-align: center;">
Tu <strong>ID</strong> de usuario es: <strong>{{ $user->id }}</strong>
</div>
@endcomponent
