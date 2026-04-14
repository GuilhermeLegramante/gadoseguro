<?php

namespace App\Http\Controllers;

use App\Models\Municipio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class MunicipioController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Municipio::class, 'municipio');
    }

    /**
     * Lista os municípios (Apenas SuperAdmin ou perfis de consulta)
     */
    public function index()
    {
        // Se não for SuperAdmin ou Segurança, redireciona ou barra
        if (!Auth::user()->isSuperAdmin() && !Auth::user()->isSeguranca()) {
            return redirect()->route('dashboard')->with('error', 'Acesso não autorizado.');
        }

        $municipios = Municipio::orderBy('nome')->paginate(5);
        return view('municipios.index', compact('municipios'));
    }

    /**
     * Exibe o formulário de criação (Apenas SuperAdmin)
     */
    public function create()
    {
        if (!Auth::user()->isSuperAdmin()) abort(403);

        return view('municipios.create');
    }

    /**
     * Salva um novo município
     */
    public function store(Request $request)
    {
        if (!Auth::user()->isSuperAdmin()) abort(403);

        $validated = $request->validate([
            'nome' => 'required|string|max:255|unique:municipios',
            'departamento_nome' => 'nullable|string|max:255',
            'prazo_validade_anos' => 'required|integer|min:1',
            'orgao_cnpj' => 'nullable|string|max:20',
            'orgao_endereco' => 'nullable|string|max:500',
            'orgao_telefone' => 'nullable|string|max:20',
            'brasao' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($request->hasFile('brasao')) {
            $validated['brasao_path'] = $request->file('brasao')->store('brasoes', 'public');
        }

        Municipio::create($validated);

        return redirect()->route('municipios.index')->with('success', 'Município cadastrado com sucesso!');
    }

    /**
     * Exibe os detalhes do município
     */
    public function show(Municipio $municipio)
    {
        return view('municipios.show', compact('municipio'));
    }

    /**
     * Formulário de edição (SuperAdmin ou Gestor do próprio município)
     */
    public function edit(Municipio $municipio)
    {
        // Segurança: Gestor só edita o dele, SuperAdmin edita qualquer um
        if (Auth::user()->isGestor() && Auth::user()->municipio_id !== $municipio->id) {
            abort(403, 'Você só pode editar as configurações do seu próprio município.');
        }

        return view('municipios.edit', compact('municipio'));
    }

    /**
     * Atualiza os dados do município
     */
    public function update(Request $request, Municipio $municipio)
    {
        if (Auth::user()->isGestor() && Auth::user()->municipio_id !== $municipio->id) {
            abort(403);
        }

        $validated = $request->validate([
            'nome' => 'required|string|max:255|unique:municipios,nome,' . $municipio->id,
            'departamento_nome' => 'nullable|string|max:255',
            'prazo_validade_anos' => 'required|integer|min:1',
            'orgao_cnpj' => 'nullable|string|max:20',
            'orgao_endereco' => 'nullable|string|max:500',
            'orgao_telefone' => 'nullable|string|max:20',
            'brasao' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($request->hasFile('brasao')) {
            // Deleta o brasão antigo se existir
            if ($municipio->brasao_path) {
                Storage::disk('public')->delete($municipio->brasao_path);
            }
            $validated['brasao_path'] = $request->file('brasao')->store('brasoes', 'public');
        }

        $municipio->update($validated);

        // Se for gestor, volta para o dashboard ou para a própria página de edição
        if (Auth::user()->isGestor()) {
            return back()->with('success', 'Configurações atualizadas com sucesso!');
        }

        return redirect()->route('municipios.index')->with('success', 'Dados atualizados!');
    }

    /**
     * Remove um município (Apenas SuperAdmin)
     */
    public function destroy(Municipio $municipio)
    {
        if (!Auth::user()->isSuperAdmin()) abort(403);

        if ($municipio->brasao_path) {
            Storage::disk('public')->delete($municipio->brasao_path);
        }

        $municipio->delete();

        return redirect()->route('municipios.index')->with('success', 'Município removido.');
    }
}
