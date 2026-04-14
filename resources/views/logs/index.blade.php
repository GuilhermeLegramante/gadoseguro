@extends('layouts.app')
@section('title', 'Auditoria do Sistema')

@section('content')
    <div class="space-y-6">
        <x-index-header title="Logs de" titleHighlight="Atividade" subtitle="Rastreabilidade completa de ações no sistema"
            icon="history" />

        <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Data /
                                Usuário</th>
                            <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Ação</th>
                            <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Descrição
                            </th>
                            <th class="px-6 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Detalhes
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($logs as $log)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-xs font-black text-gray-800">{{ $log->created_at->format('d/m/Y H:i') }}</span>
                                        <span
                                            class="text-[10px] font-bold text-green-600 uppercase">{{ $log->user->name ?? 'Sistema' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $colors = [
                                            'cadastro' => 'bg-green-100 text-green-700',
                                            'edicao' => 'bg-blue-100 text-blue-700',
                                            'exclusao' => 'bg-red-100 text-red-700',
                                        ];
                                    @endphp
                                    <span
                                        class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-tighter {{ $colors[$log->log_type] ?? 'bg-gray-100 text-gray-600' }}">
                                        {{ $log->log_type }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <span class="p-1.5 bg-gray-100 rounded-lg text-gray-400">
                                            <i data-lucide="database" class="w-3 h-3"></i>
                                        </span>
                                        <p class="text-xs font-medium text-gray-600">{{ $log->description }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    {{-- Botão para ver o JSON de mudanças caso seja Edição --}}
                                    @if ($log->log_type === 'edicao')
                                        <button
                                            onclick='showLogDetail(@json($log->old_data), @json($log->new_data))'
                                            class="p-2 bg-gray-50 hover:bg-gray-100 rounded-xl transition-all">
                                            <i data-lucide="eye" class="w-4 h-4 text-gray-400"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-20 text-center text-gray-400 italic text-sm">
                                    Nenhuma atividade registrada até o momento.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="custom-pagination mt-6 flex justify-center">
            {{ $logs->links() }}
        </div>
    </div>

    {{-- Modal Simples para ver o "De / Para" da edição --}}
    <div id="logModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-[2rem] max-w-2xl w-full p-8 shadow-2xl">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-black text-[#064e3b] uppercase italic">Alterações Realizadas</h3>
                <button onclick="closeLogModal()" class="text-gray-400 hover:text-gray-600"><i data-lucide="x"></i></button>
            </div>
            <div id="logContent"
                class="grid grid-cols-2 gap-6 text-xs font-mono bg-gray-50 p-6 rounded-2xl overflow-auto max-h-[60vh]">
                {{-- Injetado via JS --}}
            </div>
        </div>
    </div>

    <script>
        function showLogDetail(oldData, newData) {
            const content = document.getElementById('logContent');
            content.innerHTML = `
            <div><p class="font-black mb-2 uppercase text-red-500">Anterior:</p><pre>${JSON.stringify(oldData, null, 2)}</pre></div>
            <div><p class="font-black mb-2 uppercase text-green-500">Novo:</p><pre>${JSON.stringify(newData, null, 2)}</pre></div>
        `;
            document.getElementById('logModal').classList.remove('hidden');
        }

        function closeLogModal() {
            document.getElementById('logModal').classList.add('hidden');
        }
    </script>
@endsection
