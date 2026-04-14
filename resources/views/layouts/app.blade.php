<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Gado Seguro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        #btn-text-mode,
        #btn-visual-mode {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 44px;
            /* Tamanho bom para o polegar no celular */
        }

        /* Força a paginação a ficar clara e com as cores do projeto */
        .pagination {
            @apply flex gap-2 !important;
        }

        nav[role="navigation"] div div span,
        nav[role="navigation"] div div a {
            @apply border-none bg-white rounded-xl shadow-sm text-gray-600 font-bold !important;
        }

        /* Estilo para o link ativo (Página atual) */
        nav[role="navigation"] div div span[aria-current="page"] span {
            @apply bg-[#064e3b] text-white rounded-xl shadow-lg shadow-green-900/20 !important;
        }

        /* Remove o fundo escuro que o Tailwind injeta */
        .dark\:bg-gray-800 {
            background-color: white !important;
        }

        .dark\:text-gray-400 {
            color: #9ca3af !important;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
</head>

<body class="bg-gray-50 pb-24 md:pb-0 md:pl-64">

    @include('components.modal-confirm')

    <aside class="hidden md:flex flex-col w-64 bg-[#064e3b] h-screen fixed left-0 top-0 text-white p-6">
        <div class="mb-10">
            <h2 class="text-2xl font-black italic tracking-tighter">GADO SEGURO</h2>
            <p class="text-[10px] opacity-50 uppercase tracking-widest">Sistema de Rastreabilidade</p>
        </div>

        <nav class="space-y-2 flex-1">
            <x-nav-link href="/dashboard" icon="layout-dashboard" label="Dashboard" :active="request()->is('dashboard')" />
            <x-nav-link href="/marcas" icon="shield-check" label="Marcas Registradas" :active="request()->is('marcas*')" />
            <x-nav-link href="/produtores" icon="users" label="Produtores" :active="request()->is('produtores*')" />
            <x-nav-link href="/municipios" icon="map-pin" label="Municípios" :active="request()->is('municipios*')" />
        </nav>

        <div class="pt-6 border-t border-green-800 mt-auto">
            <div class="flex items-center justify-between p-2 group">
                <div class="flex items-center gap-3">
                    {{-- Iniciais Dinâmicas --}}
                    <div
                        class="w-10 h-10 rounded-[1rem] bg-green-500/20 text-green-400 flex items-center justify-center font-black text-xs border border-green-500/30">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>

                    <div class="text-xs">
                        {{-- Nome do Usuário Logado --}}
                        <p class="font-black text-gray-100 uppercase tracking-tighter">{{ Auth::user()->name }}</p>

                        {{-- Link de Logout --}}
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>

                        <a href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="text-[10px] text-green-500 font-bold uppercase tracking-widest hover:text-white transition-colors">
                            Sair do sistema
                        </a>
                    </div>
                </div>

                {{-- Ícone de indicação opcional --}}
                <i data-lucide="log-out"
                    class="w-4 h-4 text-green-800 group-hover:text-red-400 transition-colors cursor-pointer"
                    onclick="document.getElementById('logout-form').submit();"></i>
            </div>
        </div>
    </aside>

    <nav
        class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-6 py-3 flex justify-between items-center z-50">
        <a href="/dashboard"
            class="flex flex-col items-center gap-1 {{ request()->is('dashboard') ? 'text-[#064e3b]' : 'text-gray-400' }}">
            <i data-lucide="layout-dashboard" class="w-6 h-6"></i>
            <span class="text-[10px] font-bold">Início</span>
        </a>
        <a href="/marcas"
            class="flex flex-col items-center gap-1 {{ request()->is('marcas*') ? 'text-[#064e3b]' : 'text-gray-400' }}">
            <i data-lucide="shield-check" class="w-6 h-6"></i>
            <span class="text-[10px] font-bold">Marcas</span>
        </a>
        <div class="-mt-12">
            <a href="/marcas/novo"
                class="bg-green-500 text-white p-4 rounded-full shadow-xl flex items-center justify-center border-4 border-gray-50">
                <i data-lucide="plus" class="w-6 h-6"></i>
            </a>
        </div>
        <a href="/produtores"
            class="flex flex-col items-center gap-1 {{ request()->is('produtores*') ? 'text-[#064e3b]' : 'text-gray-400' }}">
            <i data-lucide="users" class="w-6 h-6"></i>
            <span class="text-[10px] font-bold">Produtores</span>
        </a>
        <a href="/perfil" class="flex flex-col items-center gap-1 text-gray-400">
            <i data-lucide="user" class="w-6 h-6"></i>
            <span class="text-[10px] font-bold">Perfil</span>
        </a>
    </nav>

    <main class="p-4 md:p-10 max-w-6xl mx-auto">
        @if (session('success'))
            <div id="success-alert"
                class="fixed top-4 right-4 left-4 z-50 bg-green-500 text-white p-4 rounded-2xl shadow-2xl flex items-center justify-between animate-bounce">
                <div class="flex items-center gap-3">
                    <i data-lucide="check-circle" class="w-6 h-6"></i>
                    <span class="font-black uppercase italic text-sm">{{ session('success') }}</span>
                </div>
                <button onclick="document.getElementById('success-alert').remove()">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <script>
                setTimeout(() => {
                    document.getElementById('success-alert')?.remove();
                }, 4000);
            </script>
        @endif

        @yield('content')
    </main>

    <script>
        lucide.createIcons();
    </script>


    @stack('scripts')
</body>

</html>
