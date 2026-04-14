@extends('layouts.app')
@section('title', 'Lista de Marcas')

@section('content')
    <div class="space-y-6 pb-10">
        <x-index-header title="Marcas" titleHighlight="" subtitle="Consulte registros na rede estadual" :routeCreate="route('marcas.create')"
            buttonLabel="Nova Marca" icon="award" model="App\Models\Marca" {{-- <--- Adicione isso --}} />

        {{-- Formulário de Filtros --}}
        <form action="/marcas" method="GET" id="search-form"
            class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-4 md:p-6 space-y-4">

            {{-- Tabs de Modo de Busca --}}
            <div class="flex items-center gap-2 p-1 bg-gray-50 rounded-[1.5rem]">
                <button type="button" id="btn-text-mode"
                    class="flex-1 text-[10px] font-black uppercase py-3 px-2 rounded-xl transition-all flex items-center justify-center gap-2 shadow-sm bg-white text-[#064e3b] border border-gray-100">
                    <i data-lucide="type" class="w-4 h-4"></i> Busca Textual
                </button>
                <button type="button" id="btn-visual-mode"
                    class="flex-1 text-[10px] font-black uppercase py-3 px-2 rounded-xl transition-all flex items-center justify-center gap-2 text-gray-400">
                    <i data-lucide="scan-eye" class="w-4 h-4"></i> Busca Visual
                </button>
            </div>

            {{-- Campos de Busca Visual --}}
            <div id="visual-fields" class="hidden space-y-3">
                <div class="flex justify-between items-center px-1">
                    <label class="text-[10px] font-black text-green-700 uppercase tracking-widest">Desenhe a Marca
                        abaixo:</label>
                    <button type="button" id="clear-search-canvas"
                        class="text-[10px] font-bold text-red-500 uppercase flex items-center gap-1 hover:bg-red-50 px-2 py-1 rounded-lg transition-colors">
                        <i data-lucide="eraser" class="w-3 h-3"></i> Limpar
                    </button>
                </div>
                <div class="relative bg-gray-50 border-2 border-dashed border-gray-200 rounded-[2rem] overflow-hidden">
                    <canvas id="search-canvas" class="w-full h-56 md:h-64 cursor-crosshair touch-none"></canvas>
                </div>
            </div>

            {{-- Campos de Busca Textual --}}
            <div id="text-fields" class="space-y-3">
                <div class="relative group">
                    <i data-lucide="search"
                        class="absolute left-4 top-4 w-5 h-5 text-gray-300 group-focus-within:text-[#064e3b] transition-colors"></i>
                    <input type="text" name="nome" value="{{ request('nome') }}"
                        placeholder="Nome do Produtor ou CPF/CNPJ..."
                        class="w-full bg-gray-50 border-transparent rounded-2xl py-4 pl-12 pr-4 text-sm focus:ring-2 focus:ring-[#064e3b] focus:bg-white transition-all">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <select name="municipio_id"
                        class="w-full bg-gray-50 border-transparent rounded-2xl py-4 px-4 text-sm focus:ring-2 focus:ring-[#064e3b] appearance-none">
                        <option value="">Todos Municípios</option>
                        @foreach ($municipios as $m)
                            <option value="{{ $m->id }}" {{ request('municipio_id') == $m->id ? 'selected' : '' }}>
                                {{ $m->nome }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="numero" value="{{ request('numero') }}" placeholder="Nº da Marca..."
                        class="w-full bg-gray-50 border-transparent rounded-2xl py-4 px-4 text-sm focus:ring-2 focus:ring-[#064e3b]">
                </div>
            </div>

            <input type="hidden" name="qtd_tracos" id="qtd_tracos_field" value="{{ request('qtd_tracos') }}">

            {{-- Botões de Ação do Form --}}
            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="flex-[4] bg-[#064e3b] hover:bg-green-700 text-white py-4 rounded-2xl font-black uppercase tracking-[0.2em] shadow-lg shadow-green-900/20 active:scale-[0.98] transition-all">
                    Filtrar
                </button>
                <a href="/marcas"
                    class="flex-1 bg-gray-100 text-gray-400 p-4 rounded-2xl flex items-center justify-center hover:bg-gray-200 transition-all shadow-inner">
                    <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                </a>
            </div>
        </form>

        {{-- Grid de Resultados --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 px-2">
            @forelse($marcas as $marca)
                @include('marcas._card')
            @empty
                <div
                    class="col-span-full text-center py-24 bg-white rounded-[3rem] border border-dashed border-gray-100 text-gray-300">
                    <i data-lucide="ghost" class="w-16 h-16 mx-auto mb-4 opacity-10"></i>
                    <p class="font-bold uppercase text-xs tracking-widest">Nenhum registro encontrado</p>
                </div>
            @endforelse
        </div>

        <div class="py-6 px-2">
            {{ $marcas->links() }}
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Re-inicializa ícones lucide
            if (window.lucide) lucide.createIcons();

            // --- CONTROLE DE MODO (TEXTO vs VISUAL) ---
            const btnText = document.getElementById('btn-text-mode');
            const btnVisual = document.getElementById('btn-visual-mode');
            const textFields = document.getElementById('text-fields');
            const visualFields = document.getElementById('visual-fields');
            const searchCanvas = document.getElementById('search-canvas');

            const activeClass =
                "flex-1 text-[10px] font-black uppercase py-3 px-2 rounded-xl transition-all flex items-center justify-center gap-2 shadow-sm bg-white text-[#064e3b] border border-gray-100";
            const inactiveClass =
                "flex-1 text-[10px] font-black uppercase py-3 px-2 rounded-xl transition-all flex items-center justify-center gap-2 text-gray-400";

            // Inicia SignaturePad para busca
            const searchPad = new SignaturePad(searchCanvas, {
                minWidth: 2,
                maxWidth: 4,
                penColor: "#000"
            });

            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                searchCanvas.width = searchCanvas.offsetWidth * ratio;
                searchCanvas.height = searchCanvas.offsetHeight * ratio;
                searchCanvas.getContext("2d").scale(ratio, ratio);
                searchPad.clear();
            }

            btnVisual.addEventListener('click', () => {
                textFields.classList.add('hidden');
                visualFields.classList.remove('hidden');
                btnVisual.className = activeClass;
                btnText.className = inactiveClass;
                setTimeout(resizeCanvas, 50);
            });

            btnText.addEventListener('click', () => {
                textFields.classList.remove('hidden');
                visualFields.classList.add('hidden');
                btnText.className = activeClass;
                btnVisual.className = inactiveClass;
                searchPad.clear();
            });

            document.getElementById('clear-search-canvas').addEventListener('click', () => searchPad.clear());

            // --- RENDERIZAÇÃO DOS CARDS ---
            const canvases = document.querySelectorAll('.brand-canvas');
            canvases.forEach(canvas => {
                const rawData = canvas.getAttribute('data-vector');
                if (rawData && rawData !== 'null') {
                    try {
                        const data = JSON.parse(rawData);
                        const ctx = canvas.getContext('2d');
                        const ratio = Math.max(window.devicePixelRatio || 1, 1);
                        canvas.width = canvas.offsetWidth * ratio;
                        canvas.height = canvas.offsetHeight * ratio;
                        ctx.scale(ratio, ratio);

                        const pad = new SignaturePad(canvas, {
                            penColor: "#064e3b"
                        });

                        // Normalização simples para caber no card
                        const points = data.flatMap(group => group.points);
                        if (points.length > 0) {
                            const minX = Math.min(...points.map(p => p.x)),
                                maxX = Math.max(...points.map(p => p.x));
                            const minY = Math.min(...points.map(p => p.y)),
                                maxY = Math.max(...points.map(p => p.y));
                            const bw = (maxX - minX) || 1,
                                bh = (maxY - minY) || 1;
                            const scale = Math.min((canvas.offsetWidth - 20) / bw, (canvas.offsetHeight -
                                20) / bh, 1);
                            const offX = (canvas.offsetWidth - (bw * scale)) / 2 - (minX * scale);
                            const offY = (canvas.offsetHeight - (bh * scale)) / 2 - (minY * scale);

                            pad.fromData(data.map(g => ({
                                ...g,
                                points: g.points.map(p => ({
                                    x: (p.x * scale) + offX,
                                    y: (p.y * scale) + offY
                                }))
                            })));
                        }
                        pad.off(); // Apenas visualização
                    } catch (e) {
                        console.error("Erro card:", e);
                    }
                }
            });

            // --- SUBMIT COM LÓGICA DE QUADRANTES ---
            document.getElementById('search-form').addEventListener('submit', function(e) {
                if (!searchPad.isEmpty()) {
                    const data = searchPad.toData();
                    const tracosReais = data.filter(t => t.points.length > 2);
                    const pontos = tracosReais.flatMap(t => t.points);

                    if (pontos.length > 0) {
                        const x = pontos.map(p => p.x),
                            y = pontos.map(p => p.y);
                        const minX = Math.min(...x),
                            maxX = Math.max(...x);
                        const minY = Math.min(...y),
                            maxY = Math.max(...y);
                        const w = (maxX - minX) || 1,
                            h = (maxY - minY) || 1;

                        let q = new Array(9).fill(0);
                        pontos.forEach(p => {
                            let col = Math.min(2, Math.floor(((p.x - minX) / w) * 3));
                            let lin = Math.min(2, Math.floor(((p.y - minY) / h) * 3));
                            q[(lin * 3) + col]++;
                        });

                        q.forEach((val, i) => {
                            setHiddenInput(this, `q${i+1}`, (val / pontos.length).toFixed(4));
                        });
                        setHiddenInput(this, 'qtd_tracos', tracosReais.length);
                    }
                }
            });

            function setHiddenInput(form, name, value) {
                let input = document.getElementById('search_' + name);
                if (!input) {
                    input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = name;
                    input.id = 'search_' + name;
                    form.appendChild(input);
                }
                input.value = value;
            }
        });
    </script>
@endpush
