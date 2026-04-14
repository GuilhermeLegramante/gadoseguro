<?php

namespace App\Observers;

use App\Models\Marca;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class MarcaObserver
{
    public function created(Marca $marca)
    {
        $this->log($marca, 'cadastro', null, $marca->toArray(), "Marca registrada para {$marca->produtor->nome}" .
            ($marca->socios->count() > 0 ? " em sociedade com " . $marca->socios->pluck('nome')->implode(', ') : ""));
    }

    public function updated(Marca $marca)
    {
        // Pega apenas o que mudou de fato
        $oldData = array_intersect_key($marca->getOriginal(), $marca->getChanges());
        $newData = $marca->getChanges();

        $municipio = $marca->municipio->nome ?? 'N/D';

        $this->log(
            $marca,
            'edicao',
            $oldData,
            $newData,
            "Editou dados da marca #{$marca->id} no município de {$municipio}"
        );
    }

    public function deleted(Marca $marca)
    {
        $this->log($marca, 'exclusao', $marca->toArray(), null, "Excluiu a marca ID: {$marca->id}");
    }

    private function log($model, $type, $old, $new, $description)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'log_type' => $type,
            'model_type' => class_basename($model),
            'model_id' => $model->id,
            'old_data' => $old,
            'new_data' => $new,
            'description' => $description,
            'ip_address' => request()->ip(),
        ]);
    }
}
