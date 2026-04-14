<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ActivityLogController extends Controller
{
    /**
     * Exibe a listagem de logs de auditoria.
     */
    public function index()
    {
        // Garante que apenas o SuperAdmin acesse, mesmo se a rota falhar no middleware
        if (!Gate::allows('is-superadmin')) {
            abort(403, 'Acesso restrito aos administradores do sistema.');
        }

        // Carregamos o relacionamento 'user' para evitar o problema de N+1 consultas
        // Ordenamos pelos mais recentes primeiro (desc)
        $logs = ActivityLog::with('user')
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('logs.index', compact('logs'));
    }

    /**
     * Opcional: Método para limpar logs antigos (ex: mais de 90 dias)
     * Útil para não inflar o banco de dados desnecessariamente.
     */
    public function cleanup()
    {
        if (!Gate::allows('is-superadmin')) abort(403);

        $date = now()->subDays(90);
        ActivityLog::where('created_at', '<', $date)->delete();

        return back()->with('success', 'Logs antigos removidos com sucesso.');
    }
}
