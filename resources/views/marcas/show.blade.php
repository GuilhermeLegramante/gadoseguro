@extends('layouts.app')
@section('title', 'Detalhes da Marca')

@section('content')
    <div class="container mx-auto max-w-5xl pb-20">
        <x-show-page-header :backRoute="route('marcas.index')" title="Perfil" subtitle="Gestão de Registro" :routeEdit="route('marcas.edit', $marca->id)" :routeDelete="route('marcas.destroy', $marca->id)"
            :model="$marca" {{-- <--- Aqui está o segredo --}} deleteTitle="Excluir Marca?"
            deleteMessage="Isso removerá o registro permanentemente." />

        <div class="grid md:grid-cols-3 gap-8 px-4">
            {{-- Coluna da Esquerda: Imagens --}}
            <div class="md:col-span-2 space-y-8">
                {{-- Card do Desenho Digital --}}
                <div class="bg-white rounded-[2.5rem] border border-gray-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                        <h2 class="text-[#064e3b] font-black text-xs uppercase tracking-widest flex items-center gap-2">
                            <i data-lucide="pen-tool" class="w-4 h-4"></i> Matriz Digital
                        </h2>
                        <span
                            class="text-[10px] bg-green-50 text-green-700 px-3 py-1 rounded-full font-bold uppercase">Autêntico</span>
                    </div>
                    <div class="p-10 flex justify-center bg-gray-50">
                        <div
                            class="bg-white p-8 rounded-[2rem] shadow-inner border border-gray-100 w-full max-w-md aspect-square flex items-center justify-center">
                            <canvas id="canvas-show" class="w-full h-full"
                                data-vector="{{ json_encode($marca->desenho_vetor) }}"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Foto de Campo --}}
                <div class="bg-white rounded-[2.5rem] border border-gray-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-50">
                        <h2 class="text-[#064e3b] font-black text-xs uppercase tracking-widest flex items-center gap-2">
                            <i data-lucide="camera" class="w-4 h-4"></i> Aplicação em Campo (Foto)
                        </h2>
                    </div>
                    <div class="p-6 flex justify-center">
                        @if ($marca->foto_path)
                            <img src="{{ asset('storage/' . $marca->foto_path) }}"
                                class="rounded-[2rem] w-full object-cover max-h-[500px] shadow-md">
                        @else
                            <div
                                class="py-20 text-center w-full bg-gray-50 rounded-[2rem] border-2 border-dashed border-gray-200">
                                <i data-lucide="camera-off" class="w-12 h-12 text-gray-300 mx-auto mb-2"></i>
                                <p class="text-gray-400 font-bold uppercase text-xs">Nenhuma foto anexada</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Coluna da Direita: Dados --}}
            <div class="space-y-6">

                {{-- Documentos Oficiais --}}
                <div class="bg-white rounded-[2.5rem] p-6 border-2 border-[#064e3b]/10 shadow-sm">
                    <h3 class="text-gray-400 font-black text-[10px] uppercase tracking-[0.2em] mb-4">Documentação</h3>
                    <a href="{{ route('marcas.titulo', $marca->id) }}" target="_blank"
                        class="group flex items-center justify-between w-full bg-[#f8faf9] hover:bg-[#064e3b] p-4 rounded-2xl transition-all border border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="bg-white p-2 rounded-xl group-hover:bg-white/20">
                                <i data-lucide="file-text" class="w-5 h-5 text-[#064e3b] group-hover:text-white"></i>
                            </div>
                            <div class="text-left">
                                <p class="text-[#064e3b] group-hover:text-white font-bold text-sm">Título de Registro</p>
                                <p class="text-gray-400 group-hover:text-white/60 text-[10px] uppercase font-black">Gerar
                                    PDF Oficial</p>
                            </div>
                        </div>
                        <i data-lucide="external-link" class="w-4 h-4 text-gray-300 group-hover:text-white"></i>
                    </a>
                </div>

                {{-- Card Proprietário --}}
                <div class="bg-[#064e3b] text-white rounded-[2.5rem] p-8 shadow-xl relative overflow-hidden">
                    <i data-lucide="shield-check" class="absolute -right-4 -top-4 w-24 h-24 text-white/10"></i>
                    <h3 class="text-white/60 font-black text-[10px] uppercase tracking-[0.2em] mb-4">Proprietário</h3>
                    <p class="text-2xl font-bold leading-tight">{{ $marca->produtor->nome }}</p>
                    <div class="mt-6 space-y-3">
                        <div class="flex items-center gap-3 text-sm text-white/80">
                            <i data-lucide="map-pin" class="w-4 h-4"></i>
                            {{ $marca->municipio->nome }} - RS
                        </div>
                        <div class="flex items-center gap-3 text-sm text-white/80">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                            Registrado em {{ $marca->created_at->format('d/m/Y') }}
                        </div>
                    </div>
                </div>

                @if ($marca->socios->count() > 0)
                    <div class="space-y-2 mt-4">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Sócios
                            Vinculados</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($marca->socios as $socio)
                                <span
                                    class="bg-gray-100 text-gray-600 text-[10px] font-bold px-3 py-1 rounded-lg border border-gray-200">
                                    {{ $socio->nome }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Card Biometria (Opcional - Dados técnicos) --}}
                <div class="bg-white rounded-[2.5rem] p-8 border border-gray-200 shadow-sm">
                    <h3 class="text-gray-400 font-black text-[10px] uppercase tracking-[0.2em] mb-6">DNA Visual (Índices)
                    </h3>
                    <div class="grid grid-cols-3 gap-2">
                        @for ($i = 1; $i <= 9; $i++)
                            @php $campo = 'q'.$i; @endphp
                            <div class="bg-gray-50 p-3 rounded-xl text-center">
                                <span class="block text-[8px] text-gray-400 font-black mb-1">Q{{ $i }}</span>
                                <span
                                    class="text-[10px] font-bold text-[#064e3b]">{{ number_format($marca->$campo * 100, 1) }}%</span>
                            </div>
                        @endfor
                    </div>
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-gray-400 font-bold uppercase">Traços detectados</span>
                            <span class="font-black text-[#064e3b]">{{ $marca->qtd_tracos }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Certifique-se de que o SignaturePad está carregado --}}
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('canvas-show');
            const rawData = canvas.getAttribute('data-vector');

            if (rawData && rawData.length > 5) {
                const signaturePad = new SignaturePad(canvas);
                const data = JSON.parse(rawData);

                function renderizarCentralizado() {
                    const ratio = Math.max(window.devicePixelRatio || 1, 1);
                    canvas.width = canvas.offsetWidth * ratio;
                    canvas.height = canvas.offsetHeight * ratio;
                    canvas.getContext("2d").scale(ratio, ratio);

                    signaturePad.clear();

                    // 1. Encontrar os limites do desenho (min/max X e Y)
                    let minX = Infinity,
                        minY = Infinity,
                        maxX = -Infinity,
                        maxY = -Infinity;
                    data.forEach(stroke => {
                        stroke.points.forEach(point => {
                            if (point.x < minX) minX = point.x;
                            if (point.y < minY) minY = point.y;
                            if (point.x > maxX) maxX = point.x;
                            if (point.y > maxY) maxY = point.y;
                        });
                    });

                    const larguraDesenho = maxX - minX;
                    const alturaDesenho = maxY - minY;

                    // 2. Definir margem interna (Padding) - 20px é o ideal para não encostar na borda
                    const padding = 20;

                    // 3. Calcular a escala para preencher o card
                    const escala = Math.min(
                        (canvas.offsetWidth - padding * 2) / larguraDesenho,
                        (canvas.offsetHeight - padding * 2) / alturaDesenho
                    );

                    // 4. Calcular o deslocamento para centralizar
                    const offsetX = (canvas.offsetWidth - larguraDesenho * escala) / 2 - minX * escala;
                    const offsetY = (canvas.offsetHeight - alturaDesenho * escala) / 2 - minY * escala;

                    // 5. Aplicar transformação nos pontos
                    const dadosAjustados = data.map(stroke => ({
                        ...stroke,
                        points: stroke.points.map(point => ({
                            ...point,
                            x: point.x * escala + offsetX,
                            y: point.y * escala + offsetY
                        }))
                    }));

                    signaturePad.fromData(dadosAjustados);
                    signaturePad.off(); // Desativa interação
                }

                // Executa e garante ajuste no redimensionamento
                renderizarCentralizado();
                window.addEventListener('resize', renderizarCentralizado);
            }
        });
    </script>
@endpush
