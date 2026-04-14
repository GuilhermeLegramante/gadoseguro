<?php

namespace App\Policies;

use App\Models\Produtor;
use App\Models\User;

class ProdutorPolicy
{
    /**
     * Quem pode ver a LISTAGEM de produtores.
     */
    public function viewAny(User $user): bool
    {
        // Superadmin, Segurança e Gestores podem ver a lista.
        // O próprio Produtor não precisa ver a "lista de outros produtores", 
        // ele geralmente é redirecionado direto para o seu 'show'.
        return !$user->isProdutor();
    }

    /**
     * Quem pode ver os DETALHES de um produtor.
     */
    public function view(User $user, Produtor $produtor): bool
    {
        if ($user->isSuperAdmin() || $user->isSeguranca() || $user->isGestor()) {
            return true;
        }

        // O produtor só vê a si mesmo
        return $user->id === $produtor->user_id;
    }

    /**
     * Quem pode CADASTRAR um novo produtor.
     */
    public function create(User $user): bool
    {
        // Apenas quem gerencia o sistema (Super e Gestor)
        return $user->isSuperAdmin() || $user->isGestor();
    }

    /**
     * Quem pode ATUALIZAR os dados.
     */
    public function update(User $user, Produtor $produtor): bool
    {
        if ($user->isSuperAdmin()) return true;

        if ($user->isGestor()) {
            // Gestor só edita produtores do seu município
            return $user->municipio_id === $produtor->municipio_id;
        }

        if ($user->isProdutor()) {
            // Produtor pode atualizar seus próprios dados pessoais
            return $user->id === $produtor->user_id;
        }

        return false;
    }

    /**
     * Quem pode EXCLUIR um produtor.
     */
    public function delete(User $user, Produtor $produtor): bool
    {
        if ($user->isSuperAdmin()) return true;

        if ($user->isGestor()) {
            // Gestor pode excluir se for do seu município
            return $user->municipio_id === $produtor->municipio_id;
        }

        // Produtor e Segurança NUNCA excluem nada
        return false;
    }
}
