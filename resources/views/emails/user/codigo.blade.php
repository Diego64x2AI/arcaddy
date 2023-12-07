<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="color-scheme" content="light">
<meta name="supported-color-schemes" content="light">
<style>
@media only screen and (max-width: 600px) {
.inner-body {
width: 100% !important;
}

.footer {
width: 100% !important;
}
}

@media only screen and (max-width: 500px) {
.button {
width: 100% !important;
}
}
</style>
</head>
<body>

<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="center">
<table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<!-- Email Body -->
<tr>
<td class="body" width="100%" cellpadding="0" cellspacing="0">
<table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
<!-- Body content -->
<tr>
<td class="content-cell">
	@if ($cliente->id === NULL)
		<a href="{{ route('home') }}"><x-application-logo class="w-auto h-20 fill-current text-gray-500" /></a>
	@else
		<div class="flex justify-center">
			<a href="{{ route('cliente', ['slug' => $cliente->slug]) }}"><img src="{{ asset('storage/'.$cliente->logo) }}" class="logo"></a>
		</div>
		@if($cliente->registro_img !== NULL)
			<div style="margin-top: 2rem">
				<img src="{{ asset('storage/'.$cliente->registro_img) }}" class="img-cliente">
			</div>
		@endif
	@endif
	<h1 class="text-center" style="margin: 1rem 0; text-align:center; font-size: 2rem">¡Registro Exitoso!</h1>
	<h2 style="color: {{ $cliente->color }}; text-align:center; font-size: 1.2rem">BIENVENIDO</h2>
	<div class="text-center">{{ $user->name }}</div>
	<div class="text-center">{{ $user->email }}</div>
	<div style="text-align: center; margin-top: 2rem;">
	
	<?php /*
	<img src="{{ asset('storage/qrcodes/'.$cliente->slug.'.png?'.time()) }}" style="width:100%;max-width: 200px; height:auto;display:inline-block" alt="{{ $cliente->cliente }}">*/?>

	<img src="{{ asset('storage/qrregister/'.$codigo.'.png?'.time()) }}" style="width:100%;max-width: 200px; height:auto;display:inline-block" alt="{{ $cliente->cliente }}">


	</div>
	<div style="text-align: center; margin-top: 2rem;">
	<a href="{{ route('cliente', ['slug' => $cliente->slug]) }}" class="btn-pill" style="background-color: {{ $cliente->color }};">Ir a página principal</a>
	</div>
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>
