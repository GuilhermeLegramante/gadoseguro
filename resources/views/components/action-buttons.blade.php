@props(['routeEdit', 'routeDelete', 'deleteTitle', 'deleteMessage', 'deleteIcon', 'model' => null])

<div class="flex gap-2 w-full md:w-auto">
    {{-- Botão Editar --}}
    @if (!$model || auth()->user()->can('update', $model))
        <a href="{{ $routeEdit }}"
            class="flex-1 md:flex-none bg-[#064e3b] hover:bg-green-700 text-white px-6 py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest transition-all shadow-lg flex items-center justify-center gap-2">
            <i data-lucide="edit-3" class="w-4 h-4"></i> Editar
        </a>
    @endif

    {{-- Botão Excluir --}}
    @if (!$model || auth()->user()->can('delete', $model))
        <button
            onclick="openDeleteModal('{{ $routeDelete }}', '{{ $deleteTitle }}', '{{ $deleteMessage }}', '{{ $deleteIcon }}')"
            class="p-4 bg-white text-red-500 border border-red-100 rounded-2xl hover:bg-red-500 hover:text-white transition-all shadow-sm">
            <i data-lucide="trash-2" class="w-5 h-5"></i>
        </button>
    @endif
</div>
