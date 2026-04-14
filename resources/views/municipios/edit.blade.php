@extends('layouts.app')
@section('title', 'Configurar Município')

@section('content')
    <div class="max-w-5xl mx-auto">
        <x-show-page-header :backRoute="auth()->user()->isSuperAdmin() ? route('municipios.index') : route('dashboard')" :title="$municipio->nome" subtitle="Configurações do Órgão e Regras do Sistema" />

        <form action="{{ route('municipios.update', $municipio->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Card 1: Identidade Visual e Regras --}}
                <div class="bg-white rounded-[3rem] p-10 shadow-sm border border-gray-100 space-y-8">
                    <h3
                        class="text-[10px] font-black text-[#064e3b] uppercase tracking-[0.3em] flex items-center gap-2 border-b border-gray-50 pb-4">
                        <i data-lucide="settings" class="w-4 h-4"></i> Identidade e Regras
                    </h3>

                    {{-- Brasão --}}
                    <div
                        class="flex flex-col items-center gap-4 p-6 bg-gray-50 rounded-[2rem] border-2 border-dashed border-gray-200">
                        <div
                            class="w-24 h-24 bg-white rounded-2xl shadow-sm flex items-center justify-center overflow-hidden border border-gray-100">
                            @if ($municipio->brasao_path)
                                <img src="{{ asset('storage/' . $m->brasao_path) }}"
                                    class="w-full h-full object-contain p-2">
                            @else
                                <i data-lucide="image" class="w-8 h-8 text-gray-200"></i>
                            @endif
                        </div>
                        <input type="file" name="brasao"
                            class="text-[10px] font-bold text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-[#064e3b] file:text-white cursor-pointer">
                    </div>

                    {{-- Switch Numero Automático --}}
                    <div class="flex items-center justify-between p-4 bg-green-50/50 rounded-2xl border border-green-100">
                        <div>
                            <p class="text-xs font-black text-gray-800 uppercase tracking-tight">Numeração Automática</p>
                            <p class="text-[10px] text-gray-500 uppercase">Gerar números automáticos de marcas e sinais</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="numero_automatico" value="0">
                            <input type="checkbox" name="numero_automatico" value="1" class="sr-only peer"
                                {{ $municipio->numero_automatico ? 'checked' : '' }}>
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#064e3b]">
                            </div>
                        </label>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Validade
                            (Anos)</label>
                        <input type="number" name="prazo_validade_anos"
                            value="{{ old('prazo_validade_anos', $municipio->prazo_validade_anos) }}"
                            class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 text-sm font-bold focus:ring-2 focus:ring-[#064e3b] shadow-inner">
                    </div>
                </div>

                {{-- Card 2: Dados Oficiais --}}
                <div class="bg-white rounded-[3rem] p-10 shadow-sm border border-gray-100 space-y-6">
                    <h3
                        class="text-[10px] font-black text-[#064e3b] uppercase tracking-[0.3em] flex items-center gap-2 border-b border-gray-50 pb-4">
                        <i data-lucide="building" class="w-4 h-4"></i> Dados do Departamento
                    </h3>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Nome do
                            Órgão</label>
                        <input type="text" name="departamento_nome"
                            value="{{ old('departamento_nome', $municipio->departamento_nome) }}"
                            class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 text-sm font-bold focus:ring-2 focus:ring-[#064e3b] shadow-inner"
                            placeholder="Ex: Inspetoria Veterinária">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">CNPJ do
                            Órgão</label>
                        <input type="text" name="orgao_cnpj" value="{{ old('orgao_cnpj', $municipio->orgao_cnpj) }}"
                            class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 text-sm font-bold focus:ring-2 focus:ring-[#064e3b] shadow-inner"
                            placeholder="00.000.000/0000-00">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Telefone de
                            Contato</label>
                        <input type="text" name="orgao_telefone"
                            value="{{ old('orgao_telefone', $municipio->orgao_telefone) }}"
                            class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 text-sm font-bold focus:ring-2 focus:ring-[#064e3b] shadow-inner"
                            placeholder="(00) 0000-0000">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Endereço
                            Completo</label>
                        <textarea name="orgao_endereco" rows="3"
                            class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 text-sm font-bold focus:ring-2 focus:ring-[#064e3b] shadow-inner resize-none">{{ old('orgao_endereco', $municipio->orgao_endereco) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="w-full md:w-auto bg-[#064e3b] hover:bg-green-700 text-white px-12 py-5 rounded-2xl font-black uppercase text-xs tracking-[0.2em] shadow-xl shadow-green-900/20 transition-all active:scale-95">
                    Salvar Configurações
                </button>
            </div>
        </form>
    </div>
@endsection
