@extends('layouts.app')
@section('title', isset($marca) ? 'Editar Marca' : 'Nova Marca')

{{-- Importante: CSS e JS do Tom Select --}}
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <style>
        /* Ajuste para combinar com seu design arredondado */
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
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-2xl shadow-sm">
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

            {{-- CARD 2: PROPRIETÁRIO TITULAR (BUSCA ASSÍNCRONA) --}}
            <div class="bg-white rounded-[2.5rem] p-6 border border-gray-100 shadow-sm">
                <h2 class="text-[#064e3b] font-black text-xs uppercase tracking-[0.2em] mb-4 flex items-center gap-2">
                    <i data-lucide="crown" class="w-4 h-4"></i> Proprietário Titular
                </h2>
                <div class="space-y-1">
                    <select id="select-titular" name="produtor_id" placeholder="Busque por nome ou CPF..."
                        required></select>
                </div>
            </div>

            {{-- CARD 3: SOCIEDADE (BUSCA ASSÍNCRONA MÚLTIPLA) --}}
            <div class="bg-white rounded-[2.5rem] p-6 border border-gray-100 shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-[#064e3b] font-black text-xs uppercase tracking-[0.2em] flex items-center gap-2">
                        <i data-lucide="users" class="w-4 h-4"></i> Composição de Sociedade
                    </h2>
                    <span
                        class="text-[9px] font-black bg-gray-100 text-gray-400 px-2 py-1 rounded-full uppercase">Opcional</span>
                </div>
                <div class="space-y-1">
                    <select id="select-socios" name="socios[]" multiple placeholder="Selecione os sócios..."></select>
                </div>
            </div>

            {{-- CARD 4: IDENTIDADE VISUAL --}}
            <div class="bg-white rounded-[2.5rem] p-6 border border-gray-100 shadow-sm">
                <h2 class="text-[#064e3b] font-black text-xs uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                    <i data-lucide="award" class="w-4 h-4"></i> Identidade Visual
                </h2>

                <div class="grid md:grid-cols-3 gap-8">
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase ml-1">Nº Registro</label>
                                <input type="number" name="numero" value="{{ old('numero', $marca->numero ?? '') }}"
                                    class="w-full bg-gray-50 border-none rounded-2xl py-4 px-4 text-lg font-black focus:ring-2 focus:ring-[#064e3b]">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase ml-1">Ano</label>
                                <input type="number" name="ano" value="{{ old('ano', $marca->ano ?? date('Y')) }}"
                                    class="w-full bg-gray-50 border-none rounded-2xl py-4 px-4 text-lg font-black focus:ring-2 focus:ring-[#064e3b]">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase mb-2 ml-1">Foto de
                                Campo</label>
                            <input type="file" name="foto" id="foto-input" class="hidden">
                            <label for="foto-input"
                                class="flex items-center justify-center gap-2 bg-gray-50 border-2 border-dashed border-gray-200 rounded-2xl p-6 cursor-pointer hover:border-[#064e3b] transition-all">
                                <i data-lucide="camera" class="w-6 h-6 text-gray-400"></i>
                                <span id="foto-label"
                                    class="text-[10px] text-gray-400 font-black uppercase tracking-tighter">Anexar</span>
                            </label>
                        </div>
                    </div>

                    <div class="md:col-span-2 space-y-4">
                        <div class="flex justify-between items-center px-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Painel de
                                Desenho</label>
                            <button type="button" id="clear"
                                class="text-[10px] font-black text-red-500 uppercase">Limpar</button>
                        </div>
                        <div id="canvas-container"
                            class="relative bg-white border-4 border-gray-50 rounded-[2rem] shadow-inner overflow-hidden">
                            <canvas id="canvas-marca" class="w-full h-64 cursor-crosshair touch-none"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" name="desenho_vetor" id="desenho_vetor"
                value="{{ old('desenho_vetor', $marca->desenho_vetor ?? '') }}">

            <div class="pt-6">
                <button type="submit"
                    class="w-full bg-[#064e3b] hover:bg-black text-white py-6 rounded-3xl font-black uppercase italic tracking-[0.2em] shadow-xl transition-all active:scale-95 flex items-center justify-center gap-3">
                    <i data-lucide="save" class="w-6 h-6"></i>
                    {{ isset($marca) ? 'Atualizar Registro' : 'Salvar na Rede Gado Seguro' }}
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
    {{-- Garanta que o Tom Select seja carregado antes do seu script se não estiver no head --}}
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const configSelect = {
                valueField: 'id',
                labelField: 'nome',
                searchField: ['nome', 'cpf_cnpj'],

                // 1. Desativa o cache interno para sempre pedir dados novos
                loadThrottle: 400,
                closeAfterSelect: true,

                // 2. Esta função limpa as opções antigas toda vez que uma busca termina
                onSearchCompleted: function(query, results) {
                    // Remove do menu o que não faz parte do resultado atual da busca
                    const self = this;
                    Object.keys(self.options).forEach((key) => {
                        // Mantém apenas o que está selecionado no momento, o resto apaga
                        if (self.items.indexOf(key) === -1) {
                            self.removeOption(key);
                        }
                    });
                },

                // 3. Mantemos o score em 1 para aceitar exatamente o que o PHP mandar
                score: function(search) {
                    return function(item) {
                        return 1;
                    };
                },

                load: function(query, callback) {
                    if (!query.length) return callback();
                    const url = "{{ route('produtores.buscar') }}?q=" + encodeURIComponent(query);

                    fetch(url)
                        .then(response => response.json())
                        .then(json => {
                            // Adiciona os novos resultados
                            callback(json);
                        }).catch(() => callback());
                },
                render: {
                    option: function(item, escape) {
                        return `<div class="p-3 border-b border-gray-50 text-left">
                        <div class="text-xs font-black uppercase text-gray-700">${escape(item.nome)}</div>
                        <div class="text-[9px] font-mono text-gray-400">${escape(item.cpf_cnpj)}</div>
                    </div>`;
                    },
                    item: function(item, escape) {
                        return `<div class="text-xs font-black uppercase text-[#064e3b]">${escape(item.nome)}</div>`;
                    }
                }
            };

            // Inicialização
            const selectTitular = new TomSelect('#select-titular', configSelect);

            // Opcional: Se quiser que ele limpe os resultados ao fechar o dropdown
            selectTitular.on('dropdown_close', () => {
                selectTitular.clearOptions(); // Descomente se quiser limpeza agressiva
            });

            // Para os sócios, permitimos múltiplos
            const configSocios = {
                ...configSelect,
                maxItems: null
            };
            const selectSocios = new TomSelect('#select-socios', configSocios);
        });


        // Se estiver EDITANDO, carregar os dados iniciais
        @if (isset($marca) || old('produtor_id'))
            const titularInicial = {
                id: "{{ $marca->produtor->id ?? old('produtor_id') }}",
                nome: "{{ $marca->produtor->nome ?? 'Produtor Selecionado' }}",
                cpf_cnpj: "{{ $marca->produtor->cpf_cnpj ?? '' }}"
            };
            selectTitular.addOption(titularInicial);
            selectTitular.setValue(titularInicial.id);
        @endif

        // --- Lógica do Canvas ---
        const canvas = document.getElementById('canvas-marca');
        const inputVetor = document.getElementById('desenho_vetor');
        const signaturePad = new SignaturePad(canvas, {
            minWidth: 2.5,
            maxWidth: 5,
            penColor: "#000"
        });

        function setupCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);

            const rawData = `{!! old('desenho_vetor', $marca->desenho_vetor ?? '') !!}`;

            if (rawData && rawData.length > 5) {
                let data = JSON.parse(rawData);

                // --- LÓGICA DE CENTRALIZAÇÃO AO CARREGAR ---
                let minX = Infinity,
                    minY = Infinity,
                    maxX = -Infinity,
                    maxY = -Infinity;

                // Calculamos os limites do desenho existente
                data.forEach(stroke => {
                    stroke.points.forEach(point => {
                        if (point.x < minX) minX = point.x;
                        if (point.y < minY) minY = point.y;
                        if (point.x > maxX) maxX = point.x;
                        if (point.y > maxY) maxY = point.y;
                    });
                });

                // Se houver desenho válido, calculamos o deslocamento para o centro
                if (minX !== Infinity) {
                    const larguraDesenho = maxX - minX;
                    const alturaDesenho = maxY - minY;

                    // Calculamos quanto falta para centralizar no canvas atual
                    const offsetX = (canvas.offsetWidth - larguraDesenho) / 2 - minX;
                    const offsetY = (canvas.offsetHeight - alturaDesenho) / 2 - minY;

                    // Movemos todos os pontos para a nova posição centralizada
                    data = data.map(stroke => ({
                        ...stroke,
                        points: stroke.points.map(point => ({
                            ...point,
                            x: point.x + offsetX,
                            y: point.y + offsetY
                        }))
                    }));
                }

                signaturePad.fromData(data);
            }
        }

        window.addEventListener('resize', setupCanvas);
        document.addEventListener('DOMContentLoaded', () => setTimeout(setupCanvas, 300));
        document.getElementById('clear').addEventListener('click', () => signaturePad.clear());

        document.getElementById('form-registro').addEventListener('submit', function(e) {
            if (signaturePad.isEmpty()) {
                e.preventDefault();
                alert("⚠️ Desenhe a marca.");
            } else {
                inputVetor.value = JSON.stringify(signaturePad.toData());
            }
        });

        document.getElementById('foto-input').addEventListener('change', function() {
            if (this.files[0]) document.getElementById('foto-label').innerText = this.files[0].name;
        });
    </script>
@endpush
