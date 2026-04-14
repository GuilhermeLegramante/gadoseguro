<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Sistema de Marcas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-[#f0f2f5] min-h-screen flex items-center justify-center p-6 font-sans">

    <div class="w-full max-w-[420px]">
        {{-- Logotipo Superior --}}
        <div class="text-center mb-10">
            <div
                class="inline-flex items-center justify-center w-24 h-24 bg-[#064e3b] rounded-[2.8rem] shadow-2xl shadow-green-900/30 mb-6 transition-transform hover:scale-105">
                <i data-lucide="shield-half" class="w-12 h-12 text-white"></i>
            </div>
            <h1 class="text-4xl font-black text-gray-900 uppercase italic leading-none tracking-tighter">
                REDE <br> <span class="text-[#064e3b]">GADO SEGURO</span>
            </h1>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.4em] mt-4 opacity-70">Painel de
                Autenticação</p>
        </div>

        {{-- Card de Login --}}
        <div class="bg-white rounded-[3.5rem] p-10 shadow-sm border border-gray-100 relative overflow-hidden">
            {{-- Decorativo de Fundo --}}
            <div class="absolute -right-8 -top-8 w-24 h-24 bg-gray-50 rounded-full"></div>

            <form action="{{ route('login') }}" method="POST" class="relative space-y-7">
                @csrf

                {{-- Campo Usuário --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-5">Nome de
                        Usuário</label>
                    <div class="relative group">
                        <i data-lucide="user"
                            class="absolute left-6 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-300 group-focus-within:text-[#064e3b] transition-colors"></i>
                        <input type="text" name="username" value="{{ old('username') }}" required autofocus
                            class="w-full bg-gray-50 border-none rounded-[1.8rem] py-5 pl-16 pr-8 text-sm font-bold focus:ring-2 focus:ring-[#064e3b] transition-all placeholder:text-gray-300 shadow-inner"
                            placeholder="ex: operador_01">
                    </div>
                    @error('username')
                        <span class="text-red-500 text-[10px] font-black uppercase ml-5">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Campo Senha --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-5">Senha de
                        Acesso</label>
                    <div class="relative group">
                        <i data-lucide="lock"
                            class="absolute left-6 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-300 group-focus-within:text-[#064e3b] transition-colors"></i>
                        <input type="password" name="password" required
                            class="w-full bg-gray-50 border-none rounded-[1.8rem] py-5 pl-16 pr-8 text-sm font-bold focus:ring-2 focus:ring-[#064e3b] transition-all placeholder:text-gray-300 shadow-inner"
                            placeholder="••••••••">
                    </div>
                </div>

                {{-- Botão Entrar --}}
                <button type="submit"
                    class="w-full bg-[#064e3b] hover:bg-green-700 text-white py-5 rounded-[2rem] font-black uppercase text-[11px] tracking-[0.2em] shadow-xl shadow-green-900/30 transition-all active:scale-95 flex items-center justify-center gap-3 mt-4">
                    Acessar Sistema
                    <i data-lucide="arrow-right-circle" class="w-5 h-5"></i>
                </button>
            </form>
        </div>

        {{-- Rodapé --}}
        <div class="text-center mt-12">
            <p class="text-gray-400 text-[9px] font-black uppercase tracking-[0.3em]">
                &copy; {{ date('Y') }} Marca e Sinal - Hardsoft Sistemas
            </p>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>
