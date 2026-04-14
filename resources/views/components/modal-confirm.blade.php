<div id="modal-delete"
    class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-black/60 backdrop-blur-sm transition-all">

    <div class="bg-white w-full max-w-sm rounded-[2.5rem] shadow-2xl overflow-hidden transform transition-all scale-95 opacity-0 duration-300"
        id="modal-content">

        <div class="p-8 text-center">
            {{-- Ícone Dinâmico --}}
            <div id="modal-icon-container"
                class="mx-auto w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mb-6 text-red-500">
                <i id="modal-icon" data-lucide="trash-2" class="w-10 h-10"></i>
            </div>

            <h3 id="modal-title" class="text-xl font-black text-gray-900 uppercase italic mb-2 tracking-tight">
                Excluir Registro?
            </h3>
            <p id="modal-description" class="text-gray-500 text-sm font-medium leading-relaxed">
                Esta ação não pode ser desfeita e o registro será removido permanentemente.
            </p>
        </div>

        {{-- Ações --}}
        <div class="flex border-t border-gray-100">
            <button onclick="closeDeleteModal()"
                class="flex-1 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 hover:bg-gray-50 transition-colors">
                Cancelar
            </button>
            <div class="w-px bg-gray-100"></div>
            <form id="form-delete-modal" method="POST" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full py-6 text-[10px] font-black uppercase tracking-[0.2em] text-red-500 hover:bg-red-50 transition-colors">
                    Confirmar
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    /**
     * Abre a modal de confirmação de forma genérica
     * @param {string} url - URL de destino do form (route destroy)
     * @param {string} title - Título da modal
     * @param {string} description - Texto de apoio
     * @param {string} icon - Nome do ícone Lucide (opcional)
     */
    function openDeleteModal(url, title = 'Excluir Registro?', description = 'Esta ação não pode ser desfeita.', icon =
        'trash-2') {
        const modal = document.getElementById('modal-delete');
        const content = document.getElementById('modal-content');
        const form = document.getElementById('form-delete-modal');

        // Atualiza os textos dinamicamente
        document.getElementById('modal-title').innerText = title;
        document.getElementById('modal-description').innerText = description;
        form.action = url;

        // Atualiza o ícone (Lucide)
        const iconElement = document.getElementById('modal-icon');
        iconElement.setAttribute('data-lucide', icon);
        if (window.lucide) lucide.createIcons();

        // Exibe a modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeDeleteModal() {
        const modal = document.getElementById('modal-delete');
        const content = document.getElementById('modal-content');

        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    }

    document.getElementById('modal-delete').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });
</script>
