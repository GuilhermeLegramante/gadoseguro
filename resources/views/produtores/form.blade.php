@extends('layouts.app')
@section('title', isset($produtor) ? 'Editar Produtor' : 'Novo Produtor')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6 pb-12">
        {{-- Header --}}
        <div class="flex items-center gap-4 px-2">
            <a href="javascript:history.back()" class="bg-white p-3 rounded-2xl shadow-sm border border-gray-100">
                <i data-lucide="chevron-left" class="w-6 h-6 text-gray-600"></i>
            </a>
            <div>
                <h1 class="text-2xl font-black text-gray-900 uppercase italic leading-none">
                    {{ isset($produtor) ? 'Editar Produtor' : 'Novo Produtor' }}
                </h1>
                <p class="text-sm text-gray-500 font-medium mt-1">
                    {{ isset($produtor) ? 'Atualize as informações completas.' : 'Cadastro completo do proprietário.' }}
                </p>
            </div>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-2xl shadow-sm">
                <h3 class="text-sm font-black text-red-800 uppercase italic">Verifique os erros abaixo:</h3>
                <ul class="text-xs text-red-600 font-bold uppercase italic mt-1 list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ isset($produtor) ? route('produtores.update', $produtor->id) : route('produtores.store') }}"
            method="POST" class="space-y-6">
            @csrf
            @if (isset($produtor))
                @method('PUT')
            @endif

            {{-- SEÇÃO 1: DADOS PESSOAIS --}}
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-200 p-8 space-y-5">
                <h2 class="text-[#064e3b] font-black uppercase italic tracking-widest text-xs flex items-center gap-2">
                    <i data-lucide="user" class="w-4 h-4"></i> Dados Pessoais
                </h2>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-green-700 uppercase tracking-widest ml-2">Nome
                        Completo</label>
                    <input type="text" name="nome" value="{{ old('nome', $produtor->nome ?? '') }}" required
                        class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 text-sm focus:ring-2 focus:ring-[#064e3b]">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-green-700 uppercase tracking-widest ml-2">Gênero</label>
                        <select name="genero"
                            class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 text-sm focus:ring-2 focus:ring-[#064e3b]">
                            <option value="">Selecione...</option>
                            <option value="Masculino"
                                {{ old('genero', $produtor->genero ?? '') == 'Masculino' ? 'selected' : '' }}>Masculino
                            </option>
                            <option value="Feminino"
                                {{ old('genero', $produtor->genero ?? '') == 'Feminino' ? 'selected' : '' }}>Feminino
                            </option>
                            <option value="Outro"
                                {{ old('genero', $produtor->genero ?? '') == 'Outro' ? 'selected' : '' }}>Outro</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-green-700 uppercase tracking-widest ml-2">Data de
                            Nascimento</label>
                        <input type="date" name="data_nascimento"
                            value="{{ old('data_nascimento', $produtor->data_nascimento ?? '') }}"
                            class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 text-sm focus:ring-2 focus:ring-[#064e3b]">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-green-700 uppercase tracking-widest ml-2">E-mail</label>
                        <input type="email" name="email" value="{{ old('email', $produtor->email ?? '') }}"
                            class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 text-sm focus:ring-2 focus:ring-[#064e3b]">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-green-700 uppercase tracking-widest ml-2">Telefone</label>
                        <input type="text" name="telefone" id="tel_mask"
                            value="{{ old('telefone', $produtor->telefone ?? '') }}"
                            class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 text-sm focus:ring-2 focus:ring-[#064e3b]">
                    </div>
                </div>
            </div>

            {{-- SEÇÃO 2: DOCUMENTAÇÃO --}}
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-200 p-8 space-y-5">
                <h2 class="text-[#064e3b] font-black uppercase italic tracking-widest text-xs flex items-center gap-2">
                    <i data-lucide="file-text" class="w-4 h-4"></i> Documentação Técnica
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-green-700 uppercase tracking-widest ml-2">CPF /
                            CNPJ</label>
                        <input type="text" name="cpf_cnpj" id="doc_mask"
                            value="{{ old('cpf_cnpj', $produtor->cpf_cnpj ?? '') }}" required
                            class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 text-sm focus:ring-2 focus:ring-[#064e3b]">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-green-700 uppercase tracking-widest ml-2">Inscrição
                            Estadual</label>
                        <input type="text" name="inscricao_estadual"
                            value="{{ old('inscricao_estadual', $produtor->inscricao_estadual ?? '') }}"
                            class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 text-sm focus:ring-2 focus:ring-[#064e3b]">
                    </div>
                </div>
            </div>

            {{-- SEÇÃO 3: ENDEREÇO --}}
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-200 p-8 space-y-5">
                <h2 class="text-[#064e3b] font-black uppercase italic tracking-widest text-xs flex items-center gap-2">
                    <i data-lucide="map-pin" class="w-4 h-4"></i> Endereço Completo
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-green-700 uppercase tracking-widest ml-2">CEP</label>
                        <input type="text" name="cep" id="cep_mask"
                            value="{{ old('cep', $produtor->endereco->cep ?? '') }}" required
                            class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 text-sm focus:ring-2 focus:ring-[#064e3b]">
                    </div>
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-[10px] font-black text-green-700 uppercase tracking-widest ml-2">Rua /
                            Logradouro</label>
                        <input type="text" name="logradouro" id="logradouro"
                            value="{{ old('logradouro', $produtor->endereco->logradouro ?? '') }}" required
                            class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 text-sm focus:ring-2 focus:ring-[#064e3b]">
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-green-700 uppercase tracking-widest ml-2">Número</label>
                        <input type="text" name="numero" value="{{ old('numero', $produtor->endereco->numero ?? '') }}"
                            required
                            class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 text-sm focus:ring-2 focus:ring-[#064e3b]">
                    </div>
                    <div class="md:col-span-3 space-y-2">
                        <label
                            class="text-[10px] font-black text-green-700 uppercase tracking-widest ml-2">Complemento</label>
                        <input type="text" name="complemento"
                            value="{{ old('complemento', $produtor->endereco->complemento ?? '') }}"
                            class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 text-sm focus:ring-2 focus:ring-[#064e3b]">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-green-700 uppercase tracking-widest ml-2">Bairro</label>
                        <input type="text" name="bairro" id="bairro"
                            value="{{ old('bairro', $produtor->endereco->bairro ?? '') }}" required
                            class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 text-sm focus:ring-2 focus:ring-[#064e3b]">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-green-700 uppercase tracking-widest ml-2">Cidade</label>
                        <input type="text" name="cidade" id="cidade"
                            value="{{ old('cidade', $produtor->endereco->cidade ?? '') }}" required
                            class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 text-sm focus:ring-2 focus:ring-[#064e3b]">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-green-700 uppercase tracking-widest ml-2">UF</label>
                        <input type="text" name="uf" id="uf"
                            value="{{ old('uf', $produtor->endereco->uf ?? '') }}" required maxlength="2"
                            class="w-full bg-gray-50 border-none rounded-2xl py-4 px-6 text-sm focus:ring-2 focus:ring-[#064e3b] uppercase">
                    </div>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-[#064e3b] text-white py-6 rounded-[2rem] font-black uppercase italic tracking-widest shadow-xl active:scale-95 transition-all flex items-center justify-center gap-3">
                <i data-lucide="{{ isset($produtor) ? 'refresh-cw' : 'check-circle' }}" class="w-6 h-6"></i>
                {{ isset($produtor) ? 'Atualizar Dados' : 'Salvar Cadastro' }}
            </button>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // Máscara de Telefone
        function applyPhoneMask(value) {
            if (!value) return "";
            value = value.replace(/\D/g, "");
            value = value.replace(/^(\d{2})(\d)/g, "($1) $2");
            value = value.replace(/(\d)(\d{4})$/, "$1-$2");
            return value;
        }

        // Máscara de Documento (CPF/CNPJ)
        function applyDocMask(value) {
            if (!value) return "";
            value = value.replace(/\D/g, '');
            if (value.length <= 11) {
                value = value.replace(/(\d{3})(\d)/, "$1.$2");
                value = value.replace(/(\d{3})(\d)/, "$1.$2");
                value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
            } else {
                value = value.replace(/^(\d{2})(\d)/, "$1.$2");
                value = value.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
                value = value.replace(/\.(\d{3})(\d)/, ".$1/$2");
                value = value.replace(/(\d{4})(\d)/, "$1-$2");
            }
            return value.substring(0, 18);
        }

        const telInput = document.getElementById('tel_mask');
        const docInput = document.getElementById('doc_mask');

        if (telInput) {
            telInput.addEventListener('input', (e) => {
                e.target.value = applyPhoneMask(e.target.value);
            });
        }

        if (docInput) {
            docInput.addEventListener('input', (e) => {
                e.target.value = applyDocMask(e.target.value);
            });
        }

        // Formatação inicial ao carregar (para Edição)
        window.addEventListener('DOMContentLoaded', () => {
            if (telInput && telInput.value) telInput.value = applyPhoneMask(telInput.value);
            if (docInput && docInput.value) docInput.value = applyDocMask(docInput.value);
        });
        // Busca de CEP automática
        const cepInput = document.getElementById('cep_mask');
        if (cepInput) {
            cepInput.addEventListener('blur', (e) => {
                const cep = e.target.value.replace(/\D/g, '');
                if (cep.length === 8) {
                    fetch(`https://viacep.com.br/ws/${cep}/json/`)
                        .then(res => res.json())
                        .then(data => {
                            if (!data.erro) {
                                document.getElementById('logradouro').value = data.logradouro;
                                document.getElementById('bairro').value = data.bairro;
                                document.getElementById('cidade').value = data.localidade;
                                document.getElementById('uf').value = data.uf;
                            }
                        });
                }
            });
        }

        // Máscara de CEP simples
        cepInput.addEventListener('input', (e) => {
            let v = e.target.value.replace(/\D/g, '');
            v = v.replace(/^(\d{5})(\d)/, '$1-$2');
            e.target.value = v.substring(0, 9);
        });
    </script>
@endpush
