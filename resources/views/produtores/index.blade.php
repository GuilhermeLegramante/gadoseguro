@extends('layouts.app')
@section('title', 'Produtores')

@section('content')
    <div class="space-y-6">
        <x-index-header title="Produtores" titleHighlight="" subtitle="Gestão de pecuaristas e propriedades" :routeCreate="route('produtores.create')"
            buttonLabel="Novo Produtor" icon="users" model="App\Models\Produtor" />

        {{-- Barra de Busca e Filtros --}}
        <div
            class="bg-white rounded-[2rem] p-4 shadow-sm border border-gray-100 flex flex-col md:flex-row gap-4 items-center">
            <form action="{{ route('produtores.index') }}" method="GET"
                class="flex-1 w-full flex flex-col md:flex-row gap-4">
                {{-- Input de Busca --}}
                <div class="flex-1 relative group">
                    <i data-lucide="search"
                        class="absolute left-5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-300 group-focus-within:text-[#064e3b] transition-colors"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Buscar por nome, CPF ou CNPJ..."
                        class="w-full bg-gray-50 border-none rounded-2xl py-4 pl-14 pr-6 text-sm font-bold focus:ring-2 focus:ring-[#064e3b] transition-all placeholder:text-gray-300 shadow-inner">
                </div>

                {{-- Select de Município (Aparece para Gestores/Segurança) --}}
                @if (!auth()->user()->isProdutor())
                    <div class="w-full md:w-64 relative group">
                        <i data-lucide="map"
                            class="absolute left-5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-300 group-focus-within:text-[#064e3b] transition-colors"></i>
                        <select name="municipio"
                            class="w-full bg-gray-50 border-none rounded-2xl py-4 pl-14 pr-10 text-sm font-bold focus:ring-2 focus:ring-[#064e3b] transition-all appearance-none shadow-inner">
                            <option value="">Todos Municípios</option>
                            @foreach ($municipios as $m)
                                <option value="{{ $m->id }}" {{ request('municipio') == $m->id ? 'selected' : '' }}>
                                    {{ $m->nome }}</option>
                            @endforeach
                        </select>
                        <i data-lucide="chevron-down"
                            class="absolute right-5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"></i>
                    </div>
                @endif

                <button type="submit"
                    class="bg-[#064e3b] hover:bg-green-700 text-white px-8 py-4 rounded-2xl font-black uppercase text-[10px] tracking-[0.2em] transition-all active:scale-95 shadow-lg shadow-green-900/10">
                    Filtrar
                </button>

                @if (request()->anyFilled(['search', 'municipio']))
                    <a href="{{ route('produtores.index') }}"
                        class="flex items-center justify-center p-4 bg-red-50 text-red-500 rounded-2xl hover:bg-red-500 hover:text-white transition-all shadow-sm border border-red-100"
                        title="Limpar Filtros">
                        <i data-lucide="filter-x" class="w-5 h-5"></i>
                    </a>
                @endif
            </form>
        </div>

        <div class="bg-white rounded-3xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Produtor
                            </th>
                            <th
                                class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest hidden md:table-cell">
                                Documento</th>
                            <th
                                class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">
                                Marcas</th>
                            <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($produtores as $p)
                            <tr class="hover:bg-green-50/30 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-[#064e3b] font-bold text-xs border border-gray-200 uppercase">
                                            {{ substr($p->nome, 0, 2) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-800">{{ $p->nome }}</p>
                                            <p class="text-[10px] text-gray-400 md:hidden">{{ $p->cpf_cnpj }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 hidden md:table-cell">
                                    <span class="text-xs font-mono text-gray-500">{{ $p->cpf_cnpj }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center justify-center bg-green-100 text-green-700 text-[10px] font-black px-2 py-1 rounded-lg">
                                        {{ $p->marcas_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        {{-- Link para o Perfil do Produtor --}}
                                        <a href="{{ route('produtores.show', $p->id) }}" title="Ver Perfil Completo"
                                            class="group p-2 text-gray-400 hover:text-[#064e3b] hover:bg-white rounded-xl transition-all shadow-sm border border-transparent hover:border-gray-100 active:scale-90">

                                            <i data-lucide="user-search"
                                                class="w-5 h-5 transition-transform group-hover:scale-110"></i>

                                            {{-- Tooltip opcional se quiser manter o padrão --}}
                                            <span
                                                class="absolute -top-8 left-1/2 -translate-x-1/2 scale-0 opacity-0 group-hover:scale-100 group-hover:opacity-100 transition-all duration-200 bg-gray-900 text-white text-[9px] font-black uppercase px-2 py-1 rounded-lg tracking-widest pointer-events-none">
                                                Perfil
                                            </span>
                                        </a>

                                        {{-- Link para Editar Produtor --}}
                                        <a href="{{ route('produtores.edit', $p->id) }}" title="Editar Cadastro"
                                            class="p-2 text-gray-400 hover:text-blue-600 hover:bg-white rounded-xl transition shadow-sm border border-transparent hover:border-gray-100">
                                            <i data-lucide="edit-3" class="w-5 h-5"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-20 text-center">
                                    <i data-lucide="users-2" class="w-12 h-12 text-gray-200 mx-auto mb-3"></i>
                                    <p class="text-gray-400 text-sm italic">Nenhum produtor encontrado.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $produtores->links() }}
        </div>
    </div>
@endsection
