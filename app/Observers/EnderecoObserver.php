<?php

namespace App\Observers;

use App\Models\Endereco;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class EnderecoObserver
{
    public function updated(Endereco $endereco)
    {
        $changes = $endereco->getChanges();
        unset($changes['updated_at']);

        if (empty($changes)) return;

        $oldData = array_intersect_key($endereco->getOriginal(), $changes);

        ActivityLog::create([
            'user_id'     => Auth::id(),
            'log_type'    => 'edicao',
            'model_type'  => 'Produtor', // Vinculamos ao Produtor para facilitar a busca
            'model_id'    => $endereco->produtor_id,
            'old_data'    => $oldData,
            'new_data'    => $changes,
            'description' => "Atualizou o endereço do produtor ID: {$endereco->produtor_id}",
            'ip_address'  => request()->ip(),
        ]);
    }
}
