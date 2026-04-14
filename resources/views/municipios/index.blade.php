@extends('layouts.app')
@section('title', 'Municípios')

@section('content')
    <div class="space-y-6">
        <x-index-header title="Municípios" titleHighlight="Parceiros" subtitle="Gestão de órgãos e configurações regionais"
            :routeCreate="route('municipios.create')" buttonLabel="Novo Município" icon="map-pin" />

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($municipios as $m)
                <div
                    class="bg-white rounded-[2.5rem] p-6 shadow-sm border border-gray-100 hover:border-green-500 transition-all group relative overflow-hidden">
                    <div class="flex items-center gap-4 mb-6">
                        <div
                            class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center overflow-hidden border border-gray-100">
                            @if ($m->brasao_path)
                                <img src="{{ asset('storage/' . $m->brasao_path) }}"
                                    class="w-full h-full object-contain p-2">
                            @else
                                <i data-lucide="image" class="w-6 h-6 text-gray-300"></i>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-black text-gray-800 uppercase italic tracking-tighter text-lg leading-none">
                                {{ $m->nome }}</h3>
                            <p class="text-[10px] font-black text-green-600 uppercase tracking-widest mt-1">
                                {{ $m->departamento_nome ?? 'Órgão não definido' }}</p>
                        </div>
                    </div>

                    <div class="space-y-3 mb-6">
                        <div
                            class="flex items-center justify-between text-[10px] font-bold uppercase tracking-tight text-gray-400">
                            <span>Validade das Marcas</span>
                            <span class="text-gray-800">{{ $m->prazo_validade_anos }} Anos</span>
                        </div>
                        <div
                            class="flex items-center justify-between text-[10px] font-bold uppercase tracking-tight text-gray-400">
                            <span>Numeração</span>
                            <span
                                class="px-2 py-0.5 rounded-md {{ $m->numero_automatico ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ $m->numero_automatico ? 'Automática' : 'Manual' }}
                            </span>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('municipios.edit', $m->id) }}"
                            class="flex-1 bg-gray-50 hover:bg-[#064e3b] hover:text-white py-3 rounded-xl text-[10px] font-black uppercase tracking-widest text-center transition-all">
                            Configurar
                        </a>
                    </div>
                </div>
            @empty
                <p>Nenhum município cadastrado.</p>
            @endforelse
        </div>
        <div class="py-6 px-2">
            {{ $municipios->links() }}
        </div>
    </div>
@endsection
