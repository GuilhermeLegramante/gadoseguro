@extends('layouts.app')
@section('title', 'Perfil do Produtor')

@section('content')
    <div class="space-y-6 pb-20">
        {{-- Top Bar / Navegação --}}
        <x-show-page-header :backRoute="route('produtores.index')" title="Perfil" subtitle="Gestão de Registro" :routeEdit="route('produtores.edit', $produtor->id)" :routeDelete="route('produtores.destroy', $produtor->id)"
            deleteTitle="Excluir Produtor?" :model="$produtor"
            deleteMessage="Isso removerá o produtor e o vínculo com suas marcas." deleteIcon="user-x" />

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 md:gap-8">

            {{-- Coluna da Esquerda: Info do Produtor (Crachá Expandido) --}}
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white rounded-[2.5rem] p-6 md:p-8 border border-gray-100 shadow-sm relative overflow-hidden">
                    {{-- Decorativo de fundo --}}
                    <div class="absolute -right-6 -top-6 w-32 h-32 bg-gray-50 rounded-full opacity-50"></div>

                    <div class="relative">
                        <div class="flex items-center md:flex-col md:text-center gap-5 md:gap-0">
                            <div
                                class="w-20 h-20 md:w-24 md:h-24 bg-[#064e3b] rounded-[2rem] flex items-center justify-center text-white text-3xl md:text-4xl font-black mb-0 md:mb-6 shadow-xl shadow-green-900/20 shrink-0">
                                {{ substr($produtor->nome, 0, 1) }}
                            </div>

                            <div>
                                <h2 class="text-xl md:text-2xl font-black text-gray-900 uppercase leading-tight">
                                    {{ $produtor->nome }}</h2>
                                <span
                                    class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 text-[9px] font-black px-3 py-1 rounded-full uppercase tracking-widest mt-2">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                                    Ativo no Sistema
                                </span>
                            </div>
                        </div>

                        {{-- Grid de Informações Detalhadas --}}
                        <div class="grid grid-cols-1 gap-3 border-t border-gray-100 mt-8 pt-8">

                            {{-- CPF/CNPJ e IE --}}
                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-gray-50/50 p-4 rounded-2xl">
                                    <label
                                        class="block text-[8px] font-black text-gray-400 uppercase tracking-widest mb-1">CPF/CNPJ</label>
                                    <p class="text-gray-800 font-bold font-mono text-xs">{{ $produtor->cpf_cnpj }}</p>
                                </div>
                                <div class="bg-gray-50/50 p-4 rounded-2xl">
                                    <label
                                        class="block text-[8px] font-black text-gray-400 uppercase tracking-widest mb-1">Insc.
                                        Estadual</label>
                                    <p class="text-gray-800 font-bold font-mono text-xs">
                                        {{ $produtor->inscricao_estadual ?? '---' }}</p>
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="bg-gray-50/50 p-4 rounded-2xl">
                                <label
                                    class="block text-[8px] font-black text-gray-400 uppercase tracking-widest mb-1">E-mail
                                    de Contato</label>
                                <p class="text-gray-800 font-bold text-xs truncate">
                                    {{ $produtor->email ?? 'Não informado' }}</p>
                            </div>

                            {{-- Gênero e Nascimento --}}
                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-gray-50/50 p-4 rounded-2xl">
                                    <label
                                        class="block text-[8px] font-black text-gray-400 uppercase tracking-widest mb-1">Gênero</label>
                                    <p class="text-gray-800 font-bold text-xs uppercase italic">
                                        {{ $produtor->genero ?? '---' }}</p>
                                </div>
                                <div class="bg-gray-50/50 p-4 rounded-2xl">
                                    <label
                                        class="block text-[8px] font-black text-gray-400 uppercase tracking-widest mb-1">Nascimento</label>
                                    <p class="text-gray-800 font-bold text-xs">
                                        {{ $produtor->data_nascimento ? \Carbon\Carbon::parse($produtor->data_nascimento)->format('d/m/Y') : '---' }}
                                    </p>
                                </div>
                            </div>

                            {{-- Footer do Crachá (Contagem) --}}
                            <div class="flex gap-3 mt-2">
                                <div class="flex-1 bg-[#064e3b]/5 p-4 rounded-2xl border border-[#064e3b]/10">
                                    <label
                                        class="block text-[8px] font-black text-[#064e3b] uppercase tracking-widest mb-1">Total
                                        Marcas</label>
                                    <p class="text-2xl font-black text-[#064e3b]">{{ $produtor->marcas->count() }}</p>
                                </div>
                                <div class="flex-1 bg-gray-50/50 p-4 rounded-2xl">
                                    <label
                                        class="block text-[8px] font-black text-gray-400 uppercase tracking-widest mb-1">Telefone</label>
                                    <p class="text-xs font-bold text-gray-700 mt-1">{{ $produtor->telefone ?? '---' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card de Endereço --}}
                <div class="bg-white rounded-[2.5rem] p-6 border border-gray-100 shadow-sm">
                    <h3
                        class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4 flex items-center gap-2">
                        <i data-lucide="map-pin" class="w-3 h-3 text-[#064e3b]"></i> Localização Principal
                    </h3>
                    @if ($produtor->endereco)
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm font-black text-gray-800 uppercase italic leading-tight">
                                    {{ $produtor->endereco->logradouro }}, {{ $produtor->endereco->numero }}
                                </p>
                                <p class="text-[11px] text-gray-500 font-medium">
                                    {{ $produtor->endereco->bairro }}
                                    {{ $produtor->endereco->complemento ? ' - ' . $produtor->endereco->complemento : '' }}
                                </p>
                            </div>
                            <div class="pt-3 border-t border-gray-50 flex justify-between items-end">
                                <div>
                                    <p class="text-[10px] font-black text-[#064e3b] uppercase">
                                        {{ $produtor->endereco->cidade }} / {{ $produtor->endereco->uf }}</p>
                                    <p class="text-[10px] font-mono text-gray-400">{{ $produtor->endereco->cep }}</p>
                                </div>
                                <div class="bg-gray-100 p-2 rounded-xl">
                                    <i data-lucide="navigation-2" class="w-4 h-4 text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-[10px] font-bold text-gray-400 italic">Nenhum endereço cadastrado.</p>
                    @endif
                </div>
            </div>

            {{-- Coluna da Direita: Listagem de Marcas (Mantida) --}}
            <div class="lg:col-span-8 space-y-4">
                <div class="flex items-center justify-between px-2">
                    <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">Patrimônio (Marcas)</h3>
                    <a href="{{ route('marcas.create', ['produtor_id' => $produtor->id]) }}"
                        class="text-[10px] font-black text-[#064e3b] uppercase hover:underline flex items-center gap-1">
                        <i data-lucide="plus" class="w-3 h-3"></i> Adicionar nova
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @forelse($produtor->marcas as $marca)
                        <div
                            class="bg-white p-4 rounded-[2rem] border border-gray-100 shadow-sm hover:border-[#064e3b]/30 transition-all group overflow-hidden relative">
                            <div class="flex items-center gap-4 relative z-10">
                                {{-- Preview da Marca --}}
                                <div
                                    class="w-20 h-20 md:w-24 md:h-24 bg-gray-50 rounded-2xl border border-gray-100 p-2 flex items-center justify-center overflow-hidden shrink-0 transition-transform group-hover:scale-105">
                                    <canvas id="canvas-{{ $marca->id }}" class="brand-canvas w-full h-full"
                                        data-vector="{{ json_encode($marca->desenho_vetor) }}">
                                    </canvas>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start mb-1">
                                        <span
                                            class="text-[9px] font-black text-green-600 uppercase tracking-tighter bg-green-50 px-2 py-0.5 rounded">
                                            REG. {{ $marca->numero }}
                                        </span>
                                    </div>
                                    <h4 class="text-sm font-black text-gray-800 uppercase truncate">
                                        {{ $marca->municipio->nome }}
                                    </h4>
                                    <p class="text-[10px] text-gray-400 font-bold italic">{{ $marca->ano }}</p>

                                    <div class="mt-3">
                                        <a href="{{ route('marcas.show', $marca->id) }}"
                                            class="inline-block bg-gray-50 group-hover:bg-[#064e3b] group-hover:text-white text-gray-500 px-4 py-2 rounded-xl text-[9px] font-black uppercase transition-all tracking-widest">
                                            Ver Detalhes
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div
                            class="col-span-full py-16 bg-gray-50/50 rounded-[2.5rem] border-2 border-dashed border-gray-200 text-center">
                            <i data-lucide="award" class="w-10 h-10 text-gray-300 mx-auto mb-3 opacity-50"></i>
                            <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest">Nenhuma marca
                                vinculada</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @include('components.modal-confirm')
