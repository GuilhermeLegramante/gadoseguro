@props(['marca'])

<div
    class="bg-white rounded-[2.5rem] shadow-sm border border-gray-200 overflow-hidden flex flex-col min-h-[420px] group hover:border-green-500 transition-all duration-300">
    {{-- Header --}}
    <div class="p-5 flex justify-between items-start border-b border-gray-50 bg-white">
        <div class="flex-1">
            <span class="text-[9px] font-black text-green-600 uppercase tracking-[0.2em]">
                Título nº {{ $marca->numero }}/{{ $marca->ano }}
            </span>
            <h2
                class="text-base md:text-lg font-bold text-gray-800 leading-tight group-hover:text-[#064e3b] transition-colors truncate max-w-[180px] md:max-w-none">
                {{ $marca->produtor->nome }}
            </h2>
            <p class="text-[10px] text-gray-400 flex items-center gap-1 mt-1 font-medium italic">
                <i data-lucide="map-pin" class="w-3 h-3"></i>
                {{ $marca->municipio->nome }} - RS
            </p>
        </div>
        <div
            class="bg-gray-100 group-hover:bg-green-50 p-2 rounded-2xl text-center min-w-[50px] transition-colors shadow-sm">
            <span class="block text-[7px] uppercase font-black text-gray-400 group-hover:text-green-600">Ano</span>
            <span
                class="font-black text-xs md:text-sm text-gray-700 group-hover:text-[#064e3b]">{{ $marca->ano }}</span>
        </div>
    </div>

    {{-- Imagens (Grid) --}}
    <div class="grid grid-cols-2 bg-gray-50 aspect-[16/9] md:h-44 relative border-b border-gray-100">
        {{-- Lado Digital --}}
        <div class="flex flex-col items-center justify-center border-r border-white p-3 relative bg-[#fcfcfc]">
            <span
                class="absolute top-2 left-3 text-[7px] uppercase font-black text-gray-300 italic tracking-widest z-10">Digital</span>
            <div
                class="w-full h-full bg-white rounded-2xl border border-gray-100 flex items-center justify-center overflow-hidden p-2 shadow-inner relative">
                {{-- Canvas com ID único --}}
                <canvas id="canvas-{{ $marca->id }}"
                    data-vector="{{ is_array($marca->desenho_vetor) ? json_encode($marca->desenho_vetor) : $marca->desenho_vetor }}"
                    class="brand-canvas w-full h-full max-h-[120px]"></canvas>
            </div>
        </div>

        {{-- Lado Campo --}}
        <div class="flex flex-col items-center justify-center p-3 relative">
            <span
                class="absolute top-2 left-3 text-[7px] uppercase font-black text-gray-300 italic tracking-widest z-10">Campo</span>
            @if ($marca->foto_path)
                <img src="{{ asset('storage/' . $marca->foto_path) }}"
                    class="w-full h-full object-cover rounded-2xl shadow-inner border border-gray-100"
                    alt="Foto da Marca">
            @else
                <div
                    class="w-full h-full bg-gray-200/50 rounded-2xl flex flex-col items-center justify-center gap-1 border-2 border-dashed border-gray-300">
                    <i data-lucide="camera-off" class="text-gray-400 w-4 h-4"></i>
                    <span class="text-[7px] font-black text-gray-400 uppercase tracking-tighter">Sem foto</span>
                </div>
            @endif
        </div>
    </div>

    {{-- Footer com Ações (Ajustado para Mobile) --}}
    <div class="mt-auto p-4 bg-white space-y-2">
        <a href="{{ route('marcas.show', $marca->id) }}"
            class="w-full flex items-center justify-center gap-2 text-[10px] font-black uppercase text-[#064e3b] bg-green-50 hover:bg-green-600 hover:text-white py-3.5 rounded-xl transition-all tracking-widest active:scale-95 shadow-sm">
            <i data-lucide="eye" class="w-4 h-4"></i> Ver Registro
        </a>

        <div class="flex items-center gap-2">
            <a href="{{ route('marcas.edit', $marca->id) }}"
                class="flex-1 p-3 flex items-center justify-center text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white rounded-xl transition-all border border-blue-100 active:scale-95">
                <i data-lucide="edit-3" class="w-4 h-4"></i>
            </a>

            <button onclick="compartilharMarca('{{ $marca->id }}')"
                class="flex-1 p-3 flex items-center justify-center text-gray-500 bg-gray-50 hover:bg-gray-200 rounded-xl transition-all border border-gray-100">
                <i data-lucide="share-2" class="w-4 h-4"></i>
            </button>

            <button
                onclick="openDeleteModal('{{ route('marcas.destroy', $marca->id) }}', 'Excluir Marca?', 'O registro será removido permanentemente.', 'trash-2')"
                class="flex-1 p-3 flex items-center justify-center text-red-500 bg-red-50 hover:bg-red-600 hover:text-white rounded-xl transition-all border border-red-100 active:scale-95">
                <i data-lucide="trash-2" class="w-4 h-4"></i>
            </button>
        </div>
    </div>
</div>
