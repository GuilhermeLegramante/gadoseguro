<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca;
use App\Models\Municipio;
use App\Models\Produtor;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class MarcaController extends Controller
{
    public function __construct()
    {
        // Isso vincula automaticamente as ações do Controller aos métodos da Policy
        $this->authorizeResource(Marca::class, 'marca');
    }

    public function index(Request $request)
    {
        $query = Marca::with(['produtor', 'municipio']);

        // Filtros de texto
        if ($request->filled('nome')) {
            $query->whereHas('produtor', function ($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->nome . '%');
            });
        }

        if ($request->filled('numero')) {
            $query->where('numero', $request->numero);
        }

        if ($request->filled('municipio_id')) {
            $query->where('municipio_id', $request->municipio_id);
        }

        // Busca Visual (Quadrantes)
        if ($request->filled('q1')) {
            $pesos = [];
            for ($i = 1; $i <= 9; $i++) {
                $pesos[$i] = (float) $request->input("q$i");
            }

            $rawSql = "(";
            foreach ($pesos as $i => $valor) {
                $rawSql .= "ABS(q$i - $valor) + ";
            }
            $rawSql = rtrim($rawSql, " + ") . ") as distancia_visual";

            $query->select('*')->selectRaw($rawSql);
            $query->orderBy('distancia_visual', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $marcas = $query->paginate(12)->withQueryString();
        $municipios = Municipio::orderBy('nome')->get();

        return view('marcas.index', compact('marcas', 'municipios'));
    }

    public function create()
    {
        $user = auth()->user();

        // Se o usuário não tiver município, pegamos o primeiro do banco como padrão
        // ou redirecionamos com um erro amigável.
        $municipioGestor = $user->municipio ?? \App\Models\Municipio::first();

        if (!$municipioGestor) {
            return redirect()->back()->with('error', 'Nenhum município cadastrado no sistema.');
        }

        $municipios = \App\Models\Municipio::all();

        return view('marcas.form', compact('municipios', 'municipioGestor'));
    }

    public function edit($id)
    {
        $marca = Marca::findOrFail($id);
        $municipios = Municipio::orderBy('nome')->get();
        $produtores = Produtor::orderBy('nome')->get();

        // Se o desenho_vetor for um array/objeto no Model (cast json), 
        // a view vai precisar dele como string JSON para o SignaturePad
        if (is_array($marca->desenho_vetor)) {
            $marca->desenho_vetor = json_encode($marca->desenho_vetor);
        }

        return view('marcas.form', compact('marca', 'municipios', 'produtores'));
    }

    public function store(Request $request)
    {
        $this->validarMarca($request);

        $desenho = json_decode($request->desenho_vetor, true);
        $dadosBiometricos = $this->processarDesenho($desenho);

        // --- LÓGICA DE SALVAMENTO DA FOTO ---
        $path = null;

        if ($request->filled('foto_final')) {
            // 1. Prioridade para a foto editada na suíte (Base64)
            $base64Image = $request->foto_final;

            // Extrai a extensão e os dados
            // Formato esperado: data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAA...
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
                $image = substr($base64Image, strpos($base64Image, ',') + 1);
                $type = strtolower($type[1]); // png, jpg, etc

                $image = str_replace(' ', '+', $image);
                $imageName = 'marca_' . time() . '_' . uniqid() . '.' . $type;
                $path = 'marcas/' . $imageName;

                Storage::disk('public')->put($path, base64_decode($image));
            }
        } elseif ($request->hasFile('foto')) {
            // 2. Fallback para upload direto caso a edição não tenha sido usada
            $path = $request->file('foto')->store('marcas', 'public');
        }

        // --- CRIAÇÃO DO REGISTRO ---
        $marca = Marca::create(array_merge([
            'produtor_id'   => $request->produtor_id,
            'municipio_id'  => $request->municipio_id,
            'numero'        => $request->numero,
            'ano'           => $request->ano,
            'desenho_vetor' => $desenho,
            'foto_path'     => $path, // Caminho salvo no storage
        ], $dadosBiometricos));

        // Se houver sócios selecionados, vincula na tabela pivot
        if ($request->has('socios')) {
            $marca->socios()->sync($request->socios);
        }

        return redirect()->route('marcas.index')->with('success', 'Marca registrada com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $marca = Marca::findOrFail($id);
        $this->validarMarca($request, $id);

        $desenho = json_decode($request->desenho_vetor, true);
        $dadosBiometricos = $this->processarDesenho($desenho);

        // Gerenciar Foto
        $path = $marca->foto_path;
        if ($request->hasFile('foto')) {
            if ($path) Storage::disk('public')->delete($path);
            $path = $request->file('foto')->store('marcas', 'public');
        }

        $marca->update(array_merge([
            'produtor_id' => $request->produtor_id,
            'municipio_id' => $request->municipio_id,
            'numero' => $request->numero,
            'ano' => $request->ano,
            'desenho_vetor' => $desenho,
            'foto_path' => $path,
        ], $dadosBiometricos));

        return redirect()->route('marcas.index')->with('success', 'Marca atualizada com sucesso!');
    }

    private function validarMarca(Request $request, $id = null)
    {
        return $request->validate([
            'desenho_vetor' => 'required',
            'produtor_id'   => 'required|exists:produtores,id',
            'municipio_id'  => 'required|exists:municipios,id',
            'numero'        => 'required',
            'ano'           => 'required|integer',
            'foto'          => 'nullable|image|max:2048'
        ]);
    }

    private function processarDesenho($desenho)
    {
        if (empty($desenho)) return [];

        $tracosValidos = array_filter($desenho, fn($t) => isset($t['points']) && count($t['points']) > 1);
        $pontos = [];
        foreach ($tracosValidos as $t) {
            $pontos = array_merge($pontos, $t['points']);
        }

        if (empty($pontos)) return [];

        $x = array_column($pontos, 'x');
        $y = array_column($pontos, 'y');
        $minX = min($x);
        $maxX = max($x);
        $minY = min($y);
        $maxY = max($y);
        $w = ($maxX - $minX) ?: 1;
        $h = ($maxY - $minY) ?: 1;

        $quadrantes = array_fill(1, 9, 0);
        foreach ($pontos as $p) {
            $col = min(2, floor((($p['x'] - $minX) / $w) * 3));
            $lin = min(2, floor((($p['y'] - $minY) / $h) * 3));
            $idx = ($lin * 3) + $col + 1;
            $quadrantes[$idx]++;
        }

        $total = count($pontos);
        $retorno = ['qtd_tracos' => count($tracosValidos)];
        foreach ($quadrantes as $i => $qtd) {
            $retorno["q$i"] = round($qtd / $total, 4);
        }

        return $retorno;
    }

    public function show($id)
    {
        $marca = Marca::with(['produtor', 'municipio'])->findOrFail($id);
        return view('marcas.show', compact('marca'));
    }

    public function destroy($id)
    {
        $marca = Marca::findOrFail($id);

        // Deleta a foto do storage se existir
        if ($marca->foto_path) {
            Storage::disk('public')->delete($marca->foto_path);
        }

        $marca->delete();
        return redirect()->route('marcas.index')->with('success', 'Marca excluída com sucesso!');
    }

    public function gerarTitulo($id)
    {
        // Buscamos a marca com todos os relacionamentos necessários
        $marca = Marca::with(['produtor', 'municipio', 'socios'])->findOrFail($id);

        // Carregamos a view e passamos os dados
        $pdf = Pdf::loadView('pdf.titulo_marca', compact('marca'))
            ->setPaper('a4', 'portrait');

        // Retorna o PDF para abrir no navegador
        return $pdf->stream("titulo-marca-{$marca->numero}.pdf");
    }

    public function verificarQrCode($id)
    {
        $marca = Marca::with(['produtor', 'municipio'])->findOrFail($id);

        return view('marcas.verificar-qrcode', compact('marca'));
    }
}
