<?php

namespace App\Policies;

use App\Models\Municipio;
use App\Models\User;

class MunicipioPolicy
{
    /**
     * Quem pode ver a lista de municípios (Ex: Para filtros de busca ou relatórios)
     */
    public function viewAny(User $user): bool
    {
        // Superadmin, Segurança e Gestor podem ver que os municípios existem.
        // O Produtor não precisa listar municípios do estado inteiro.
        return $user->isSuperAdmin() || $user->isSeguranca() || $user->isGestor();
    }

    /**
     * Quem pode ver os detalhes de configuração de um município específico
     */
    public function view(User $user, Municipio $municipio): bool
    {
        if ($user->isSuperAdmin() || $user->isSeguranca()) return true;

        // Gestor só vê os detalhes do seu próprio município
        if ($user->isGestor()) {
            return $user->municipio_id === $municipio->id;
        }

        return false;
    }

    /**
     * Quem pode criar um novo município no sistema
     */
    public function create(User $user): bool
    {
        // Somente o "Dono do Software" (SuperAdmin)
        return $user->isSuperAdmin();
    }

    /**
     * Quem pode alterar as configurações (Brasão, Validade, etc)
     */
    public function update(User $user, Municipio $municipio): bool
    {
        if ($user->isSuperAdmin()) return true;

        // Opcional: Permitir que o Gestor edite os dados do SEU município
        if ($user->isGestor()) {
            return $user->municipio_id === $municipio->id;
        }

        return false;
    }

    /**
     * Quem pode apagar um município do mapa
     */
    public function delete(User $user, Municipio $municipio): bool
    {
        // Apenas SuperAdmin e apenas se não houver vínculos (o banco cuidará disso)
        return $user->isSuperAdmin();
    }
}
