@props([
    'backRoute',
    'title',
    'subtitle' => null,
    'routeEdit' => null,
    'routeDelete' => null,
    'deleteTitle' => 'Excluir Registro?',
    'deleteMessage' => 'Tem certeza que deseja remover este item?',
    'deleteIcon' => 'trash-2',
    'model' => null, // O objeto completo (ex: $marca ou $produtor)
])

<div {{ $attributes->merge(['class' => 'flex flex-col md:flex-row gap-4 md:items-center justify-between px-2 mb-8']) }}>
    {{-- Lado Esquerdo: Navegação e Títulos --}}
    <div class="flex items-center gap-4">
        <a href="{{ $backRoute }}"
            class="bg-white p-3 rounded-2xl shadow-sm border border-gray-100 hover:bg-gray-50 transition-all active:scale-90">
            <i data-lucide="chevron-left" class="w-6 h-6 text-gray-600"></i>
        </a>
        <div>
            <h1 class="text-2xl md:text-3xl font-black text-gray-900 uppercase italic leading-none">
                {{ $title }}
            </h1>
            @if ($subtitle)
                <p class="text-xs md:text-sm text-gray-500 font-medium mt-1 uppercase tracking-wider">
                    {{ $subtitle }}
                </p>
            @endif
        </div>
    </div>

    {{-- Lado Direito: Botões de Ação --}}
    {{-- Só tentamos renderizar se as rotas existirem --}}
    @if ($routeEdit && $routeDelete)
        {{-- 
           Verificamos as permissões:
           Se não houver 'model', mostra por padrão (fallback).
           Se houver 'model', verifica se o usuário pode editar OU excluir.
        --}}
        @if (!$model || (auth()->user()->can('update', $model) || auth()->user()->can('delete', $model)))
            <x-action-buttons :routeEdit="$routeEdit" :routeDelete="$routeDelete" :deleteTitle="$deleteTitle" :deleteMessage="$deleteMessage" :deleteIcon="$deleteIcon"
                :model="$model" {{-- Passamos o model para o componente interno também --}} />
        @endif
    @endif
</div>
