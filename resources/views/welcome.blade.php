<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REDE GADO SEGURO | Tecnologia contra o Abigeato</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <link rel="manifest" href="/manifest.json">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'agro-green': '#064e3b',
                        /* Verde Escuro Principal */
                        'agro-dark': '#022c22',
                        /* Verde Quase Negro (para rodapé/detalhes) */
                        'agro-light': '#10b981',
                        /* Verde Realce (Emerald 500) */
                    }
                }
            }
        }
    </script>

    <style>
        html {
            scroll-behavior: smooth;
        }

        .hero-gradient {
            background: linear-gradient(135deg, #064e3b 0%, #022c22 100%);
        }
    </style>
</head>

<body class="bg-white text-gray-800 font-sans">

    <nav class="bg-agro-green p-4 text-white sticky top-0 z-50 shadow-xl border-b border-white/10">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center gap-2">
                <i data-lucide="shield-check" class="text-green-400 w-8 h-8"></i>
                <h1 class="text-2xl font-black tracking-tighter uppercase">REDE <span class="text-green-400">GADO
                        SEGURO</span></h1>
            </div>
            <div class="space-x-8 hidden md:flex font-medium">
                <a href="#sobre" class="hover:text-green-400 transition mt-2">A Rede</a>
                <a href="#tecnologia" class="hover:text-green-400 transition mt-2">Tecnologia</a>
                <a href="/login"
                    class="bg-white text-agro-green px-7 py-2 rounded-full font-bold hover:bg-green-50 transition shadow-lg">
                    Acessar Sistema
                </a>
            </div>
        </div>
    </nav>

    <header class="relative hero-gradient py-28 text-white overflow-hidden">
        <div class="container mx-auto px-6 flex flex-col md:flex-row items-center relative z-10">
            <div class="md:w-1/2 mb-16 md:mb-0">
                <span
                    class="bg-green-500/20 text-green-300 border border-green-500/30 px-4 py-1 rounded-full text-sm font-bold mb-6 inline-block">
                    TECNOLOGIA HARDSOFT SISTEMAS
                </span>
                <h2 class="text-5xl md:text-7xl font-extrabold leading-tight mb-6">
                    Segurança Máxima no <span class="text-green-400">Campo.</span>
                </h2>
                <p class="text-xl mb-10 text-gray-300 leading-relaxed max-w-xl">
                    Unindo inteligência de dados e forças policiais para erradicar o abigeato através do monitoramento
                    digital de marcas e sinais.
                </p>
                <div class="flex flex-wrap gap-4">
                    <button
                        class="bg-green-500 hover:bg-green-600 text-white px-10 py-4 rounded-xl font-bold transition transform hover:scale-105 shadow-2xl">
                        Aderir à Rede
                    </button>
                    <button
                        class="bg-white/10 backdrop-blur-md border border-white/20 hover:bg-white/20 px-10 py-4 rounded-xl font-bold transition">
                        Consultar Banco
                    </button>
                </div>
            </div>

            <div class="md:w-1/2 flex justify-center relative">
                <div class="relative z-20">
                    <div
                        class="w-64 h-[520px] bg-agro-dark rounded-[3rem] border-[8px] border-black shadow-2xl overflow-hidden relative">
                        <div class="absolute top-0 w-full h-7 bg-black flex justify-center">
                            <div class="w-24 h-4 bg-black rounded-b-2xl"></div>
                        </div>
                        <div class="p-5 pt-12">
                            <div
                                class="w-full h-40 bg-agro-green rounded-2xl mb-4 flex items-center justify-center border border-white/10">
                                <i data-lucide="scan-face" class="w-12 h-12 text-green-400"></i>
                            </div>
                            <div class="space-y-3">
                                <div class="h-3 bg-green-900/50 rounded w-full"></div>
                                <div class="h-3 bg-green-900/50 rounded w-5/6"></div>
                                <div class="h-10 bg-green-500 rounded-lg w-full mt-4 opacity-80"></div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="absolute -bottom-6 -left-10 bg-white p-5 rounded-2xl shadow-2xl flex items-center gap-4 border border-green-100 animate-bounce">
                        <div class="bg-green-100 p-2 rounded-full">
                            <i data-lucide="map" class="text-agro-green w-6 h-6"></i>
                        </div>
                        <div>
                            <p class="text-agro-dark font-black text-xl leading-none">+20</p>
                            <p class="text-gray-500 text-xs font-bold uppercase tracking-tighter">Municípios</p>
                        </div>
                    </div>
                </div>
                <div class="absolute w-80 h-80 bg-green-500/20 blur-[100px] rounded-full"></div>
            </div>
        </div>
    </header>

    <section id="sobre" class="py-24 bg-white">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row items-end justify-between mb-16 gap-6">
                <div class="max-w-2xl">
                    <h3 class="text-4xl font-black text-agro-dark mb-4 uppercase tracking-tighter">Gestão e Vigilância
                        Integrada</h3>
                    <p class="text-gray-600 text-lg leading-relaxed">Nossa plataforma conecta os dados das prefeituras
                        diretamente com as viaturas de campo, permitindo identificação em tempo real.</p>
                </div>
                <div class="hidden md:block h-1 w-32 bg-green-500 mb-4"></div>
            </div>

            <div class="grid md:grid-cols-4 gap-6">
                @php
                    $pilares = [
                        [
                            'icon' => 'shield',
                            'title' => 'Polícia Civil/BM',
                            'desc' => 'Consulta imediata de proprietários via fotos em operações.',
                        ],
                        [
                            'icon' => 'database',
                            'title' => 'Banco Único',
                            'desc' => 'Informatização completa de livros e imagens para 20 cidades.',
                        ],
                        [
                            'icon' => 'bell',
                            'title' => 'Notificações',
                            'desc' => 'Alertas automáticos de furtos ou movimentações suspeitas.',
                        ],
                        [
                            'icon' => 'check-circle',
                            'title' => 'Legalidade',
                            'desc' => 'Garantia de títulos e registros com segurança da informação.',
                        ],
                    ];
                @endphp

                @foreach ($pilares as $pilar)
                    <div
                        class="group p-8 rounded-3xl bg-gray-50 hover:bg-agro-green transition-all duration-500 border border-gray-100 hover:border-agro-green">
                        <i data-lucide="{{ $pilar['icon'] }}"
                            class="text-agro-green group-hover:text-green-400 w-10 h-10 mb-6 transition-colors"></i>
                        <h4 class="font-bold text-xl mb-3 group-hover:text-white transition-colors tracking-tight">
                            {{ $pilar['title'] }}</h4>
                        <p
                            class="text-gray-500 group-hover:text-green-100/70 text-sm leading-relaxed transition-colors">
                            {{ $pilar['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="sobre" class="py-24 bg-agro-dark text-white relative overflow-hidden">
        <div
            class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-green-500 to-transparent opacity-30">
        </div>

        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-3xl md:text-5xl font-black mb-8 uppercase tracking-tighter italic">
                        Mais que um sistema, <br><span class="text-green-400">uma aliança gaúcha.</span>
                    </h2>
                    <p class="text-gray-300 text-lg mb-6 leading-relaxed">
                        A <strong>REDE GADO SEGURO</strong> nasceu da necessidade de romper as fronteiras municipais no
                        combate ao
                        crime no campo. Através da Hardsoft, conectamos prefeituras do Rio Grande do Sul em um banco de
                        dados unificado.
                    </p>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start gap-3">
                            <i data-lucide="check-circle-2" class="text-green-400 mt-1"></i>
                            <span><strong class="text-white">Unificação:</strong> Informações acessíveis de qualquer
                                município parceiro.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i data-lucide="check-circle-2" class="text-green-400 mt-1"></i>
                            <span><strong class="text-white">Agilidade:</strong> O policial na estrada consulta a marca
                                em segundos.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i data-lucide="check-circle-2" class="text-green-400 mt-1"></i>
                            <span><strong class="text-white">Histórico:</strong> Rastreabilidade total de transferências
                                e baixas.</span>
                        </li>
                    </ul>
                    <div class="inline-flex items-center gap-4 p-4 bg-agro-green rounded-2xl border border-white/5">
                        <div class="text-3xl font-black text-green-400">20+</div>
                        <div class="text-xs font-bold uppercase tracking-widest leading-tight">Municípios do RS<br>Já
                            Protegidos</div>
                    </div>
                </div>

                <div class="relative bg-agro-green/30 p-8 rounded-[2rem] border border-white/10 backdrop-blur-sm">
                    <div class="grid grid-cols-2 gap-4 text-center">
                        <div class="p-6 bg-agro-dark rounded-xl border border-green-500/20">
                            <i data-lucide="users-2" class="mx-auto mb-2 text-green-400"></i>
                            <span class="block text-xs uppercase font-bold tracking-tighter">Produtores</span>
                        </div>
                        <div class="p-6 bg-agro-dark rounded-xl border border-green-500/20">
                            <i data-lucide="shield-check" class="mx-auto mb-2 text-green-400"></i>
                            <span class="block text-xs uppercase font-bold tracking-tighter">Segurança</span>
                        </div>
                        <div class="p-6 bg-agro-dark rounded-xl border border-green-500/20">
                            <i data-lucide="building" class="mx-auto mb-2 text-green-400"></i>
                            <span class="block text-xs uppercase font-bold tracking-tighter">Prefeituras</span>
                        </div>
                        <div class="p-6 bg-agro-dark rounded-xl border border-green-500/20">
                            <i data-lucide="server" class="mx-auto mb-2 text-green-400"></i>
                            <span class="block text-xs uppercase font-bold tracking-tighter">Hardsoft Sistemas</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="tecnologia" class="py-24 bg-white overflow-hidden">
        <div class="container mx-auto px-6">
            <div class="text-center mb-20">
                <span class="text-agro-green font-black uppercase tracking-[0.4em] text-sm">Inovação Hardsoft</span>
                <h2 class="text-4xl md:text-5xl font-black text-agro-dark mt-4">Tecnologia de <span
                        class="text-green-600 underline decoration-agro-green underline-offset-8">Busca Visual</span>
                </h2>
            </div>

            <div class="grid md:grid-cols-3 gap-12">
                <div class="relative group">
                    <div
                        class="mb-6 overflow-hidden rounded-2xl bg-gray-100 aspect-video flex items-center justify-center border-b-4 border-agro-green">
                        <i data-lucide="camera"
                            class="w-16 h-16 text-agro-green opacity-20 group-hover:scale-110 transition-transform duration-500"></i>
                    </div>
                    <h4 class="text-2xl font-bold text-agro-dark mb-4 tracking-tighter">Busca Inteligente</h4>
                    <p class="text-gray-600">Não precisa saber o nome do proprietário. Tire uma foto ou descreva o
                        desenho da marca e nosso algoritmo localiza o registro no banco estadual instantaneamente.</p>
                </div>

                <div class="relative group">
                    <div
                        class="mb-6 overflow-hidden rounded-2xl bg-gray-100 aspect-video flex items-center justify-center border-b-4 border-agro-green">
                        <i data-lucide="fingerprint"
                            class="w-16 h-16 text-agro-green opacity-20 group-hover:scale-110 transition-transform duration-500"></i>
                    </div>
                    <h4 class="text-2xl font-bold text-agro-dark mb-4 tracking-tighter">DNA Digital</h4>
                    <p class="text-gray-600">Cada marca e sinal é digitalizado com alta precisão, preservando livros
                        centenários e transformando-os em dados imutáveis e auditáveis.</p>
                </div>

                <div class="relative group">
                    <div
                        class="mb-6 overflow-hidden rounded-2xl bg-gray-100 aspect-video flex items-center justify-center border-b-4 border-agro-green">
                        <i data-lucide="zap"
                            class="w-16 h-16 text-agro-green opacity-20 group-hover:scale-110 transition-transform duration-500"></i>
                    </div>
                    <h4 class="text-2xl font-bold text-agro-dark mb-4 tracking-tighter">Resposta em Tempo Real</h4>
                    <p class="text-gray-600">Ao sinal de abigeato, a Rede Gado Seguro dispara notificações para todos
                        os órgãos de segurança da região, criando um cerco digital contra o crime.</p>
                </div>
            </div>

            <div
                class="mt-20 p-10 bg-agro-green rounded-[3rem] text-white flex flex-col md:flex-row items-center justify-between gap-8">
                <div>
                    <h3 class="text-2xl font-bold mb-2 tracking-tight">Quer modernizar a gestão do seu município?</h3>
                    <p class="text-green-100/70">Agende uma demonstração do sistema Marca e Sinal v2.0.</p>
                </div>
                <button
                    class="bg-white text-agro-green px-10 py-4 rounded-2xl font-bold hover:bg-green-50 transition shadow-xl whitespace-nowrap">
                    Falar com Consultor
                </button>
            </div>
        </div>
    </section>

    <footer class="bg-agro-dark text-white py-16 border-t border-green-900/30">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-3 gap-12 items-center text-center md:text-left">
                <div>
                    <h4 class="text-2xl font-black uppercase tracking-tighter mb-2">REDE <span
                            class="text-green-400">GADO SEGURO</span></h4>
                    <p class="text-green-100/50 text-sm">Uma solução Hardsoft Sistemas para o Rio Grande do Sul.</p>
                </div>
                <div class="flex justify-center gap-8 font-bold text-sm uppercase tracking-widest text-green-100/70">
                    <a href="#" class="hover:text-white">Privacidade</a>
                    <a href="#" class="hover:text-white">Termos</a>
                    <a href="#" class="hover:text-white">Contato</a>
                </div>
                <div class="flex justify-center md:justify-end gap-4">
                    <div class="flex justify-center md:justify-end gap-4">

                        <a href="SEU_LINK_INSTAGRAM_AQUI" target="_blank" rel="noopener noreferrer"
                            class="w-10 h-10 rounded-full bg-agro-green flex items-center justify-center hover:bg-green-500 transition cursor-pointer"
                            title="Siga-nos no Instagram">
                            <i data-lucide="instagram" class="w-5 h-5 text-white"></i>
                        </a>

                        <a href="SEU_LINK_LINKEDIN_AQUI" target="_blank" rel="noopener noreferrer"
                            class="w-10 h-10 rounded-full bg-agro-green flex items-center justify-center hover:bg-green-500 transition cursor-pointer"
                            title="Siga-nos no LinkedIn">
                            <i data-lucide="linkedin" class="w-5 h-5 text-white"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div
                class="mt-12 pt-8 border-t border-white/5 text-center text-green-100/20 text-xs uppercase tracking-[0.3em]">
                &copy; {{ date('Y') }} HARDSOFT - Marca e Sinal v2.0
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/lucide@0.344.0/dist/umd/lucide.js"></script>

    <script>
        // Tenta renderizar assim que o script carregar
        window.onload = function() {
            lucide.createIcons();
        };
    </script>
</body>

</html>
