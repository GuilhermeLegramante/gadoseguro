<?php

namespace App\Providers;

use App\Models\Marca;
use App\Models\Produtor;
use App\Models\Municipio;
use App\Policies\MarcaPolicy;
use App\Policies\ProdutorPolicy;
use App\Policies\MunicipioPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * O mapeamento de Modelos para Policies.
     */
    protected $policies = [
        Marca::class => MarcaPolicy::class,
        Produtor::class => ProdutorPolicy::class,
        Municipio::class => MunicipioPolicy::class,
    ];

    /**
     * Registre qualquer serviço de autenticação / autorização.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // DICA DE OURO: O "Super Gate"
        // Isso permite que o SuperAdmin ignore todas as checagens das Policies
        // sem você precisar escrever "if($user->isSuperAdmin())" em todos os métodos da Policy.
        Gate::before(function ($user, $ability) {
            return $user->isSuperAdmin() ? true : null;
        });

        // Define o que é ser um "is-superadmin" para o sistema
        Gate::define('is-superadmin', function ($user) {
            return $user->role === 'superadmin'; // Ou $user->isSuperAdmin()
        });
    }
}
