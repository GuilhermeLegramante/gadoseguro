<?php

namespace App\Http\Controllers;

use App\Models\Produtor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdutorController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Inicia a query com contagem de marcas
        $query = Produtor::withCount('marcas');

        // --- Filtros de Segurança / Perfil ---
        if ($user->isProdutor()) {
            $query->where('user_id', $user->id);
        }
        // Se for gestor, ele pode ver todos para consulta, 
        // mas a Policy (que já fizemos) impedirá de editar os de fora.

        // --- Filtros de Busca ---
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'LIKE', "%{$search}%")
                    ->orWhere('cpf_cnpj', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('municipio')) {
            $query->where('municipio_id', $request->municipio);
        }

        $produtores = $query->paginate(15)->withQueryString();

        // Lista de municípios para o select do filtro
        $municipios = \App\Models\Municipio::orderBy('nome')->get();

        return view('produtores.index', compact('produtores', 'municipios'));
    }

    public function create()
    {
        return view('produtores.form');
    }

    public function store(Request $request)
    {
        // 1. Validação robusta (Pessoais + Endereço)
        $dados = $request->validate([
            'nome'               => 'required|string|max:255',
            'cpf_cnpj'           => 'required|string|unique:produtores,cpf_cnpj',
            'telefone'           => 'nullable|string',
            'email'              => 'nullable|email',
            'genero'             => 'nullable|string',
            'data_nascimento'    => 'nullable|date',
            'inscricao_estadual' => 'nullable|string',

            // Campos do Endereço
            'cep'         => 'required|string|max:9',
            'logradouro'  => 'required|string|max:255',
            'numero'      => 'required|string|max:10',
            'complemento' => 'nullable|string|max:255',
            'bairro'      => 'required|string|max:255',
            'cidade'      => 'required|string|max:255',
            'uf'          => 'required|string|size:2',
        ]);

        if (!$request->has('municipio_id')) {
            $request->merge(['municipio_id' => auth()->user()->municipio_id]);
        }

        // Usamos Transaction para segurança total dos dados
        DB::transaction(function () use ($dados) {
            // 2. Criar o Produtor
            $produtor = Produtor::create([
                'nome'               => $dados['nome'],
                'cpf_cnpj'           => $dados['cpf_cnpj'],
                'telefone'           => $dados['telefone'],
                'email'              => $dados['email'],
                'genero'             => $dados['genero'],
                'data_nascimento'    => $dados['data_nascimento'],
                'inscricao_estadual' => $dados['inscricao_estadual'],
                'municipio_id'       => 1, // Seu padrão
            ]);

            // 3. Criar o Endereço vinculado
            $produtor->endereco()->create([
                'cep'         => $dados['cep'],
                'logradouro'  => $dados['logradouro'],
                'numero'      => $dados['numero'],
                'complemento' => $dados['complemento'],
                'bairro'      => $dados['bairro'],
                'cidade'      => $dados['cidade'],
                'uf'          => $dados['uf'],
            ]);
        });

        return redirect()->route('produtores.index')->with('success', 'Produtor cadastrado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $produtor = Produtor::findOrFail($id);

        $dados = $request->validate([
            'nome'               => 'required|string|max:255',
            'cpf_cnpj'           => 'required|unique:produtores,cpf_cnpj,' . $id,
            'telefone'           => 'nullable|string',
            'email'              => 'nullable|email',
            'genero'             => 'nullable|string',
            'data_nascimento'    => 'nullable|date',
            'inscricao_estadual' => 'nullable|string',

            // Campos do Endereço
            'cep'         => 'required|string|max:9',
            'logradouro'  => 'required|string|max:255',
            'numero'      => 'required|string|max:10',
            'complemento' => 'nullable|string|max:255',
            'bairro'      => 'required|string|max:255',
            'cidade'      => 'required|string|max:255',
            'uf'          => 'required|string|size:2',
        ]);

        DB::transaction(function () use ($produtor, $dados) {
            // Atualiza o Produtor
            $produtor->update($dados);

            // Atualiza ou Cria o Endereço (updateOrCreate previne erros se o endereço não existir)
            $produtor->endereco()->updateOrCreate(
                ['produtor_id' => $produtor->id],
                [
                    'cep'         => $dados['cep'],
                    'logradouro'  => $dados['logradouro'],
                    'numero'      => $dados['numero'],
                    'complemento' => $dados['complemento'],
                    'bairro'      => $dados['bairro'],
                    'cidade'      => $dados['cidade'],
                    'uf'          => $dados['uf'],
                ]
            );
        });

        return redirect()->route('produtores.index')->with('success', 'Dados atualizados com sucesso!');
    }

    public function edit($id)
    {
        $produtor = Produtor::findOrFail($id);
        return view('produtores.form', compact('produtor'));
    }

    public function show($id)
    {
        // Buscamos o produtor carregando junto suas marcas e o município de cada marca
        // Isso evita o erro de performance "N+1"
        $produtor = Produtor::with(['marcas.municipio'])->findOrFail($id);

        return view('produtores.show', compact('produtor'));
    }

    public function buscar(Request $request)
    {
        // Pega o termo e remove espaços extras
        $termo = trim($request->get('q'));

        if (empty($termo)) {
            return response()->json([]);
        }

        // Usamos o query builder para garantir que a busca seja limpa
        $produtores = \App\Models\Produtor::query()
            ->where(function ($query) use ($termo) {
                $query->where('nome', 'LIKE', '%' . $termo . '%')
                    ->orWhere('cpf_cnpj', 'LIKE', '%' . $termo . '%');
            })
            ->limit(15)
            ->get(['id', 'nome', 'cpf_cnpj']);

        // DEBUG: Se você quiser testar se está vindo algo, descomente a linha abaixo e olhe o F12
        // \Log::info('Busca realizada para: ' . $termo . ' - Resultados: ' . $produtores->count());

        return response()->json($produtores);
    }
}
