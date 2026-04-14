@extends('layouts.guest') {{-- Usamos o layout de visitante --}}

@section('title', 'Verificação de Autenticidade')

@section('content')
    <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 px-6">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-10 shadow-2xl rounded-[3rem] border border-gray-100 relative overflow-hidden">

                {{-- Badge de Status --}}
                <div
                    class="absolute -right-12 top-8 rotate-45 bg-green-500 text-white py-1 px-12 text-[10px] font-black uppercase tracking-widest">
                    Autêntico
                </div>

                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-6">
                        <i data-lucide="shield-check" class="h-10 w-10 text-green-600"></i>
                    </div>

                    <h2 class="text-2xl font-black text-[#064e3b] leading-tight">
                        Documento Verificado
                    </h2>
                    <p class="mt-2 text-sm text-gray-500 font-medium">
                        O registro abaixo consta em nossa base oficial.
                    </p>
                </div>

                <div class="mt-8 space-y-6">
                    {{-- Detalhes da Marca --}}
                    <div class="bg-gray-50 rounded-3xl p-6 border border-gray-100">
                        <div class="flex justify-center mb-6">
                            <div
                                class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 w-full h-64 flex items-center justify-center mx-auto overflow-hidden">
                                <canvas id="canvas-verify" class="max-w-full max-h-full"></canvas>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label
                                    class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Proprietário</label>
                                <p class="text-sm font-bold text-gray-800">{{ $marca->produtor->nome }}</p>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Nº
                                        Registro</label>
                                    <p class="text-sm font-bold text-gray-800">
                                        {{ $marca->numero }}/{{ $marca->created_at->format('Y') }}
                                    </p>
                                </div>
                                <div>
                                    <label
                                        class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Município</label>
                                    <p class="text-sm font-bold text-gray-800">{{ $marca->municipio->nome }} - RS</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Rodapé Informativo --}}
                    <div class="text-center">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">
                            Validado em {{ now()->format('d/m/Y \à\s H:i') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-8 text-center">
                <a href="/"
                    class="text-sm font-bold text-[#064e3b] hover:underline flex items-center justify-center gap-2">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Voltar ao início
                </a>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const canvas = document.getElementById('canvas-verify');
                if (!canvas) return;

                const signaturePad = new SignaturePad(canvas, {
                    displayOnly: true
                });

                function renderizarAjustado() {
                    const ratio = Math.max(window.devicePixelRatio || 1, 1);
                    canvas.width = canvas.offsetWidth * ratio;
                    canvas.height = canvas.offsetHeight * ratio;
                    canvas.getContext("2d").scale(ratio, ratio);

                    signaturePad.clear();

                    // Pega os dados que já confirmamos que existem no banco
                    const rawData = '{!! is_array($marca->desenho_vetor) ? json_encode($marca->desenho_vetor) : $marca->desenho_vetor !!}';

                    if (rawData && rawData.length > 10) {
                        const data = JSON.parse(rawData);

                        // --- INÍCIO DA MÁGICA DE AJUSTE ---

                        // 1. Encontrar os limites reais do desenho (min/max X e Y)
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

                        // 2. Calcular a escala necessária (com 20px de margem interna)
                        const padding = 20;
                        const escala = Math.min(
                            (canvas.offsetWidth - padding) / larguraDesenho,
                            (canvas.offsetHeight - padding) / alturaDesenho
                        );

                        // 3. Centralizar e aplicar a nova escala em cada ponto
                        const offsetX = (canvas.offsetWidth - larguraDesenho * escala) / 2 - minX * escala;
                        const offsetY = (canvas.offsetHeight - alturaDesenho * escala) / 2 - minY * escala;

                        const dadosEscalonados = data.map(stroke => ({
                            ...stroke,
                            points: stroke.points.map(point => ({
                                ...point,
                                x: point.x * escala + offsetX,
                                y: point.y * escala + offsetY
                            }))
                        }));

                        signaturePad.fromData(dadosEscalonados);
                        signaturePad.off(); // Trava para não rabiscar
                    }
                }

                // Delay para o CSS terminar de renderizar o card
                setTimeout(renderizarAjustado, 300);
                window.addEventListener('resize', renderizarAjustado);
            });
        </script>
    @endpush
@endsection
