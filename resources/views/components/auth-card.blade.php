<div class="flex flex-col sm:justify-center items-center pt-6 px-4 sm:pt-0">
    
	@isset($logo)
    <div>
        {{ $logo }}
    </div>
    @endisset

    @isset($registro)
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md sm:rounded-lg back-alternativo contenedor-eres-nuevo esq-redondas">
        {{ $registro }}
    </div>
    @endisset

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md sm:rounded-lg esq-redondas">
        {{ $slot }}
    </div>
</div>
