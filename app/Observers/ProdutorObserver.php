<?php

namespace App\Observers;

use App\Models\Produtor;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ProdutorObserver
{
    public function created(Produtor $produtor)
    {
        // Carrega o endereço para que o log de criação seja completo
        $produtor->load('endereco');

        $this->log(
            $produtor,
            'cadastro',
            null,
            $produtor->toArray(),
            "Cadastrou o produtor: {$produtor->nome} com dados completos e endereço."
        );
    }

    public function updated(Produtor $produtor)
    {
        $changes = $produtor->getChanges();
        unset($changes['updated_at']);

        // Se mudou algo no model Produtor (Nome, Email, IE, etc)
        if (!empty($changes)) {
            $oldData = array_intersect_key($produtor->getOriginal(), $changes);

            $this->log(
                $produtor,
                'edicao',
                $oldData,
                $changes,
                "Atualizou dados cadastrais de: {$produtor->nome}"
            );
        }
    }

    private function log($model, $type, $old, $new, $description)
    {
        ActivityLog::create([
            'user_id'     => Auth::id(),
            'log_type'    => $type,
            'model_type'  => 'Produtor',
            'model_id'    => $model->id,
            'old_data'    => $old,
            'new_data'    => $new,
            'description' => $description,
            'ip_address'  => request()->ip(),
        ]);
    }
    
    public function deleted(Produtor $produtor)
    {
        $this->log(
            $produtor,
            'exclusao',
            $produtor->toArray(),
            null,
            "Removeu o produtor: {$produtor->nome} (ID: {$produtor->id})"
        );
    }
}
