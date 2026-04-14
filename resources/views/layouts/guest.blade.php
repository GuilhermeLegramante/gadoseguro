<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Gado Seguro</title>

    {{-- Mantendo os mesmos recursos do App --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 flex flex-col min-h-screen">

    {{-- Header Simples apenas para Identidade Visual --}}
    <header class="p-6 flex justify-center items-center">
        <div class="text-center">
            <h2 class="text-[#064e3b] text-xl font-black italic tracking-tighter">GADO SEGURO</h2>
            <p class="text-[8px] text-gray-400 uppercase tracking-[0.3em]">Sistema de Rastreabilidade Oficial</p>
        </div>
    </header>

    {{-- Conteúdo Centralizado --}}
    <main class="flex-grow flex items-center justify-center p-4">
        <div class="w-full max-w-lg">
            @yield('content')
        </div>
    </main>

    {{-- Footer Discreto --}}
    <footer class="p-6 text-center">
        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">
            &copy; {{ date('Y') }} - Hardsoft Sistemas
        </p>
    </footer>

    <script>
        lucide.createIcons();
    </script>

    @stack('scripts')
</body>

</html>
