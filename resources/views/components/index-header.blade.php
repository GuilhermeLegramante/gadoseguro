@props([
    'title',
    'titleHighlight',
    'subtitle',
    'routeCreate' => null,
    'buttonLabel' => 'Adicionar',
    'icon' => 'plus',
    'model' => null, // Adicionamos essa prop para checar a permissão
])

<div {{ $attributes->merge(['class' => 'flex flex-col md:flex-row md:items-end justify-between gap-6 px-2 mb-10']) }}>
    <div class="flex-1">
        <h1 class="text-3xl md:text-4xl font-black text-[#064e3b] uppercase italic leading-[0.9] tracking-tighter">
            {{ $title }} <br class="hidden md:block">
            <span class="opacity-90">{{ $titleHighlight }}</span>
        </h1>
        <p class="text-sm text-gray-500 font-medium mt-2 uppercase tracking-wide opacity-80">
            {{ $subtitle }}
        </p>
    </div>

    {{-- Só exibe o botão se o model não for passado OU se o usuário tiver permissão de 'create' --}}
    @if ($routeCreate && (!$model || auth()->user()->can('create', $model)))
        <div class="flex flex-row gap-2 w-full md:w-auto">
            <a href="{{ $routeCreate }}"
                class="flex-1 md:flex-none bg-[#064e3b] hover:bg-green-700 text-white px-6 py-5 rounded-[1.5rem] font-black uppercase text-[10px] tracking-widest shadow-xl shadow-green-900/10 transition-all active:scale-95 flex items-center justify-center gap-2">
                <i data-lucide="{{ $icon }}" class="w-4 h-4"></i>
                <span>{{ $buttonLabel }}</span>
            </a>
        </div>
    @endif
</div>
