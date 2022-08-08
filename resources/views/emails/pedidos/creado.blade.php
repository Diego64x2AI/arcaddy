@component('mail::message')
# Gracias por tu pedido

Te mostramos la información de tu pedido:

@component('mail::table')
| Producto      |
| :------------ |
@foreach ($pedido->productos as $producto)
| {{ $producto->producto->nombre }}      |
@endforeach
@endcomponent

## Total: ${{ number_format($pedido->total, 2) }}

Gracias,<br>
{{ config('app.name') }}
@endcomponent
