<?php

namespace App\Policies;

use App\Models\Marca;
use App\Models\User;

class MarcaPolicy
{
    /**
     * Define quem pode ver a LISTAGEM de marcas (index)
     */
    public function viewAny(User $user): bool
    {
        // Todos os perfis logados podem ver a lista, 
        // mas o filtro do que aparece (município ou apenas o próprio) 
        // deve ser feito no Controller via Query.
        return true;
    }

    /**
     * Define quem pode ver os DETALHES de uma marca específica (show)
     */
    public function view(User $user, Marca $marca): bool
    {
        if ($user->isSuperAdmin() || $user->isSeguranca() || $user->isGestor()) {
            return true;
        }

        if ($user->isProdutor()) {
            // Produtor só vê se a marca for dele
            return $user->id === ($marca->produtor->user_id ?? null);
        }

        return false;
    }

    /**
     * Define quem pode ver o formulário e SALVAR uma nova marca
     */
    public function create(User $user): bool
    {
        // Apenas SuperAdmin e Gestores podem criar marcas.
        // Segurança e Produtores não criam registros de marcas.
        return $user->isSuperAdmin() || $user->isGestor();
    }

    /**
     * Define quem pode EDITAR uma marca
     */
    public function update(User $user, Marca $marca): bool
    {
        if ($user->isSuperAdmin()) return true;

        if ($user->isGestor()) {
            // Gestor só edita se a marca for do município dele
            return $user->municipio_id === $marca->municipio_id;
        }

        return false;
    }

    /**
     * Define quem pode EXCLUIR uma marca
     */
    public function delete(User $user, Marca $marca): bool
    {
        if ($user->isSuperAdmin()) return true;

        if ($user->isGestor()) {
            // Gestor só exclui se a marca for do município dele
            return $user->municipio_id === $marca->municipio_id;
        }

        return false;
    }
}
