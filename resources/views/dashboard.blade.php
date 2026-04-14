@extends('layouts.app')
@section('title', 'Painel de Controle')

@section('content')
    <div class="space-y-8">
        <div class="flex justify-between items-end">
            <div>
                <h1 class="text-3xl font-black text-gray-900 uppercase italic">Painel Geral</h1>
                <p class="text-gray-500">Bem-vindo ao centro de inteligência Gado Seguro.</p>
            </div>
            <div class="hidden md:block text-right">
                <p class="text-sm font-bold text-[#064e3b]">{{ date('d \d\e F, Y') }}</p>
                <p class="text-xs text-gray-400 uppercase tracking-widest">Status da Rede: Online</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-3xl border border-gray-200 shadow-sm relative overflow-hidden group">
                <div class="relative z-10">
                    <p class="text-xs font-bold text-gray-400 uppercase mb-1">Total de Marcas</p>
                    <h3 class="text-4xl font-black text-[#064e3b]">{{ $totalMarcas }}</h3>
                    <p class="text-[10px] text-green-600 font-bold mt-2 flex items-center gap-1">
                        <i data-lucide="trending-up" class="w-3 h-3"></i> +12% este mês
                    </p>
                </div>
                <i data-lucide="shield-check"
                    class="absolute -right-4 -bottom-4 w-24 h-24 text-gray-50 group-hover:text-green-50 transition-colors"></i>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-gray-200 shadow-sm relative overflow-hidden group">
                <div class="relative z-10">
                    <p class="text-xs font-bold text-gray-400 uppercase mb-1">Municípios Atendidos</p>
                    <h3 class="text-4xl font-black text-gray-800">{{ $totalMunicipios }}</h3>
                    <p class="text-[10px] text-gray-400 font-bold mt-2 uppercase tracking-tighter">RS - Cobertura Estadual
                    </p>
                </div>
                <i data-lucide="map"
                    class="absolute -right-4 -bottom-4 w-24 h-24 text-gray-50 group-hover:text-blue-50 transition-colors"></i>
            </div>

            <div
                class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm bg-gradient-to-br from-[#064e3b] to-[#065f46] text-white">
                <p class="text-xs font-bold opacity-70 uppercase mb-1">Produtores Ativos</p>
                <h3 class="text-4xl font-black">{{ $totalProdutores }}</h3>
                <div class="flex -space-x-2 mt-4">
                    <div class="w-7 h-7 rounded-full border-2 border-[#064e3b] bg-gray-300"></div>
                    <div class="w-7 h-7 rounded-full border-2 border-[#064e3b] bg-gray-400"></div>
                    <div class="w-7 h-7 rounded-full border-2 border-[#064e3b] bg-gray-500"></div>
                    <div
                        class="w-7 h-7 rounded-full border-2 border-[#064e3b] bg-green-500 flex items-center justify-center text-[8px]">
                        +</div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-6">
                <div class="flex justify-between items-center mb-6">
                    <h4 class="font-black uppercase italic text-gray-700">Registros Recentes</h4>
                    <a href="/marcas" class="text-xs font-bold text-green-600 underline">Ver todos</a>
                </div>
                <div class="space-y-4">
                    @foreach ($ultimasMarcas as $um)
                        <div class="flex items-center gap-4 p-3 hover:bg-gray-50 rounded-2xl transition">
                            <div
                                class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center overflow-hidden border border-gray-200">
                                <i data-lucide="image" class="w-4 h-4 text-gray-300"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-gray-800">{{ $um->produtor->nome }}</p>
                                <p class="text-[10px] text-gray-400 uppercase tracking-widest">{{ $um->municipio->nome }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] font-black text-gray-300 italic">#{{ $um->numero }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <a href="/marcas/novo"
                    class="bg-white p-8 rounded-3xl border border-gray-200 flex flex-col items-center justify-center gap-4 hover:border-green-500 transition group">
                    <div class="p-4 bg-green-50 rounded-2xl group-hover:bg-green-500 group-hover:text-white transition">
                        <i data-lucide="plus-circle" class="w-8 h-8"></i>
                    </div>
                    <span class="font-bold text-gray-700">Nova Marca</span>
                </a>
                <a href="/marcas"
                    class="bg-white p-8 rounded-3xl border border-gray-200 flex flex-col items-center justify-center gap-4 hover:border-[#064e3b] transition group">
                    <div class="p-4 bg-gray-50 rounded-2xl group-hover:bg-[#064e3b] group-hover:text-white transition">
                        <i data-lucide="search" class="w-8 h-8"></i>
                    </div>
                    <span class="font-bold text-gray-700">Busca Visual</span>
                </a>
            </div>
        </div>
    </div>
@endsection