@endsection

@push('scripts')
    {{-- Importante: Certifique-se de que a biblioteca SignaturePad está no seu layout principal ou inclua aqui --}}
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Inicializa ícones Lucide (caso não estejam no layout)
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // Seleciona todos os canvases de marcas do produtor
            const canvases = document.querySelectorAll('.brand-canvas');

            canvases.forEach(canvas => {
                const rawData = canvas.getAttribute('data-vector');

                if (rawData && rawData !== 'null' && rawData !== '[]') {
                    try {
                        const data = JSON.parse(rawData);
                        const ctx = canvas.getContext('2d');

                        // Ajuste de DPI para não ficar embaçado no mobile/retina
                        const ratio = Math.max(window.devicePixelRatio || 1, 1);
                        canvas.width = canvas.offsetWidth * ratio;
                        canvas.height = canvas.offsetHeight * ratio;
                        ctx.scale(ratio, ratio);

                        // Inicializa o pad em modo apenas leitura (off)
                        const pad = new SignaturePad(canvas, {
                            minWidth: 1,
                            maxWidth: 2.5,
                            penColor: "#064e3b" // Cor verde escura do seu tema
                        });

                        // Lógica de Redimensionamento Automático (Fit)
                        const points = data.flatMap(group => group.points);
                        if (points.length > 0) {
                            // Encontra os limites do desenho
                            const minX = Math.min(...points.map(p => p.x));
                            const maxX = Math.max(...points.map(p => p.x));
                            const minY = Math.min(...points.map(p => p.y));
                            const maxY = Math.max(...points.map(p => p.y));

                            const drawingWidth = (maxX - minX) || 1;
                            const drawingHeight = (maxY - minY) || 1;

                            // Calcula escala para caber no mini-card com um respiro (padding de 15px)
                            const padding = 15;
                            const scale = Math.min(
                                (canvas.offsetWidth - padding) / drawingWidth,
                                (canvas.offsetHeight - padding) / drawingHeight,
                                1
                            );

                            // Centraliza o desenho no canvas
                            const offsetX = (canvas.offsetWidth - (drawingWidth * scale)) / 2 - (minX *
                                scale);
                            const offsetY = (canvas.offsetHeight - (drawingHeight * scale)) / 2 - (minY *
                                scale);

                            // Aplica a transformação nos pontos e carrega
                            const transformedData = data.map(group => ({
                                ...group,
                                points: group.points.map(p => ({
                                    x: (p.x * scale) + offsetX,
                                    y: (p.y * scale) + offsetY
                                }))
                            }));

                            pad.fromData(transformedData);
                        }

                        // Desativa a edição (estamos apenas visualizando)
                        pad.off();

                    } catch (e) {
                        console.error("Erro ao renderizar marca:", e);
                        // Opcional: colocar um ícone de erro ou placeholder no canvas
                    }
                } else {
                    // Caso não haja vetor, podemos desenhar um texto simples ou deixar vazio
                    const ctx = canvas.getContext('2d');
                    ctx.font = "10px Inter, sans-serif";
                    ctx.fillStyle = "#cbd5e1";
                    ctx.textAlign = "center";
                    ctx.fillText("SEM DESENHO", canvas.offsetWidth / 2, canvas.offsetHeight / 2);
                }
            });
        });
    </script>
@endpush
