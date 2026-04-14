@extends('layouts.app')
@section('title', isset($marca) ? 'Editar Marca' : 'Nova Marca')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <style>
        .ts-control {
            border: none !important;
            padding: 12px !important;
            border-radius: 1rem !important;
            background-color: #f9fafb !important;
        }

        .ts-dropdown {
            border-radius: 1rem !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
            border: none !important;
        }

        #canvas-editor-container {
            width: 100%;
            background-color: #f3f4f6;
            border-radius: 1.5rem;
            overflow: hidden;
            display: flex;
            justify-content: center;
            border: 2px solid #e5e7eb;
        }

        .canvas-container {
            margin: 0 auto !important;
        }

        /* Cursor de conta-gotas para o modo de remover cor */
        .eyedropper-mode .upper-canvas {
            cursor: cell !important;
            /* Ou use uma imagem de conta-gotas personalizada */
        }

        /* Estilo para sliders */
        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            border: 2px solid #fff;
            height: 16px;
            width: 16px;
            border-radius: 50%;
            background: currentColor;
            cursor: pointer;
            margin-top: -6px;
            /* centers thumb on webkit track */
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }

        /* Ajuste para Tom Select */
        .ts-control {
            border: none !important;
            padding: 12px !important;
            border-radius: 1rem !important;
            background-color: #f9fafb !important;
        }

        .ts-dropdown {
            border-radius: 1rem !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
            border: none !important;
        }

        /* Estilos Gerais do Editor */
        #canvas-editor-container {
            width: 100%;
            background-color: #f3f4f6;
            border-radius: 1.5rem;
            overflow: hidden;
            display: flex;
            justify-content: center;
            border: 2px solid #e5e7eb;
        }

        .canvas-container {
            margin: 0 auto !important;
        }

        /* Centraliza o fabric */

        /* Cursor de conta-gotas para o modo de remover cor */
        .eyedropper-mode .upper-canvas {
            cursor: cell !important;
        }

        /* --- CORREÇÃO DE CORES DO SLIDER --- */
        /* 1. Força o navegador a usar o tema claro para os inputs de alcance,
                              impedindo o 'dark mode' automático do sistema/navegador. */
        input[type=range] {
            color-scheme: light;
            -webkit-appearance: none;
            appearance: none;
            background: transparent;
        }

        /* 2. Estilo do 'polegar' (thumb) - a bolinha que se arrasta */
        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            border: 2px solid #fff;
            height: 18px;
            width: 18px;
            border-radius: 50%;
            /* VERDE ESCURO PADRÃO */
            background: #064e3b;
            cursor: pointer;
            margin-top: -6px;
            /* centraliza o thumb na trilha no webkit */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            transition: background-color 0.2s;
        }

        input[type=range]::-moz-range-thumb {
            border: 2px solid #fff;
            height: 18px;
            width: 18px;
            border-radius: 50%;
            /* VERDE ESCURO PADRÃO */
            background: #064e3b;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        /* 3. Estilo da 'trilha' (track) - a linha de fundo */
        input[type=range]::-webkit-slider-runnable-track {
            width: 100%;
            height: 6px;
            background: #e5e7eb;
            /* cor cinza claro da trilha */
            border-radius: 3px;
        }

        input[type=range]::-moz-range-track {
            width: 100%;
            height: 6px;
            background: #e5e7eb;
            border-radius: 3px;
        }
    </style>
@endpush

@section('content')
    <div class="container mx-auto max-w-4xl pb-20">
        {{-- Header --}}
        <div class="flex items-center gap-4 px-4 mb-6">
            <a href="javascript:history.back()" class="bg-white p-3 rounded-2xl shadow-sm border border-gray-100">
                <i data-lucide="chevron-left" class="w-6 h-6 text-gray-600"></i>
            </a>
            <div>
                <h1 class="text-2xl font-black text-gray-900 uppercase italic leading-none">
                    {{ isset($marca) ? 'Editar Registro' : 'Novo Registro' }}
                </h1>
            </div>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-2xl shadow-sm mx-4 mb-4">
                <h3 class="text-sm font-black text-red-800 uppercase italic">Verifique os erros abaixo:</h3>
                <ul class="text-xs text-red-600 font-bold uppercase italic mt-1 list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ isset($marca) ? route('marcas.update', $marca->id) : route('marcas.store') }}" method="POST"
            enctype="multipart/form-data" id="form-registro" class="space-y-6 mx-4 md:mx-0">
            @csrf
            @if (isset($marca))
                @method('PUT')
            @endif

            {{-- CARD 1: JURISDIÇÃO --}}
            <div class="bg-white rounded-[2.5rem] p-6 border border-gray-100 shadow-sm">
                <h2 class="text-[#064e3b] font-black text-xs uppercase tracking-[0.2em] mb-4 flex items-center gap-2">
                    <i data-lucide="map-pin" class="w-4 h-4"></i> Jurisdição do Registro
                </h2>
                <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Município Sede</label>
                    <select disabled
                        class="w-full bg-transparent border-none p-0 text-sm font-black text-gray-700 appearance-none">
                        @foreach ($municipios as $m)
                            <option value="{{ $m->id }}"
                                {{ old('municipio_id', $marca->municipio_id ?? ($municipioGestor->id ?? '')) == $m->id ? 'selected' : '' }}>
                                {{ $m->nome }} / {{ $m->uf }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="municipio_id"
                        value="{{ old('municipio_id', $marca->municipio_id ?? ($municipioGestor->id ?? '')) }}">
                </div>
            </div>

            {{-- CARD 2: PROPRIETÁRIO --}}
            <div class="bg-white rounded-[2.5rem] p-6 border border-gray-100 shadow-sm">
                <h2 class="text-[#064e3b] font-black text-xs uppercase tracking-[0.2em] mb-4 flex items-center gap-2">
                    <i data-lucide="crown" class="w-4 h-4"></i> Proprietário Titular
                </h2>
                <select id="select-titular" name="produtor_id" placeholder="Busque por nome ou CPF..." required></select>
            </div>

            {{-- CARD 3: SOCIEDADE --}}
            <div class="bg-white rounded-[2.5rem] p-6 border border-gray-100 shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-[#064e3b] font-black text-xs uppercase tracking-[0.2em] flex items-center gap-2">
                        <i data-lucide="users" class="w-4 h-4"></i> Composição de Sociedade
                    </h2>
                    <span
                        class="text-[9px] font-black bg-gray-100 text-gray-400 px-2 py-1 rounded-full uppercase">Opcional</span>
                </div>
                <select id="select-socios" name="socios[]" multiple placeholder="Selecione os sócios..."></select>
            </div>

            {{-- CARD 4: IDENTIDADE VISUAL --}}
            <div class="bg-white rounded-[2.5rem] p-6 border border-gray-100 shadow-sm">
                <h2 class="text-[#064e3b] font-black text-xs uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                    <i data-lucide="award" class="w-4 h-4"></i> Identidade Visual
                </h2>

                <div class="space-y-8">
                    {{-- SEÇÃO DE DADOS: Número e Ano --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase ml-1">Nº Registro</label>
                            <input type="number" name="numero" value="{{ old('numero', $marca->numero ?? '') }}"
                                class="w-full bg-gray-50 border-none rounded-2xl py-4 px-4 text-lg font-black focus:ring-2 focus:ring-[#064e3b]/20">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase ml-1">Ano</label>
                            <input type="number" name="ano" value="{{ old('ano', $marca->ano ?? date('Y')) }}"
                                class="w-full bg-gray-50 border-none rounded-2xl py-4 px-4 text-lg font-black focus:ring-2 focus:ring-[#064e3b]/20">
                        </div>
                    </div>

                    <hr class="border-gray-50">

                    {{-- GRID PRINCIPAL --}}
                    <div class="grid grid-cols-1 gap-10">

                        {{-- 1. CONTAINER DA FOTO (EDITOR) --}}
                        <div class="space-y-4">
                            <div class="flex justify-between items-center px-2">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Foto de Campo
                                    / Processamento</label>
                                <button type="button" id="btn-cancel-foto"
                                    class="text-[9px] font-bold text-red-500 uppercase underline">Trocar Foto</button>
                            </div>

                            <input type="file" id="foto-input" class="hidden" accept="image/*">
                            <input type="hidden" name="foto_final" id="foto_final">

                            {{-- Area de Drop --}}
                            <label for="foto-input" id="drop-area"
                                class="flex flex-col items-center justify-center gap-3 bg-gray-50 border-2 border-dashed border-gray-200 rounded-[2rem] p-12 cursor-pointer hover:border-[#064e3b] hover:bg-gray-100/50 transition-all min-h-[300px]">
                                <div id="label-content" class="text-center">
                                    <div
                                        class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-sm mx-auto mb-4">
                                        <i data-lucide="camera" class="w-8 h-8 text-[#064e3b]"></i>
                                    </div>
                                    <span class="text-xs text-gray-500 font-black uppercase block">Tirar Foto ou Anexar
                                        Imagem</span>
                                    <p class="text-[10px] text-gray-400 mt-1">Clique para abrir a câmera ou arraste o
                                        arquivo</p>
                                </div>
                            </label>

                            {{-- Editor Canvas (Aparece após upload) --}}
                            <div id="editor-container-wrapper" class="hidden space-y-3">
                                {{-- Barra de Ferramentas Atualizada --}}
                                <div
                                    class="bg-gray-100 p-2 rounded-2xl border border-gray-200 flex items-center justify-between gap-1 relative z-20">
                                    <div class="flex items-center gap-1">
                                        {{-- 1. RECORTE (Padrão) --}}
                                        <button type="button" id="btn-mode-crop"
                                            title="Ferramenta de Recorte: Selecione a área e confirme no botão laranja"
                                            class="p-2.5 rounded-xl bg-white text-gray-600 border border-gray-200 hover:bg-[#064e3b]/10 transition-colors">
                                            <i data-lucide="crop" class="w-4 h-4"></i>
                                        </button>
                                        {{-- 2. REMOVER COR DE FUNDO (Uniformizado para verde escuro) --}}
                                        <button type="button" id="btn-mode-remove-color"
                                            title="Remover Cor: Clique em uma cor na imagem para torná-la branca"
                                            class="p-2.5 rounded-xl bg-white text-gray-600 border border-gray-200 hover:bg-[#064e3b]/10 transition-colors">
                                            <i data-lucide="droplet" class="w-4 h-4"></i>
                                        </button>
                                        {{-- 3. BORRACHA --}}
                                        <button type="button" id="btn-mode-erase"
                                            title="Borracha: Pinte de branco para apagar detalhes indesejados"
                                            class="p-2.5 rounded-xl bg-white text-gray-600 border border-gray-200 hover:bg-[#064e3b]/10 transition-colors">
                                            <i data-lucide="eraser" class="w-4 h-4"></i>
                                        </button>
                                        {{-- 4. MOVER/AJUSTAR --}}
                                        <button type="button" id="btn-mode-move"
                                            title="Ajuste Livre: Mover e redimensionar a imagem no canvas"
                                            class="p-2.5 rounded-xl bg-white text-gray-600 border border-gray-200 hover:bg-[#064e3b]/10 transition-colors">
                                            <i data-lucide="move" class="w-4 h-4"></i>
                                        </button>

                                        <div class="w-[1px] h-6 bg-gray-300 mx-1"></div>

                                        {{-- 5. DESFAZER --}}
                                        <button type="button" id="btn-undo" title="Desfazer (Ctrl+Z)"
                                            class="p-2.5 rounded-xl bg-white text-gray-300 border border-gray-200 transition-all">
                                            <i data-lucide="undo-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                    <button type="button" id="btn-cancel-foto"
                                        class="text-[9px] font-bold text-red-500 uppercase underline px-2">Trocar
                                        Foto</button>
                                </div>

                                {{-- Canvas com Hint de Status --}}
                                <div id="canvas-editor-container"
                                    class="border-2 border-gray-200 rounded-2xl overflow-hidden shadow-inner bg-white relative">
                                    {{-- Mensagem de Status Reposicionada para baixo --}}
                                    <div id="editor-status-hint"
                                        class="absolute bottom-16 left-1/2 -translate-x-1/2 z-30 bg-black/80 text-white text-[9px] px-4 py-1.5 rounded-full font-black uppercase tracking-widest pointer-events-none opacity-0 transition-opacity whitespace-nowrap">
                                        Modo Recorte Ativo
                                    </div>

                                    <canvas id="fabric-canvas"></canvas>

                                    <button type="button" id="btn-do-crop"
                                        class="hidden absolute bottom-3 right-3 bg-orange-600 text-white font-black text-[10px] uppercase px-5 py-2.5 rounded-full shadow-xl flex items-center gap-2 z-40 hover:scale-105 active:scale-95 transition-all">
                                        <i data-lucide="check" class="w-4 h-4"></i> Confirmar Corte
                                    </button>
                                </div>

                                {{-- Painel de Sliders (Contraste e Tolerância) --}}
                                <div class="bg-gray-50 p-3 rounded-2xl border border-gray-100 space-y-3">
                                    {{-- Slider de Limpeza (Contraste) --}}
                                    <div>
                                        <label
                                            class="flex justify-between text-[9px] font-black text-gray-400 uppercase mb-2">
                                            <span>Branquear Fundo (Limpeza Total)</span>
                                            <span id="threshold-value" class="text-[#064e3b]">0%</span>
                                        </label>
                                        {{-- A cor de destaque (thumb) é controlada pelo CSS acima, mas mantemos accent-[#064e3b] para compatibilidade Tailwind --}}
                                        <input type="range" id="threshold-slider" min="-1" max="1"
                                            step="0.1" value="0"
                                            class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-[#064e3b]">
                                    </div>

                                    {{-- Slider de Tolerância de Cor (Uniformizado para verde escuro) --}}
                                    {{-- Removi 'bg-purple-50' e 'border-purple-100' --}}
                                    <div id="tolerance-slider-wrapper" class="hidden border-t border-gray-100 pt-3">
                                        {{-- Removi 'text-purple-600', adicionei 'text-[#064e3b]' --}}
                                        <label
                                            class="flex justify-between text-[9px] font-black text-[#064e3b] uppercase mb-2">
                                            <span>Tolerância da Cor Removida</span>
                                            <span id="tolerance-value" class="text-[#064e3b]">20%</span>
                                        </label>
                                        {{-- Removi 'accent-purple-600', adicionei 'accent-[#064e3b]' --}}
                                        <input type="range" id="tolerance-slider" min="0" max="1"
                                            step="0.01" value="0.2"
                                            class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-[#064e3b]">
                                        <p class="text-[8px] text-gray-400 italic mt-1 uppercase">Aumente se a cor não
                                            sumir totalmente, diminua se comer partes da marca.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 2. PAINEL DE DESENHO (MARCA VETOR) --}}
                        <div class="space-y-4 pt-4">
                            <div class="flex justify-between items-center px-2">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Painel de
                                    Desenho (Manual)</label>
                                <button type="button" id="clear"
                                    class="text-[10px] font-black text-red-500 uppercase hover:underline">Limpar
                                    Desenho</button>
                            </div>
                            <div id="canvas-container"
                                class="relative bg-white border-4 border-gray-50 rounded-[2.5rem] shadow-inner overflow-hidden ring-1 ring-gray-100">
                                <canvas id="canvas-marca" class="w-full h-80 cursor-crosshair touch-none"></canvas>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <input type="hidden" name="desenho_vetor" id="desenho_vetor"
                value="{{ old('desenho_vetor', $marca->desenho_vetor ?? '') }}">

            <div class="pt-6">
                <button type="submit"
                    class="w-full bg-[#064e3b] hover:bg-black text-white py-6 rounded-3xl font-black uppercase italic tracking-[0.2em] shadow-xl transition-all flex items-center justify-center gap-3">
                    <i data-lucide="save" class="w-6 h-6"></i>
                    {{ isset($marca) ? 'Atualizar Registro' : 'Salvar na Rede Gado Seguro' }}
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.1/fabric.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof lucide !== 'undefined') lucide.createIcons();

            // --- 1. ELEMENTOS DO DOM ---
            const inputFoto = document.getElementById('foto-input');
            const dropArea = document.getElementById('drop-area');
            const editorWrapper = document.getElementById('editor-container-wrapper');
            const btnCancelFoto = document.getElementById('btn-cancel-foto');
            const thresholdSlider = document.getElementById('threshold-slider');
            const thresholdValue = document.getElementById('threshold-value');

            // Novos elementos para remoção de cor
            const toleranceSliderWrapper = document.getElementById('tolerance-slider-wrapper');
            const toleranceSlider = document.getElementById('tolerance-slider');
            const toleranceValue = document.getElementById('tolerance-value');
            const canvasContainerDiv = document.getElementById('canvas-editor-container');

            // Botões de Ferramentas
            const btnModeMove = document.getElementById('btn-mode-move');
            const btnModeCrop = document.getElementById('btn-mode-crop');
            const btnModeErase = document.getElementById('btn-mode-erase');
            const btnModeRemoveColor = document.getElementById('btn-mode-remove-color');
            const btnDoCrop = document.getElementById('btn-do-crop');
            const btnUndo = document.getElementById('btn-undo');
            const statusHint = document.getElementById('editor-status-hint');

            // --- 2. VARIÁVEIS DE ESTADO ---
            let fCanvas = null;
            let imgObject = null;
            let cropRect = null;
            let history = [];
            let currentColorKey = null; // Guarda a cor selecionada para remover

            // --- 3. TOM SELECT & SIGNATURE PAD (MANTIDO) ---
            const configSelect = {
                valueField: 'id',
                labelField: 'nome',
                searchField: ['nome', 'cpf_cnpj'],
                loadThrottle: 400,
                closeAfterSelect: true,
                load: function(query, callback) {
                    if (!query.length) return callback();
                    fetch("{{ route('produtores.buscar') }}?q=" + encodeURIComponent(query))
                        .then(r => r.json()).then(j => callback(j)).catch(() => callback());
                },
                render: {
                    option: (i, e) =>
                        `<div class="p-3 border-b border-gray-50"><div class="text-xs font-black uppercase text-gray-700">${e(i.nome)}</div><div class="text-[9px] font-mono text-gray-400">${e(i.cpf_cnpj)}</div></div>`,
                    item: (i, e) =>
                        `<div class="text-xs font-black uppercase text-[#064e3b]">${e(i.nome)}</div>`
                }
            };
            new TomSelect('#select-titular', configSelect);
            new TomSelect('#select-socios', {
                ...configSelect,
                maxItems: null
            });

            const canvasPad = document.getElementById('canvas-marca');
            const signaturePad = new SignaturePad(canvasPad, {
                minWidth: 2.5,
                maxWidth: 5,
                penColor: "#000"
            });

            function setupSignature() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvasPad.width = canvasPad.offsetWidth * ratio;
                canvasPad.height = canvasPad.offsetHeight * ratio;
                canvasPad.getContext("2d").scale(ratio, ratio);
                const rawData = `{!! old('desenho_vetor', $marca->desenho_vetor ?? '') !!}`;
                if (rawData.length > 5) signaturePad.fromData(JSON.parse(rawData));
            }
            window.addEventListener('resize', setupSignature);
            setTimeout(setupSignature, 300);
            document.getElementById('clear').addEventListener('click', () => signaturePad.clear());

            // --- 3. SISTEMA DE HISTÓRICO (UNDO) ---
            function saveHistory() {
                if (!fCanvas) return;
                history.push(JSON.stringify(fCanvas));
                if (history.length > 15) history.shift();
                if (history.length > 1) {
                    btnUndo.classList.remove('text-gray-300', 'border-gray-200');
                    btnUndo.classList.add('text-red-600', 'border-red-200', 'hover:bg-red-50');
                }
            }

            function undo() {
                if (history.length <= 1) return;
                history.pop();
                const prevState = history[history.length - 1];
                fCanvas.loadFromJSON(prevState, () => {
                    fCanvas.renderAll();
                    imgObject = fCanvas.getObjects('image')[0];
                    if (history.length <= 1) {
                        btnUndo.classList.add('text-gray-300', 'border-gray-200');
                        btnUndo.classList.remove('text-red-600', 'border-red-200');
                    }
                    showStatus("Desfeito", "bg-gray-800");
                });
            }

            // --- 4. GESTÃO DE MENSAGENS NA TELA (HINTS) ---
            let statusTimeout;

            function showStatus(text, type = 'default') {
                clearTimeout(statusTimeout);
                statusHint.innerText = text;

                // Define a cor de fundo baseada no contexto, mas sempre dentro da paleta verde/preta
                let bgColor = 'bg-black/80';
                if (type === 'success') bgColor = 'bg-[#064e3b]';

                statusHint.className =
                    `absolute bottom-16 left-1/2 -translate-x-1/2 z-30 text-white text-[9px] px-4 py-1.5 rounded-full font-black uppercase tracking-widest pointer-events-none transition-opacity ${bgColor} opacity-100 whitespace-nowrap`;

                statusTimeout = setTimeout(() => statusHint.classList.remove('opacity-100'), 2500);
            }

            // --- 5. LÓGICA DE REMOÇÃO DE COR (BALDE DE TINTA/CHROMA KEY) ---

            function applyRemoveColorFilter(color, tolerance) {
                if (!imgObject) return;

                // Remove filtro antigo se houver
                imgObject.filters = imgObject.filters.filter(f => f.type !== 'RemoveColor');

                if (color) {
                    imgObject.filters.push(new fabric.Image.filters.RemoveColor({
                        color: color,
                        distance: tolerance // Tolerância (0 a 1)
                    }));
                }

                imgObject.applyFilters();
                fCanvas.renderAll();
            }

            // Captura o clique no canvas para pegar a cor
            function handleCanvasClickForColor(options) {
                if (!fCanvas.isDrawingMode && canvasContainerDiv.classList.contains('eyedropper-mode')) {
                    const ptr = fCanvas.getPointer(options.e);
                    const ctx = fCanvas.getContext();
                    // Pega os dados do pixel clicado
                    const pix = ctx.getImageData(ptr.x, ptr.y, 1, 1).data;
                    // Converte para Hexadecimal
                    const hex = "#" + ("000000" + rgbToHex(pix[0], pix[1], pix[2])).slice(-6);

                    currentColorKey = hex;
                    const tolerance = parseFloat(toleranceSlider.value);

                    applyRemoveColorFilter(currentColorKey, tolerance);
                    showStatus(`Cor ${hex} removida. Ajuste a tolerância se necessário.`, "bg-purple-600");
                    saveHistory();

                    // Opcional: Voltar para o modo mover após clicar
                    // setMode('move');
                }
            }

            function rgbToHex(r, g, b) {
                if (r > 255 || g > 255 || b > 255) throw "Invalid color component";
                return ((r << 16) | (g << 8) | b).toString(16);
            }

            // --- 6. CONTROLE DE FERRAMENTAS (MODOS) ---
            function setMode(mode) {
                if (!fCanvas || !imgObject) return;

                fCanvas.isDrawingMode = false;
                fCanvas.selection = false;
                fCanvas.off('mouse:down', handleCanvasClickForColor);
                canvasContainerDiv.classList.remove('eyedropper-mode');
                imgObject.selectable = false;
                btnDoCrop.classList.add('hidden');
                toleranceSliderWrapper.classList.add('hidden');

                if (cropRect) {
                    fCanvas.remove(cropRect);
                    cropRect = null;
                }

                // Reset UI Botões (Todos voltam para o cinza)
                [btnModeMove, btnModeCrop, btnModeErase, btnModeRemoveColor].forEach(b => {
                    b.classList.remove('bg-[#064e3b]', 'text-white', 'border-[#064e3b]');
                    b.classList.add('bg-white', 'text-gray-600');
                });

                // Aplica o Verde Escuro no botão ativo
                const activeBtn = {
                    'crop': btnModeCrop,
                    'removeColor': btnModeRemoveColor,
                    'erase': btnModeErase,
                    'move': btnModeMove
                } [mode];

                if (activeBtn) {
                    activeBtn.classList.remove('bg-white', 'text-gray-600');
                    activeBtn.classList.add('bg-[#064e3b]', 'text-white', 'border-[#064e3b]');
                }

                switch (mode) {
                    case 'crop':
                        btnDoCrop.classList.remove('hidden');
                        btnDoCrop.classList.replace('bg-orange-600', 'bg-[#064e3b]'); // Troca laranja por verde
                        initCrop();
                        showStatus("Ajuste a área de corte");
                        break;
                    case 'removeColor':
                        canvasContainerDiv.classList.add('eyedropper-mode');
                        toleranceSliderWrapper.classList.remove('hidden');
                        fCanvas.on('mouse:down', handleCanvasClickForColor);
                        showStatus("Clique na cor para remover", "success");
                        break;
                    case 'erase':
                        fCanvas.isDrawingMode = true;
                        showStatus("Borracha Ativa");
                        break;
                    case 'move':
                        imgObject.selectable = true;
                        fCanvas.setActiveObject(imgObject);
                        showStatus("Ajuste de Posição");
                        break;
                }
                fCanvas.renderAll();
            }

            // --- 7. INICIALIZAÇÃO ---
            function initFabric(imgSrc) {
                history = [];
                dropArea.classList.add('hidden');
                editorWrapper.classList.remove('hidden');
                if (fCanvas) fCanvas.dispose();

                fCanvas = new fabric.Canvas('fabric-canvas', {
                    width: document.getElementById('canvas-editor-container').clientWidth,
                    height: 320,
                    backgroundColor: '#fff',
                    preserveObjectStacking: true,
                    selection: false // Desativa seleção múltipla padrão
                });

                // Config Borracha
                fCanvas.freeDrawingBrush = new fabric.PencilBrush(fCanvas);
                fCanvas.freeDrawingBrush.width = 25;
                fCanvas.freeDrawingBrush.color = '#ffffff';

                fabric.Image.fromURL(imgSrc, function(img) {
                    imgObject = img;
                    const scale = Math.min(fCanvas.width / img.width, fCanvas.height / img.height);
                    img.set({
                        scaleX: scale,
                        scaleY: scale,
                        left: (fCanvas.width - (img.width * scale)) / 2,
                        top: (fCanvas.height - (img.height * scale)) / 2,
                        cornerColor: '#064e3b',
                        cornerSize: 10,
                        transparentCorners: false,
                        selectable: false,
                        hasControls: true,
                        hasBorders: true
                    });
                    fCanvas.add(img);

                    // Importante: Para o filtro de remoção de cor funcionar bem,
                    // a imagem não pode estar 'cached' de forma agressiva
                    imgObject.set('objectCaching', false);

                    saveHistory();
                    setMode('crop'); // PADRÃO INICIAL: RECORTE
                });

                // Listeners para histórico automático
                fCanvas.on('object:modified', saveHistory);
                fCanvas.on('path:created', saveHistory);
            }

            // --- EVENTOS ---
            btnModeMove.addEventListener('click', () => setMode('move'));
            btnModeErase.addEventListener('click', () => setMode('erase'));
            btnModeCrop.addEventListener('click', () => setMode('crop'));
            btnModeRemoveColor.addEventListener('click', () => setMode('removeColor'));
            btnUndo.addEventListener('click', undo);

            // Lógica de tolerância da cor
            toleranceSlider.addEventListener('input', function() {
                if (!imgObject || !currentColorKey) return;
                const tol = parseFloat(this.value);
                toleranceValue.innerText = Math.round(tol * 100) + "%";
                applyRemoveColorFilter(currentColorKey, tol);
            });
            toleranceSlider.addEventListener('change', saveHistory); // Salva no histórico ao soltar

            // ... Restante da lógica de Crop, Contraste e Submit mantida ...
            // (Certifique-se de incluir a função initCrop() e os listeners btnDoCrop, thresholdSlider e form submit do seu código anterior)

            // --- RE-INCLUINDO LÓGICA DE CROP E SUBMIT (Para garantir que não falte nada) ---
            function initCrop() {
                cropRect = new fabric.Rect({
                    fill: 'rgba(0,0,0,0.3)',
                    stroke: '#ea580c',
                    strokeWidth: 2,
                    strokeDashArray: [5, 5],
                    width: fCanvas.width / 1.5,
                    height: fCanvas.height / 1.5,
                    left: fCanvas.width / 6,
                    top: fCanvas.height / 6,
                    cornerColor: '#ea580c',
                    cornerSize: 12,
                    transparentCorners: false,
                    hasRotatingPoint: false
                });
                fCanvas.add(cropRect);
                fCanvas.setActiveObject(cropRect);
            }

            btnDoCrop.addEventListener('click', function() {
                if (!fCanvas || !imgObject || !cropRect) return;

                // Mostra feedback visual de processamento
                showStatus("Processando Corte...", "success");

                const el = imgObject.getElement();
                const scaleX = imgObject.scaleX;
                const scaleY = imgObject.scaleY;
                const left = (cropRect.left - imgObject.left) / scaleX;
                const top = (cropRect.top - imgObject.top) / scaleY;
                const width = (cropRect.width * cropRect.scaleX) / scaleX;
                const height = (cropRect.height * cropRect.scaleY) / scaleY;

                const tempCanvas = document.createElement('canvas');
                tempCanvas.width = width;
                tempCanvas.height = height;
                tempCanvas.getContext('2d').drawImage(el, left, top, width, height, 0, 0, width, height);

                fabric.Image.fromURL(tempCanvas.toDataURL(), function(croppedImg) {
                    fCanvas.remove(imgObject);
                    imgObject = croppedImg;
                    imgObject.set('objectCaching', false); // Manter caching desativado para filtros

                    const scale = Math.min(fCanvas.width / croppedImg.width, fCanvas.height /
                        croppedImg.height);
                    imgObject.set({
                        scaleX: scale,
                        scaleY: scale,
                        left: (fCanvas.width - (croppedImg.width * scale)) / 2,
                        top: (fCanvas.height - (croppedImg.height * scale)) / 2,
                        selectable: false
                    });
                    fCanvas.add(imgObject);

                    saveHistory(); // Salva estado após o corte

                    // --- ALTERAÇÃO AQUI: FLUXO GUIADO ---
                    // Em vez de voltar para o modo 'move' (ajuste livre),
                    // ativamos automaticamente o modo 'removeColor' (Gota).
                    setMode('removeColor');

                    // Exibe mensagem específica para o próximo passo
                    showStatus("Corte aplicado. Agora, clique na cor do fundo para remover.",
                        "success");
                });
            });

            thresholdSlider.addEventListener('change', saveHistory);
            thresholdSlider.addEventListener('input', function() {
                if (!imgObject) return;
                const val = parseFloat(this.value);
                thresholdValue.innerText = Math.round((val + 1) * 50) + "%";
                // Mantém os filtros existentes (como o RemoveColor) e ajusta Brilho/Contraste
                const currentFilters = imgObject.filters.filter(f => f.type !== 'Contrast' && f.type !==
                    'Brightness');
                imgObject.filters = currentFilters;
                imgObject.filters.push(
                    new fabric.Image.filters.Contrast({
                        contrast: val
                    }),
                    new fabric.Image.filters.Brightness({
                        brightness: val > 0 ? val / 2 : 0
                    })
                );
                imgObject.applyFilters();
                fCanvas.renderAll();
            });

            inputFoto.addEventListener('change', function(e) {
                if (e.target.files && e.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = (f) => initFabric(f.target.result);
                    reader.readAsDataURL(e.target.files[0]);
                }
            });

            btnCancelFoto.addEventListener('click', () => {
                editorWrapper.classList.add('hidden');
                dropArea.classList.remove('hidden');
                inputFoto.value = '';
                if (fCanvas) fCanvas.dispose();
                fCanvas = null;
                imgObject = null;
                history = [];
            });

            document.getElementById('form-registro').addEventListener('submit', function(e) {
                // MANTIDO: Validação TomSelect do Proprietário (Seu código original)
                if (!document.getElementById('select-titular').value) {
                    e.preventDefault();
                    alert("⚠️ Selecione o Proprietário Titular.");
                    return;
                }

                // MANTIDO: Validação SignaturePad (Seu código original)
                const canvasPad = document.getElementById('canvas-marca');
                // Nota: Certifique-se de que 'signaturePad' está acessível aqui. 
                // Se necessário, declare-o no escopo global do DOMContentLoaded.
                if (typeof signaturePad !== 'undefined' && signaturePad.isEmpty()) {
                    e.preventDefault();
                    alert("⚠️ Desenhe a marca no painel de desenho.");
                    return;
                }
                if (typeof signaturePad !== 'undefined') {
                    document.getElementById('desenho_vetor').value = JSON.stringify(signaturePad.toData());
                }

                // SALVAMENTO DA FOTO DO EDITOR
                if (fCanvas && !editorWrapper.classList.contains('hidden')) {
                    if (cropRect) fCanvas.remove(cropRect);
                    // Exporta como JPEG para garantir fundo branco (não transparente)
                    document.getElementById('foto_final').value = fCanvas.toDataURL({
                        format: 'jpeg',
                        quality: 0.8,
                        multiplier: 2
                    });
                }
            });

            // Envio do Form
            document.getElementById('form-registro').addEventListener('submit', function(e) {
                if (signaturePad.isEmpty()) {
                    e.preventDefault();
                    alert("⚠️ Desenhe a marca no painel de desenho.");
                    return;
                }
                document.getElementById('desenho_vetor').value = JSON.stringify(signaturePad.toData());

                if (fCanvas && !editorWrapper.classList.contains('hidden')) {
                    if (cropRect) fCanvas.remove(cropRect);
                    document.getElementById('foto_final').value = fCanvas.toDataURL({
                        format: 'jpeg',
                        quality: 0.8,
                        multiplier: 2
                    });
                }
            });
        });
    </script>
@endpush
